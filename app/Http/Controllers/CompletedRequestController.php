<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompletedRequestController extends Controller
{
    // New function to fetch service requests with categories
    public function fetchpCompleteRequests(Request $request)
    {
        // Fetch categories using Eloquent
        $categories = Servicecategory::pluck('category_name', 'id');

        // Fetch technicians
        $technicians = User::whereHas('role', function ($query) {
            $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
        })->get();

        // Fetch all stations
        $stations = Station::all();
        // Get current user's philrice_id
        $currentUserPhilriceId = auth()->user()->philrice_id;
        // Base query with eager loading
        $query = ServiceRequest::with([
            'category',
            'ticket',
            'stations',
            'requester',
            'latestStatus.status'
        ]);

        // Fetch only CPT, EVL, DND, CCL statuses
        $query->whereHas('latestStatus.status', function ($q) {
            $q->whereIn('status_abbr', ['CPT', 'EVL', 'DND', 'CCL']);
        });
        // Filter to only include requests assigned to current user as technician
        $query->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
            $query->where('technician_emp_id', $currentUserPhilriceId);
        });
        // Optional filters
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
            $query->where(function ($query) use ($search) {
                $query->where('request_title', 'like', '%' . $search . '%')
                    ->orWhere('request_description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('category_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('ticket', function ($q) use ($search) {
                        $q->where('ticket_full', 'like', '%' . $search . '%');
                    });
            });
        }


        $requests = ServiceRequest::completed()
            ->with([
                'category',
                'ticket',
                'requester',
                'statusHistory' => function ($query) {
                    $query->with(['problemEncountered', 'actionTaken'])
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->get();

        // Get all requests matching those 4 statuses
        $requests = $query->get();

        // Process each request to ensure problem and action info is attached
        $requests->map(function ($request) {
            $statusAbbr = optional($request->latestStatus->status)->status_abbr;

            // Set is_others based on status
            $request->is_others = in_array($statusAbbr, ['DND', 'CCL']);
            $request->is_evaluated = ($statusAbbr === 'EVL');
            $request->status_abbr = $statusAbbr;

            // Get latest request status history for this request
            // Make sure to get the appropriate status history based on the request status
            $statusToLookFor = '';
            if ($statusAbbr === 'CPT') {
                $statusToLookFor = 'completed';
            } elseif ($statusAbbr === 'EVL') {
                $statusToLookFor = 'completed'; // or 'evaluated' if that's used in your system
            } elseif ($statusAbbr === 'DND') {
                $statusToLookFor = 'Denied';
            } elseif ($statusAbbr === 'CCL') {
                $statusToLookFor = 'Cancelled';
            }

            $latestHistory = \App\Models\RequestStatusHistory::where('request_id', $request->id)
                ->where('status', $statusToLookFor)
                ->latest()
                ->first();

            if ($latestHistory) {
                // Get problem information
                if ($latestHistory->problem_id) {
                    $problemEncountered = \App\Models\LibProblemEncountered::find($latestHistory->problem_id);
                    $request->problem_name = $problemEncountered ? $problemEncountered->encountered_problem_name : 'Problem info not available';
                } else {
                    $request->problem_name = 'Problem info not available';
                }

                // Get action information
                if ($latestHistory->action_id) {
                    $actionTaken = \App\Models\Action::find($latestHistory->action_id);
                    $request->action_name = $actionTaken ? $actionTaken->action_name : 'Action info not available';
                } else {
                    $request->action_name = 'Action info not available';
                }

                // Set remarks
                $request->remarks = $latestHistory->remarks ?? 'Remarks not available';
            } else {
                // Fallback to an older method if needed - look for ANY status history
                $fallbackHistory = \App\Models\RequestStatusHistory::where('request_id', $request->id)
                    ->latest()
                    ->first();

                if ($fallbackHistory) {
                    // Process same as above but with fallback history
                    if ($fallbackHistory->problem_id) {
                        $problemEncountered = \App\Models\LibProblemEncountered::find($fallbackHistory->problem_id);
                        $request->problem_name = $problemEncountered ? $problemEncountered->encountered_problem_name : 'Problem info not available  ';
                    } else {
                        $request->problem_name = 'Problem info not available';
                    }

                    if ($fallbackHistory->action_id) {
                        $actionTaken = \App\Models\Action::find($fallbackHistory->action_id);
                        $request->action_name = $actionTaken ? $actionTaken->action_name : 'Action info not available';
                    } else {
                        $request->action_name = 'Action info not available';
                    }

                    $request->remarks = $fallbackHistory->remarks ?? 'Remarks not available';
                } else {
                    $request->problem_name = 'Problem info not available';
                    $request->action_name = 'Action info not available';
                    $request->remarks = 'Remarks not available';
                }
            }

            $request->statusLabel = match ($statusAbbr) {
                'CPT' => 'Completed',
                'EVL' => 'Evaluated',
                'DND' => 'Did Not Do',
                'CCL' => 'Cancelled',
                default => 'Unknown'
            };

            return $request;
        });

        $completedRequestsCount = $requests->count();

        return view('ICT Main/completed', compact(
            'requests',
            'categories',
            'technicians',
            'completedRequestsCount',
            'stations'
        ));
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

            // Get the authenticated user's ID
            $user = auth()->user();

            // Insert message with proper data types
            DB::table('message_to_clients')->insert([
                'service_request_id' => (int)$validated['service_request_id'],
                'sender_id' => $user->id, // Use the numeric user ID
                'recipient_id' => (int)$validated['recipient_id'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ticket_number' => $validated['ticket_number'],
                'status' => 'completed', // Set status as 'completed' for messages sent from completed requests
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
}
