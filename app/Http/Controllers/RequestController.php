<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\LibTechnician;
use App\Models\PrimaryTechnicianRequest;
use App\Models\Tickets;
use App\Models\Servicecategory;
use App\Models\SubCategory;
use App\Models\RequestStatusHistory;
use App\Models\LibProblemEncountered;  // Corrected model name
use App\Models\Action;  // Corrected model name

class RequestController extends Controller
{
    /**
     * Display a listing of all service requests
     * This page is only accessible to Super Administrators
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Verify the user is a Super Administrator
        if (!Auth::check() || optional(Auth::user()->role)->role_name !== 'Super Administrator') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        // Get all service requests with relevant relationships
        $requests = ServiceRequest::with([
            'ticket',
            'category',
            'subcategory',
            'requestStatus.status'
        ])
        ->orderBy('created_at', 'desc')
        ->get(); // We still get all records but will paginate in frontend

        // Process requests to include ticket_full information and status history details
        foreach ($requests as $request) {
            // Ensure ticket information is available
            if (!$request->ticket) {
                // If no ticket is associated, find it manually
                $ticket = Tickets::where('request_id', $request->id)->first();
                if ($ticket) {
                    $request->ticket_full = $ticket->ticket_full;
                } else {
                    $request->ticket_full = 'No Ticket';
                }
            } else {
                $request->ticket_full = $request->ticket->ticket_full;
            }

            // Get status from the relationship
            if ($request->requestStatus && $request->requestStatus->status) {
                $request->status_name = $request->requestStatus->status->status_name;
                $request->status_abbr = $request->requestStatus->status->status_abbr;
            } else {
                $request->status_name = 'Unknown';
                $request->status_abbr = 'UNK';
            }

            // Get the latest status history entry manually to ensure we have the most recent
            $latestHistory = RequestStatusHistory::where('request_id', $request->id)
                ->latest()
                ->first();

            if ($latestHistory) {
                // Get problem encountered information
                if ($latestHistory->problem_id) {
                    $problemEncountered = LibProblemEncountered::find($latestHistory->problem_id);
                    $request->problem_name = $problemEncountered ? $problemEncountered->encountered_problem_name : 'Not specified';
                } else {
                    $request->problem_name = 'Not specified';
                }

                // Get action taken information
                if ($latestHistory->action_id) {
                    $actionTaken = Action::find($latestHistory->action_id);
                    $request->action_name = $actionTaken ? $actionTaken->action_name : 'Not specified';
                } else {
                    $request->action_name = 'Not specified';
                }

                // Set remarks and status
                $request->remarks = $latestHistory->remarks ?? 'None';
                $request->current_status = $latestHistory->status;

                // Set status label based on current_status
                switch ($latestHistory->status) {
                    case 'ongoing':
                        $request->status_label = 'Ongoing';
                        break;
                    case 'completed':
                        $request->status_label = 'Completed';
                        break;
                    case 'paused':
                        $request->status_label = 'Paused';
                        break;
                    case 'Cancelled':
                        $request->status_label = 'Cancelled';
                        break;
                    case 'Denied':
                        $request->status_label = 'Denied';
                        break;
                    default:
                        $request->status_label = ucfirst($latestHistory->status);
                }
            } else {
                $request->problem_name = 'Not specified';
                $request->action_name = 'Not specified';
                $request->remarks = 'None';
                $request->current_status = 'Pending';
                $request->status_label = 'Pending';
            }

            // Get evaluation rating
            $evaluation = DB::table('evaluation_request')
                ->where('request_id', $request->id)
                ->first();

            if ($evaluation) {
                // Get overall rating from the evaluation_ratings table
                $rating = DB::table('evaluation_ratings')
                    ->where('evaluation_id', $evaluation->id)
                    ->first();
                
                if ($rating) {
                    $request->rating = $rating->overall_rating;
                    $request->rating_text = number_format($rating->overall_rating, 2) . '%';
                } else {
                    $request->rating = null;
                    $request->rating_text = 'Not yet rated';
                }
            } else {
                $request->rating = null;
                $request->rating_text = 'Not yet rated';
            }
        }

        // Get all technician IDs
        $technicians = LibTechnician::pluck('user_idno');

        $nowServing = [];

        foreach ($technicians as $technicianId) {
            // Get the first primary technician request for this technician
            $primaryRequest = PrimaryTechnicianRequest::where('technician_emp_id', $technicianId)
                ->orderBy('id')
                ->first();

            if ($primaryRequest) {
                // Get the associated ticket using the request_id
                $ticket = Tickets::where('request_id', $primaryRequest->request_id)->first();

                $nowServing[] = [
                    'technician_emp_id' => $technicianId,
                    'request_id' => $primaryRequest->request_id,
                    'ticket_full' => optional($ticket)->ticket_full ?? 'No ticket found',
                ];
            }

            // If no primary request found, do nothing (skip this technician)
        }


        $nextCustomer = [];

        foreach ($technicians as $technicianId) {
            // Get the second primary technician request for this technician
            $secondaryRequest = PrimaryTechnicianRequest::where('technician_emp_id', $technicianId)
                ->orderBy('id')
                ->skip(1) // Skip the first
                ->first(); // Get the second

            if ($secondaryRequest) {
                // Get the associated ticket using the request_id
                $ticket = Tickets::where('request_id', $secondaryRequest->request_id)->first();

                $nextCustomer[] = [
                    'technician_emp_id' => $technicianId,
                    'request_id' => $secondaryRequest->request_id,
                    'ticket_full' => optional($ticket)->ticket_full ?? 'No ticket found',
                ];
            }

            // If no second request found, skip this technician
        }


        return view('ICT Main.requests', [
            'requests' => $requests,
            'nowServing' => $nowServing,
            'nextCustomer' => $nextCustomer,
            'categories' => $categories,
            'title' => 'Request Management'
        ]);
    }

    /**
     * Show the form for editing a specific request
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Get service request without relationships
        $request = ServiceRequest::findOrFail($id);

        return view('ICT Main.request-edit', [
            'request' => $request,
        ]);
    }

    /**
     * Update the specified request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'technician_id' => 'nullable|exists:technicians,id',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Update the service request
        $serviceRequest->update($validated);

        return redirect()->route('request.index')
            ->with('success', 'Request updated successfully');
    }

    public function submitEvaluation(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|exists:service_requests,id',
            'evaluator_emp_id' => 'required',
            'realiability_quality' => 'required|integer|min:1|max:5',
            'responsiveness' => 'required|integer|min:1|max:5',
            'outcome' => 'required|integer|min:1|max:5',
            'assurance_integrity' => 'required|integer|min:1|max:5',
            'access_facility' => 'required|integer|min:1|max:5',
            'quality_remark' => 'nullable|string',
            'responsiveness_remark' => 'nullable|string',
            'integrity_remark' => 'nullable|string',
            'timeliness_remark' => 'nullable|string',
            'access_remark' => 'nullable|string',
            'evaluation_subject' => 'nullable|string',
            'evaluation_body' => 'nullable|string'
        ]);

        try {
            // Calculate overall rating (equal weights for all criteria)
            $overallRating = (
                $validated['realiability_quality'] +
                $validated['responsiveness'] +
                $validated['outcome'] +
                $validated['assurance_integrity'] +
                $validated['access_facility']
            ) * 20 / 5; // Convert from 5-point scale to 100-point scale

            // Begin a database transaction
            DB::beginTransaction();

            // Insert evaluation without overall rating
            $evaluationId = DB::table('evaluation_request')->insertGetId([
                'evaluator_emp_id' => $validated['evaluator_emp_id'],
                'request_id' => $validated['request_id'],
                'realiability_quality' => $validated['realiability_quality'],
                'responsiveness' => $validated['responsiveness'],
                'outcome' => $validated['outcome'],
                'assurance_integrity' => $validated['assurance_integrity'],
                'access_facility' => $validated['access_facility'],
                'quality_remark' => $validated['quality_remark'],
                'responsiveness_remark' => $validated['responsiveness_remark'],
                'integrity_remark' => $validated['integrity_remark'],
                'timeliness_remark' => $validated['timeliness_remark'],
                'access_remark' => $validated['access_remark'],
                'evaluation_subject' => $validated['evaluation_subject'] ?? 'Evaluated using New CSS',
                'evaluation_body' => $validated['evaluation_body'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Insert overall rating into the new table
            DB::table('evaluation_ratings')->insert([
                'evaluation_id' => $evaluationId,
                'overall_rating' => $overallRating,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update service request status to evaluated
            DB::table('request_status')
                ->where('request_id', $validated['request_id'])
                ->update([
                    'status_id' => 8, // Assuming 8 is the ID for 'Evaluated' status
                    'updated_at' => now()
                ]);

            // Get the numeric user ID from the philrice_id
            $userId = DB::table('users')
                ->where('philrice_id', $validated['evaluator_emp_id'])
                ->value('id') ?? 1; // Default to 1 if not found

            // Add status change to history with numeric user ID
            DB::table('request_status_history')->insert([
                'request_id' => $validated['request_id'],
                'status' => 'evaluated',
                'changed_by' => $userId, // Use numeric user ID
                'created_by' => $userId, // Use numeric user ID
                'remarks' => 'Service request evaluated by client',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Evaluation submitted successfully',
                'rating' => $overallRating
            ]);

        } catch (\Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollBack();
            
            \Log::error('Error submitting evaluation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the evaluation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new service request
     * This is specifically for regular users to create requests
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if user has reached the maximum pending requests limit
        $userId = Auth::user()->philrice_id;
        
        $pendingCount = $this->getPendingRequestCount($userId);
        if ($pendingCount >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'You have reached the maximum amount of pending requests (3).'
            ], 403);
        }
        
        // Check for unrated completed requests limit
        $unratedCount = $this->getUnratedCompletedRequestCount($userId);
        if ($unratedCount >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Please rate your completed requests first before creating a new request.'
            ], 403);
        }
        
        $categories = Servicecategory::orderBy('category_name')->pluck('category_name', 'id');
        return view('ICT Main.request', compact('categories'));
    }

    /**
     * Store a newly created service request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user has reached the maximum pending requests limit
        $userId = Auth::user()->philrice_id;
        
        $pendingCount = $this->getPendingRequestCount($userId);
        if ($pendingCount >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'You have reached the maximum amount of pending requests (3).'
            ], 403);
        }
        
        // Check for unrated completed requests limit
        $unratedCount = $this->getUnratedCompletedRequestCount($userId);
        if ($unratedCount >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Please rate your completed requests first before creating a new request.'
            ], 403);
        }
        
        // Continue with the request creation process
        // ...existing store method code...
    }
    
    /**
     * Get the count of pending requests for a user
     *
     * @param string $userId
     * @return int
     */
    private function getPendingRequestCount($userId)
    {
        $pendingStatusId = DB::table('lib_status')->where('status_name', 'Pending')->value('id');
        
        return ServiceRequest::where('requester_id', $userId)
            ->whereHas('requestStatus', function($query) use ($pendingStatusId) {
                $query->where('status_id', $pendingStatusId);
            })
            ->count();
    }
    
    /**
     * Get the count of completed but unrated requests for a user
     *
     * @param string $userId
     * @return int
     */
    private function getUnratedCompletedRequestCount($userId)
    {
        // Get completed status IDs - check both 'Completed' and other variants
        $completedStatusIds = DB::table('lib_status')
            ->where('status_name', 'LIKE', '%complete%')
            ->orWhere('id', 8) // explicitly include ID 8 which might be the completed status
            ->pluck('id')
            ->toArray();
        
        if (empty($completedStatusIds)) {
            $completedStatusIds = [8]; // Use 8 as fallback completed status ID
        }
        
        // Get all completed requests for this user
        $completedRequests = DB::table('service_requests')
            ->join('request_status', 'service_requests.id', '=', 'request_status.request_id')
            ->where('service_requests.requester_id', $userId)
            ->whereIn('request_status.status_id', $completedStatusIds)
            ->pluck('service_requests.id')
            ->toArray();
        
        if (empty($completedRequests)) {
            return 0;
        }
        
        // Get requests that have evaluations
        $evaluatedRequestIds = DB::table('evaluation_request')
            ->whereIn('request_id', $completedRequests)
            ->pluck('request_id')
            ->toArray();
        
        // Calculate difference to find unrated requests
        $unratedRequests = array_diff($completedRequests, $evaluatedRequestIds);
        $unratedCount = count($unratedRequests);
        
        return $unratedCount;
    }

    /**
     * Check if a user can create more requests
     * This method is called via AJAX before showing the modal
     *
     * @return \Illuminate\Http\Response
     */
    public function checkRequestLimit()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $userId = Auth::user()->philrice_id;
        
        // Check pending requests limit
        $pendingCount = $this->getPendingRequestCount($userId);
        $pendingLimitReached = $pendingCount >= 3;
        
        // Check unrated completed requests limit
        $unratedCount = $this->getUnratedCompletedRequestCount($userId);
        $unratedLimitReached = $unratedCount >= 3;
        
        // Determine if the user can create a new request - EITHER limit prevents creation
        $canCreateRequest = !$pendingLimitReached && !$unratedLimitReached;
        
        // Determine the appropriate message
        $message = 'You can create a new request.';
        if ($pendingLimitReached) {
            $message = 'You have reached the maximum amount of pending requests (3).';
        } else if ($unratedLimitReached) {
            $message = 'Please rate your completed requests before creating a new request. You have 3 or more completed requests that need to be rated first.';
        }
        
        return response()->json([
            'success' => true,
            'canCreateRequest' => $canCreateRequest,
            'pendingCount' => $pendingCount,
            'unratedCount' => $unratedCount,
            'pendingLimitReached' => $pendingLimitReached,
            'unratedLimitReached' => $unratedLimitReached,
            'message' => $message
        ]);
    }
}
