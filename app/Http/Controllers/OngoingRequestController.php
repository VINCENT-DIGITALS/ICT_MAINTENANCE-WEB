<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\ServiceRequest;
use App\Models\Servicecategory;
use App\Models\Technician;
use App\Models\User;
use App\Models\RequestStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tickets;
use App\Models\PrimaryTechnicianRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SubCategory;
use App\Models\RequestStatus;
use App\Models\Problem;
use App\Models\Action;


class OngoingRequestController extends Controller
{
    // New function to fetch service requests with categories
    public function fetchOngoingRequests(Request $request, $status = 'ongoing')
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Replace the problematic line with direct user query
        $technicians = Technician::has('libTechnician')->get();

        $stations = Station::all();
        // Get current user's philrice_id
        $currentUserPhilriceId = auth()->user()->philrice_id;
        // Common relationships to eager load
        $withRelations = ['category', 'ticket', 'stations', 'latestStatus.status'];

        // Apply filters to both queries
        $filters = function ($query) use ($request) {
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }

            if ($request->filled('technician_id')) {
                $query->where('requester_id', $request->technician_id);
            }

            if ($request->filled('station_id')) {
                $query->whereHas('stations', function ($q) use ($request) {
                    $q->where('station_id', $request->station_id);
                });
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('request_title', 'like', '%' . $search . '%')
                        ->orWhere('request_description', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('ticket', function ($q) use ($search) {
                            $q->where('ticket_full', 'like', '%' . $search . '%');
                        });
                });
            }
        };

        // Fetch ongoing requests
        $ongoingRequests = ServiceRequest::ongoing()
            ->with($withRelations)
            ->where($filters)
            ->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
                $query->where('technician_emp_id', $currentUserPhilriceId);
            }) // Only include requests assigned to current user as technician
            ->get();

        // Fetch paused requests
        $pausedRequests = ServiceRequest::paused()
            ->with($withRelations)
            ->where($filters)
            ->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
                $query->where('technician_emp_id', $currentUserPhilriceId);
            }) // Only include requests assigned to current user as technician
            ->get();

        // Merge the two collections
        // Merge and sort by priority before mapping
        $combinedRequests = $ongoingRequests->merge($pausedRequests)
            ->sortByDesc(function ($request) {
                return $request->priority ?? 0; // You can adjust based on how priority is stored
            })
            ->map(function ($request) {
                return [
                    'id' => $request->ticket->ticket_full ?? 'N/A',
                    'subject' => $request->request_title ?? '',
                    'description' => $request->request_description ?? '',
                    'category' => $request->category->category_name ?? 'N/A',
                    'category_id' => $request->category_id ?? null,
                    'status' => ucfirst(strtolower($request->latestStatus->status->status_name ?? 'Unknown')),
                    'date_requested' => Carbon::parse($request->created_at)->format('Y-m-d'),
                    'time_requested' => Carbon::parse($request->created_at)->format('h:i A'),
                    'date_completion' => $request->completion_date ?? 'N/A',
                    'contact' => $request->local_no ?? 'N/A',
                    'requester' => $request->requester ? $request->requester->name : 'Unknown User',
                    'requester_id' => $request->requester ? $request->requester->id : null,
                    'request_id' => $request->id,
                    'ticket_number' => $request->ticket->ticket_full ?? '',
                    'office' => $request->location ?? 'N/A',
                    'priority' => $request->priority ?? null // Add this if you want to use it in the view
                ];
            })
            ->values()
            ->toArray();


        $ongoingRequestsCount = $ongoingRequests->count();

        // DO NOT map data here - pass the Eloquent collections directly
        return view('ICT Main/ongoing', [
            'combinedRequests' => $combinedRequests,  // Pass the raw collection
            'ongoingRequests' => $ongoingRequests,
            'categories' => $categories,
            'technicians' => $technicians,
            'ongoingRequestsCount' => $ongoingRequestsCount,
            'stations' => $stations
        ]);
    }

    public function changeToOngoing($id)
    {
        // $request = ServiceRequest::findOrFail($id);

        // // Update the service request status
        // $request->is_complete = 2;
        // $request->save();
        RequestStatus::where('request_id', $id)
            ->update(['status_id' => 5]);

        return response()->json([
            'success' => true,
            'message' => 'Service marked as picked and technician assigned.',
        ]);
    }
    public function markAsComplete(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
            ]);

            // Update the request status
            $statusUpdate = RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 7]); // Assuming 7 is your completed status ID

            if (!$statusUpdate) {
                throw new \Exception('Failed to update request status');
            }

            // Get the authenticated user's numeric ID, not philrice_id
            // With this:
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $userPhilriceId = $user->philrice_id;
            if (!$userPhilriceId) {
                throw new \Exception('User philrice_id not found');
            }

            // Save the status history with proper data type casting
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'completed',
                'changed_by' => $userPhilriceId, // Cast to integer
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                // 'created_by' => $userPhilriceId // Cast to integer
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as completed'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error completing request', [
                'request_id' => $request->request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsPaused(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
            ]);

            $statusUpdate = RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 6]);

            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $userPhilriceId = $user->philrice_id;
            if (!$userPhilriceId) {
                throw new \Exception('User philrice_id not found');
            }

            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'paused',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Service request marked as paused'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error pausing request', [
                'request_id' => $request->request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsDenied(Request $request)
    {
        try {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
            ]);

            // Update the request status
            $statusUpdate = RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 100]); // 6 is paused status

            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $userPhilriceId = $user->philrice_id;
            if (!$userPhilriceId) {
                throw new \Exception('User philrice_id not found');
            }

            // Save the status history with problems, actions, and remarks
            DB::table('request_status_history')->insert([
                'request_id' => $validated['request_id'],
                'status' => 'Denied',
                'changed_by' => $userPhilriceId, // Use the numeric user ID
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ?: null, // Ensure null if empty
                'action_id' => $validated['action_id'] ?: null, // Ensure null if empty
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as denied'
            ]);
        } catch (\Exception $e) {
            Log::error('Error denying request', [
                'request_id' => $request->request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsCancelled(Request $request)
    {
        try {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
            ]);

            // Update the request status
            $statusUpdate = RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 200]);
            // Get the authenticated user's ID (numeric user ID)
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $userPhilriceId = $user->philrice_id;
            if (!$userPhilriceId) {
                throw new \Exception('User philrice_id not found');
            }

            // Save the status history with problems, actions, and remarks
            DB::table('request_status_history')->insert([
                'request_id' => $validated['request_id'],
                'status' => 'cancelled',
                'changed_by' => $userPhilriceId, // Use the numeric user ID
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ?: null, // Ensure null if empty
                'action_id' => $validated['action_id'] ?: null, // Ensure null if empty
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as cancelled'
            ]);
        } catch (\Exception $e) {
            Log::error('Error cancelling request', [
                'request_id' => $request->request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsOngoing(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
            ]);

            // Update the request status
            $statusUpdate = RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 5]);

            if (!$statusUpdate) {
                throw new \Exception('Failed to update request status');
            }

            // Get the authenticated user's numeric ID, not philrice_id
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            $userPhilriceId = $user->philrice_id;
            if (!$userPhilriceId) {
                throw new \Exception('User philrice_id not found');
            }

            // Insert with proper data types
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'ongoing',
                'changed_by' => $userPhilriceId, // Cast to integer
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Service request marked as ongoing'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error changing request', [
                'request_id' => $request->request_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendMessageToClient(Request $request)
    {
        try {
            $validated = $request->validate([
                'recipient_id' => 'required',
                'service_request_id' => 'required',
                'subject' => 'required|string',
                'message' => 'required|string',
                'ticket_number' => 'nullable|string'
            ]);

            // Get the authenticated user's ID instead of philrice_id
            $user = auth()->user();

            // Insert message with proper data types
            DB::table('message_to_clients')->insert([
                'service_request_id' => (int)$validated['service_request_id'],
                'sender_id' => $user->id, // Use the numeric user ID instead of philrice_id
                'recipient_id' => (int)$validated['recipient_id'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ticket_number' => $validated['ticket_number'],
                'status' => 'ongoing', // Set status as 'ongoing' for messages sent from ongoing requests
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        } catch (\Exception $e) {
            // \Log::error('Message sending error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get problems by category for API
     */
    public function getProblemsByCategory($category_id)
    {
        try {
            Log::info('Fetching problems for category', ['category_id' => $category_id]);

            $problems = DB::table('lib_problems_encountered')
                ->where('is_archived', 0)
                ->select('id', 'encountered_problem_name')
                ->orderBy('encountered_problem_name')
                ->get();

            Log::info('Problems found:', ['count' => $problems->count()]);

            return response()->json($problems);
        } catch (\Exception $e) {
            Log::error('Error fetching problems', [
                'category_id' => $category_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch problems: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get actions by category for API
     */
    public function getActionsByCategory($category_id)
    {
        try {
            Log::info('Fetching actions for category', ['category_id' => $category_id]);

            $actions = DB::table('lib_actions_taken')
                ->where('is_archived', 0)
                ->select('id', 'action_name')
                ->orderBy('action_name')
                ->get();

            Log::info('Actions found:', ['count' => $actions->count()]);

            return response()->json($actions);
        } catch (\Exception $e) {
            Log::error('Error fetching actions', [
                'category_id' => $category_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch actions: ' . $e->getMessage()], 500);
        }
    }
}
