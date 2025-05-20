<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;  // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Station;
use App\Models\Tickets;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SubCategory;
use App\Models\RequestStatus;
use App\Models\PrimaryTechnicianRequest;

class DashboardApiController extends Controller
{
    // New function to fetch service requests with categories
    public function dashboardData(Request $request)
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        $technicians = Technician::has('libTechnician')->get();

        $stations = Station::all();

        $query = ServiceRequest::with(['category', 'ticket', 'stations', 'latestStatus.status']);

        $pendingRequests = (clone $query)->pending()->get();
        // Add technician information to each request
        $pendingRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $pendingRequestsCount = $pendingRequests->count();

        $completedRequests = (clone $query)->completed()->get();
        // Add technician information to each request
        $completedRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $completedRequestsCount = $completedRequests->count();

        $pickedRequests = (clone $query)->picked()->get();
        // Add technician information to each request
        $pickedRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $pickedRequestsCount = $pickedRequests->count();

        $ongoingRequests = (clone $query)->ongoing()->get();
        // Add technician information to each request
        $ongoingRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $ongoingRequestsCount = $ongoingRequests->count();

        $pausedRequests = (clone $query)->paused()->get();
        // Add technician information to each request
        $pausedRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $pausedOngoingRequestsCount = $pausedRequests->count();

        $evaluatedRequests = (clone $query)->evaluated()->get();
        // Add technician information to each request
        $evaluatedRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $evaluatedRequestsCount = $evaluatedRequests->count();

        $cancelledRequests = (clone $query)->canceled()->get();
        // Add technician information to each request
        $cancelledRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $cancelledRequestsCount = $cancelledRequests->count();

        $deniedRequests = (clone $query)->denied()->get();
        // Add technician information to each request
        $deniedRequests->each(function ($request) {
            // Find the primary technician assigned to this request
            $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

            if ($primaryTechnician) {
                // Find the technician in the users table
                $technician = DB::table('users')
                    ->where('philrice_id', $primaryTechnician->technician_emp_id)
                    ->select('name', 'philrice_id')
                    ->first();

                // Add technician info to the request
                $request->technician_id = $primaryTechnician->technician_emp_id;
                $request->technician_name = $technician ? $technician->name : 'Unknown';
            } else {
                $request->technician_id = null;
                $request->technician_name = 'Not assigned';
            }
        });
        $deniedRequestsCount = $deniedRequests->count();

        $totalServiceRequests = (clone $query)
            ->join('lib_categories', 'service_requests.category_id', '=', 'lib_categories.id')
            ->select('lib_categories.category_name', DB::raw('COUNT(service_requests.id) as request_count'))
            ->groupBy('lib_categories.category_name')
            ->orderByDesc('request_count')
            ->limit(9)
            ->get();

        $totalServiceRequestCount = $totalServiceRequests->count();

        return response()->json([
            'status' => true,
            'data' => [
                'pendingRequests' => $pendingRequests,
                'pendingRequestsCount' => $pendingRequestsCount,
                'completedRequests' => $completedRequests,
                'completedRequestsCount' => $completedRequestsCount,
                'pickedRequests' => $pickedRequests,
                'pickedRequestsCount' => $pickedRequestsCount,
                'ongoingRequests' => $ongoingRequests,
                'ongoingRequestsCount' => $ongoingRequestsCount,
                'pausedRequests' => $pausedRequests,
                'pausedOngoingRequestsCount' => $pausedOngoingRequestsCount,
                'evaluatedRequests' => $evaluatedRequests,
                'evaluatedRequestsCount' => $evaluatedRequestsCount,
                'cancelledRequests' => $cancelledRequests,
                'cancelledRequestsCount' => $cancelledRequestsCount,
                'deniedRequests' => $deniedRequests,
                'deniedRequestsCount' => $deniedRequestsCount,
                'totalServiceRequests' => $totalServiceRequests,
                'totalServiceRequestCount' => $totalServiceRequestCount,
                'categories' => $categories,
                'technicians' => $technicians,
                'stations' => $stations,
            ]
        ]);
    }


    public function storeNewRequest(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'subcategory' => 'nullable|string',
            'subject' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'requested_date' => 'nullable|date',
            'telephone' => 'nullable|string',
            'cellphone' => 'nullable|string',
            'client' => 'nullable|string',
            'philrice_id' => 'required|string', // Get philrice_id from request
            'accountable' => 'nullable|string', // Added validation for accountable person
            'serial_number' => 'nullable|string', // Added validation for serial number
            'division' => 'nullable|string', // Added validation for division
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $userId = $request->philrice_id;

                // Step 1: Create Service Request
                $serviceRequest = new ServiceRequest();
                $serviceRequest->category_id = $request->category;
                $serviceRequest->sub_category_id = $request->subcategory;
                $serviceRequest->requester_id = $userId; // Use philrice_id from request
                $serviceRequest->end_user_emp_id = null;
                $serviceRequest->request_title = $request->subject;
                $serviceRequest->request_description = $request->description;
                $serviceRequest->location = $request->location;
                $serviceRequest->is_notified = 0;
                $serviceRequest->local_no = $request->telephone;
                $priorityLocalNos = ['110', '111', '120', '121', '140', '141', '130', '131', '132'];
                $serviceRequest->priority = in_array($request->telephone, $priorityLocalNos) ? 1 : 0;
                $serviceRequest->request_doc = now()->toDateString();
                $serviceRequest->request_completion = $request->requested_date;
                $serviceRequest->is_complete = 0;
                $serviceRequest->is_paused = false;
                $serviceRequest->actual_client = $request->client;
                $serviceRequest->save();

                // Step 2: Attach Station
                $serviceRequest->stations()->attach(1); // Philrice CES station_id = 1

                // Step 3: Create Ticket
                $category = Servicecategory::find($request->category);
                $catabbr = $category ? $category->category_abbr : 'TKT'; // fallback if null

                $year = Carbon::now()->format('Y');
                $month = Carbon::now()->format('m');

                // Get the latest ticket for the same category, year, and month
                $latestTicket = Tickets::where('ticket_category', $catabbr)
                    ->where('ticket_year', $year)
                    ->where('ticket_month', $month)
                    ->orderByDesc('id')
                    ->first();

                $series = $latestTicket ? $latestTicket->ticket_series + 1 : 1;
                $ticketSeries = str_pad($series, 2, '0', STR_PAD_LEFT);

                $ticketFull = "{$catabbr}-{$year}-{$month}-{$ticketSeries}";

                $ticket = new Tickets();
                $ticket->request_id = $serviceRequest->id;
                $ticket->ticket_category = $catabbr;
                $ticket->ticket_year = $year;
                $ticket->ticket_month = $month;
                $ticket->ticket_series = $series;
                $ticket->ticket_full = $ticketFull;
                $ticket->save();

                // Step 4: Store the initial status
                $requestStatus = new RequestStatus();
                $requestStatus->request_id = $serviceRequest->id;
                $requestStatus->status_id = 1; // Assuming 1 corresponds to 'Pending' in lib_status table
                $requestStatus->save();

                // Step 5: Add entry to request_status_history table
                DB::table('request_status_history')->insert([
                    'request_id' => (int)$serviceRequest->id,
                    'status' => 'pending',
                    'changed_by' => $userId,
                    'remarks' => 'Initial request submission',
                    'problem_id' => null,
                    'action_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Step 6: Save serial number and accountable information
                if ($request->has('serial_number') || $request->has('accountable')) {
                    DB::table('request_serialnumber')->insert([
                        'request_id' => $serviceRequest->id,
                        'serial_number' => $request->serial_number,
                        'accountable' => $request->accountable,
                        'division' => $request->division,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }


                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Service request created successfully!',
                        'service_request_id' => $serviceRequest->id,
                        'ticket' => $ticketFull
                    ]
                ]);
            } catch (\Exception $e) {
                // Log error if needed
                // \Log::error('Error creating service request: ' . $e->getMessage());

                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Error creating service request: ' . $e->getMessage()
                    ]
                ], 500);
            }
        });
    }



    /**
     * Check if a user has reached the maximum pending requests limit
     * 
     * @param string $philriceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserPendingRequestsLimit($philriceId = null, Request $request)
    {
        // Accept ID from URL parameter or request body
        if (!$philriceId && $request->has('philrice_id')) {
            $philriceId = $request->philrice_id;
        }

        if (!$philriceId) {
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'PhilRice ID is required'
                ]
            ], 400);
        }

        try {
            // FIRST CHECK: See if user has unrated completed requests
            $unratedCount = $this->getUnratedCompletedRequestCount($philriceId);

            // If they have 3+ unrated requests, ask them to rate first
            if ($unratedCount >= 3) {
                return response()->json([
                    'status' => true,
                    'data' => [
                        'has_reached_limit' => true,
                        'unrated_requests_count' => $unratedCount,
                        'limit_type' => 'unrated',
                        'message' => "Please rate your completed requests before creating a new request."
                    ]
                ]);
            }

            // SECOND CHECK: Check pending requests limit
            $pendingStatusId = DB::table('lib_status')->where('status_name', 'Pending')->value('id');

            $pendingCount = ServiceRequest::where('requester_id', $philriceId)
                ->whereHas('requestStatus', function ($query) use ($pendingStatusId) {
                    $query->where('status_id', $pendingStatusId);
                })
                ->count();

            $maxAllowed = 3;
            $hasReachedLimit = $pendingCount >= $maxAllowed;
            $remainingRequests = $maxAllowed - $pendingCount;

            return response()->json([
                'status' => true,
                'data' => [
                    'has_reached_limit' => $hasReachedLimit,
                    'pending_requests_count' => $pendingCount,
                    'unrated_requests_count' => $unratedCount,
                    'max_allowed' => $maxAllowed,
                    'remaining_requests' => max(0, $remainingRequests),
                    'limit_type' => $hasReachedLimit ? 'pending' : 'none',
                    'message' => $hasReachedLimit ?
                        "You have reached the maximum amount of pending requests ({$maxAllowed})." :
                        "You can submit {$remainingRequests} more request(s)."
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Error checking requests limit: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Get the count of completed requests without evaluations for a user
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
     * Get all active service categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getServiceCategories()
    // {
    //     try {
    //         $categories = Servicecategory::orderBy('category_name')
    //             ->get(['id', 'category_name', 'category_abbr']);
    //         $subcategories = SubCategory::where('category_id', $categoryId)
    //             ->orderBy('sub_category_name')
    //             ->get(['id', 'sub_category_name', 'category_id']);
    //         return response()->json([
    //             'status' => true,
    //             'data' => [
    //                 'categories' => $categories,
    //                 'subcategories' => $subcategories,
    //             ]
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Error fetching service categories: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Get subcategories for a specific category
     *
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getSubcategories($categoryId)
    // {
    //     try {


    //         return response()->json([
    //             'status' => true,
    //             'data' => [

    //             ]
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Error fetching subcategories: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Get all service categories with their subcategories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriesWithSubcategories()
    {
        try {
            $categories = Servicecategory::with(['subcategories' => function ($query) {
                $query->orderBy('sub_category_name');
            }])
                ->orderBy('category_name')
                ->get(['id', 'category_name', 'category_abbr']);

            return response()->json([
                'status' => true,
                'data' => [
                    'categories' => $categories,
                    'count' => $categories->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching categories with subcategories: ' . $e->getMessage()
            ], 500);
        }
    }
}
