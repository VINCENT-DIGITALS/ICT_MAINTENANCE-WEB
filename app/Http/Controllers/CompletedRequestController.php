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

        // Replace the problematic line with direct user query
        $technicians = Technician::has('libTechnician')->get();
        // Fetch all stations
        $stations = Station::all();
        // Get current user's philrice_id
        $currentUserPhilriceId = auth()->user()->philrice_id;
        // Check if current user is an admin (role_id = 1)
        $isAdmin = auth()->user()->role_id == 1;

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

        // Only filter by technician if not an admin
        if (!$isAdmin) {
            $query->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
                $query->where('technician_emp_id', $currentUserPhilriceId);
            });
        }

        // Optional filters
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('technician_id')) {
            $query->whereHas('primaryTechnician', function ($query) use ($request) {
                $query->where('technician_emp_id', $request->technician_id);
            });
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

    public function fetchRequestWithHistoryAndWorkingTime($id)
    {
        $serviceRequest = ServiceRequest::with([
            'category',
            'ticket',
            'stations',
            'latestStatus.status',
            'subCategory',
            'requester',
            'statusHistories' => function ($query) {
                $query->orderBy('created_at');
            }
        ])->findOrFail($id);

        // Get serial number and accountable for the service request
        $serialInfo = DB::table('request_serialnumber')
            ->where('request_id', $id)
            ->select('serial_number', 'accountable')
            ->first();

        // Add serial number and accountable to the service request object
        if ($serialInfo) {
            $serviceRequest->serial_number = $serialInfo->serial_number;
            $serviceRequest->accountable = $serialInfo->accountable;
        } else {
            $serviceRequest->serial_number = null;
            $serviceRequest->accountable = null;
        }

        // Get primary technician assigned to this request
        $primaryTechnician = DB::table('primarytechnician_request')
            ->where('request_id', $id)
            ->first();

        // Add technician name from users table if primary technician exists
        if ($primaryTechnician) {
            $primaryTechnicianUser = DB::table('users')
                ->where('philrice_id', $primaryTechnician->technician_emp_id)
                ->select('name', 'philrice_id')
                ->first();

            $primaryTechnician->technician_name = $primaryTechnicianUser ? $primaryTechnicianUser->name : 'Unknown';
        }

        // Get secondary technicians assigned to this request
        $secondaryTechnicians = DB::table('secondarytechnician_request')
            ->where('request_id', $id)
            ->get();

        // Add technician names for each secondary technician
        $secondaryTechnicians = $secondaryTechnicians->map(function ($tech) {
            $technicianUser = DB::table('users')
                ->where('philrice_id', $tech->technician_emp_id)
                ->select('name', 'philrice_id')
                ->first();

            $tech->technician_name = $technicianUser ? $technicianUser->name : 'Unknown';
            return $tech;
        });

        // Add technician information to the service request object
        $serviceRequest->primary_technician = $primaryTechnician;
        $serviceRequest->secondary_technicians = $secondaryTechnicians;

        $histories = $serviceRequest->statusHistories;

        // Define statuses to check for
        $terminalStatuses = ['completed', 'Denied', 'cancelled', 'Evaluated'];

        // ✅ Compute working time (only for 'ongoing' periods, stop when 'paused' or status changes)
        $workingTime = 0;
        $startTime = null;

        foreach ($histories as $history) {
            // Check for terminal statuses (completed, Denied, cancelled, Evaluated)
            if (
                in_array($history->status, $terminalStatuses) ||
                in_array(strtolower($history->status), array_map('strtolower', $terminalStatuses))
            ) {

                $serviceRequest->completion_date = $history->created_at;
                $serviceRequest->completed_by = $history->changed_by;
                $serviceRequest->completion_status = $history->status;

                // Get the name of the person who completed/denied/cancelled/evaluated it
                if ($history->changed_by) {
                    $user = DB::table('users')
                        ->where('philrice_id', $history->changed_by)
                        ->select('name')
                        ->first();

                    $serviceRequest->completed_by_name = $user ? $user->name : 'Unknown';
                }
            }

            if ($history->status === 'ongoing') {
                $startTime = $history->created_at;
            } elseif ($startTime && in_array($history->status, ['paused', 'completed', 'cancelled'])) {
                $workingTime += $history->created_at->diffInSeconds($startTime);
                $startTime = null;
            }
            // Find the user who made this status change
            if ($history->changed_by) {
                $user = DB::table('users')
                    ->where('philrice_id', $history->changed_by)
                    ->select('name', 'philrice_id')
                    ->first();

                $history->technician_id = $history->changed_by;
                $history->technician_name = $user ? $user->name : 'Unknown';
            } else {
                $history->technician_id = null;
                $history->technician_name = null;
            }
            // Add action taken information
            if ($history->action_id) {
                $actionTaken = DB::table('lib_actions_taken')
                    ->where('id', $history->action_id)
                    ->select('id', 'action_name')
                    ->first();

                $history->action_name = $actionTaken ? $actionTaken->action_name : null;
            } else {
                $history->action_name = null;
            }

            // Add problem encountered information
            if ($history->problem_id) {
                $problemEncountered = DB::table('lib_problems_encountered')
                    ->where('id', $history->problem_id)
                    ->select('id', 'encountered_problem_name')
                    ->first();

                $history->encountered_problem_name = $problemEncountered ? $problemEncountered->encountered_problem_name : null;
            } else {
                $history->encountered_problem_name = null;
            }
        }

        // If still ongoing now
        if ($startTime) {
            $workingTime += now()->diffInSeconds($startTime);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'serviceRequest' => $serviceRequest,
                'statusHistory' => $histories,
                'workingTimeSeconds' => $workingTime,
                'workingTimeFormatted' => gmdate('H:i:s', $workingTime),
            ]
        ]);
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
