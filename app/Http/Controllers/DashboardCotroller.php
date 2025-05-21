<?php

namespace App\Http\Controllers;

use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Station;
use App\Models\Tickets;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SubCategory;
use App\Models\RequestStatus;

class DashboardCotroller extends Controller
{
    // New function to fetch service requests with categories
    public function dashboardData(Request $request)
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Replace this line
        // Replace the problematic line with direct user query
        $technicians = Technician::has('libTechnician')->get();

        $stations = Station::all();

        // Get current user's philrice_id
        $currentUserPhilriceId = auth()->user()->philrice_id;
        // Check if current user is an admin (role_id = 1)
        $isAdmin = auth()->user()->role_id == 1;

        // Base query for service requests
        $query = ServiceRequest::with(['category', 'ticket', 'stations', 'latestStatus.status']);

        // Apply date range filter if both 'from_date' and 'to_date' are provided
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Apply technician filter if provided
        if ($request->filled('technician_id')) {
            $query->where('requester_id', $request->technician_id);
        }

        // Apply category filter if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by station
        if ($request->filled('station_id')) {
            $query->whereHas('stations', function ($query) use ($request) {
                $query->where('station_id', $request->station_id);
            });
        }

        // Filter by current user if not an admin

        // Filter by current user if not an admin
        if (!$isAdmin) {
            // For all request types except pending, filter by primary technician
            $nonPendingQuery = clone $query;
            $nonPendingQuery->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
                $query->where('technician_emp_id', $currentUserPhilriceId);
            });

            // Create a separate pending query without the technician filter
            $pendingQuery = clone $query;

            // Fetch pending requests without the technician filter
            $pendingRequests = $pendingQuery->pending()->get();
            $pendingRequestsCount = $pendingRequests->count();

            // Use the filtered query for all other request types
            $query = $nonPendingQuery;
        } else {
            // For admin users, just get all pending requests
            $pendingRequests = (clone $query)->pending()->get();
            $pendingRequestsCount = $pendingRequests->count();
        }

        // For non-pending statuses, use the filtered query
        // Note: Don't fetch pending requests again since we already did above
        $completedRequests = (clone $query)->completed()->get();
        $completedRequestsCount = $completedRequests->count();

        $pickedRequests = (clone $query)->picked()->get();
        $pickedRequestsCount = $pickedRequests->count();

        $ongoingRequests = (clone $query)->ongoing()->get();
        $ongoingRequestsCount = $ongoingRequests->count();

        // Fetch the count of paused ongoing requests
        $pausedRequests = (clone $query)->paused()->get();
        $pausedOngoingRequestsCount = $pausedRequests->count();

        // Fetch the count of evaluated requests
        $evaluatedRequests = (clone $query)->evaluated()->get();
        $evaluatedRequestsCount = $evaluatedRequests->count();

        // Fetch the count of cancelled requests
        $cancelledRequests = (clone $query)->canceled()->get();
        $cancelledRequestsCount = $cancelledRequests->count();

        // Fetch the count of denied requests
        $deniedRequests = (clone $query)->denied()->get();
        $deniedRequestsCount = $deniedRequests->count();


        // Fetch total service requests grouped by category (top 9), ensuring filters are applied
        $totalServiceRequests = (clone $query)->join('lib_categories', 'service_requests.category_id', '=', 'lib_categories.id')
            ->select('lib_categories.category_name', DB::raw('COUNT(service_requests.id) as request_count'))
            ->groupBy('lib_categories.category_name')
            ->orderByDesc('request_count')
            ->limit(9)
            ->get();

        // Count total service requests
        $totalServiceRequestCount = $totalServiceRequests->count();

        return view('ICT Main/dashboard', compact(
            'totalServiceRequests',
            'totalServiceRequestCount',
            'pendingRequests',
            'categories',
            'technicians',
            'pendingRequestsCount',
            'completedRequests',
            'completedRequestsCount',
            'pickedRequests',
            'pickedRequestsCount',
            'ongoingRequests',
            'ongoingRequestsCount',
            'pausedRequests',
            'pausedOngoingRequestsCount',
            'evaluatedRequests',
            'evaluatedRequestsCount',
            'cancelledRequests',
            'cancelledRequestsCount',
            'deniedRequests',
            'deniedRequestsCount',
            'stations'
        ));
    }

    /**
     * Get the count of completed but unrated requests for a user
     *
     * @param string $userId
     * @return int
     */
    private function getUnratedCompletedRequestCount($userId)
    {
        \Log::debug("Checking unrated completed requests for user: {$userId}");

        // Get completed status IDs - check both 'Completed' and other variants
        $completedStatusIds = DB::table('lib_status')
            ->where('status_name', 'LIKE', '%complete%')
            ->orWhere('id', 8) // explicitly include ID 8 which might be the completed status
            ->pluck('id')
            ->toArray();

        \Log::debug("Found completed status IDs: " . implode(', ', $completedStatusIds));

        if (empty($completedStatusIds)) {
            \Log::debug("No completed status IDs found in database - using ID 8 as fallback");
            $completedStatusIds = [8]; // Use 8 as fallback completed status ID
        }

        // Get all completed requests for this user
        $completedRequests = DB::table('service_requests')
            ->join('request_status', 'service_requests.id', '=', 'request_status.request_id')
            ->where('service_requests.requester_id', $userId)
            ->whereIn('request_status.status_id', $completedStatusIds)
            ->pluck('service_requests.id')
            ->toArray();

        \Log::debug("User has " . count($completedRequests) . " completed requests: " . implode(', ', $completedRequests));

        if (empty($completedRequests)) {
            return 0;
        }

        // Get requests that have evaluations
        $evaluatedRequestIds = DB::table('evaluation_request')
            ->whereIn('request_id', $completedRequests)
            ->pluck('request_id')
            ->toArray();

        \Log::debug("Of which " . count($evaluatedRequestIds) . " have been evaluated: " . implode(', ', $evaluatedRequestIds));

        // Calculate difference to find unrated requests
        $unratedRequests = array_diff($completedRequests, $evaluatedRequestIds);
        $unratedCount = count($unratedRequests);

        \Log::debug("Resulting in {$unratedCount} unrated requests: " . implode(', ', $unratedRequests));

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
        \Log::debug("Checking request limits for user: {$userId}");

        // Check pending requests limit
        $pendingStatusId = DB::table('lib_status')->where('status_name', 'Pending')->value('id');
        $pendingCount = ServiceRequest::where('requester_id', $userId)
            ->whereHas('requestStatus', function ($query) use ($pendingStatusId) {
                $query->where('status_id', $pendingStatusId);
            })
            ->count();

        $pendingLimitReached = $pendingCount >= 3;
        \Log::debug("Pending count: {$pendingCount}, limit reached: " . ($pendingLimitReached ? 'Yes' : 'No'));

        // Check unrated completed requests limit
        $unratedCount = $this->getUnratedCompletedRequestCount($userId);
        $unratedLimitReached = $unratedCount >= 3;
        \Log::debug("Unrated count: {$unratedCount}, limit reached: " . ($unratedLimitReached ? 'Yes' : 'No'));

        // Determine if the user can create a new request - EITHER limit prevents creation
        $canCreateRequest = !$pendingLimitReached && !$unratedLimitReached;

        // Determine the appropriate message
        $message = 'You can create a new request.';
        if ($pendingLimitReached) {
            $message = 'You have reached the maximum amount of pending requests (3).';
        } else if ($unratedLimitReached) {
            $message = 'Please rate your completed requests before creating a new request. You have 3 or more completed requests that need to be rated first.';
        }

        \Log::debug("Final decision - Can create request: " . ($canCreateRequest ? 'Yes' : 'No'));
        \Log::debug("Message: {$message}");

        return response()->json([
            'success' => true,
            'canCreateRequest' => $canCreateRequest,
            'pendingCount' => $pendingCount,
            'unratedCount' => $unratedCount,
            'pendingLimitReached' => $pendingLimitReached,
            'unratedLimitReached' => $unratedLimitReached,
            'message' => $message,
            'debug_info' => [
                'checked_status_ids' => $completedStatusIds ?? [],
                'user_id' => $userId
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
        ]);

        // Check if user has reached the maximum pending requests limit (3)
        $userId = Auth::user()->philrice_id;

        // Do the same checks as in checkRequestLimit to be consistent
        $pendingStatusId = DB::table('lib_status')->where('status_name', 'Pending')->value('id');
        $pendingCount = ServiceRequest::where('requester_id', $userId)
            ->whereHas('requestStatus', function ($query) use ($pendingStatusId) {
                $query->where('status_id', $pendingStatusId);
            })
            ->count();

        if ($pendingCount >= 3) {
            return redirect()->back()->with('error', 'You have reached the maximum amount of pending requests (3).');
        }

        // Check for unrated completed requests limit
        $unratedCount = $this->getUnratedCompletedRequestCount($userId);
        if ($unratedCount >= 3) {
            return redirect()->back()->with('error', 'Please rate your completed requests first before creating a new request.');
        }

        // Step 1: Create Service Request
        $serviceRequest = new ServiceRequest();
        $serviceRequest->category_id = $request->category; // You may use a real lookup later
        $serviceRequest->sub_category_id = $request->subcategory; // You may use a real lookup later
        $serviceRequest->requester_id = auth()->id(); // assumes the logged in user is the requester
        $serviceRequest->end_user_emp_id = null; // if available, replace accordingly
        $serviceRequest->request_title = $request->subject;
        $serviceRequest->request_description = $request->description;
        $serviceRequest->location = $request->location;
        $serviceRequest->is_notified = 0; // default to 0 (not notified)

        $serviceRequest->local_no = $request->telephone;
        $priorityLocalNos = ['110', '111', '120', '121', '140', '141', '130', '131', '132'];
        $serviceRequest->priority = in_array($request->telephone, $priorityLocalNos) ? 1 : 0;
        $serviceRequest->request_doc = now()->toDateString(); // returns 'YYYY-MM-DD'
        $serviceRequest->request_completion = $request->requested_date; // You may use a real lookup later
        $serviceRequest->is_complete = 0; // default to 0 (pending)
        $serviceRequest->is_paused = false;
        $serviceRequest->actual_client = $request->client; // You may use a real lookup later
        $serviceRequest->save();

        // Step 2: Attach Station
        $serviceRequest->stations()->attach(1); // Philrice CES station_id = 1

        // Step 3: Create Ticket using category abbreviation and per-month series
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

        // Create the new ticket
        $ticket = new Tickets();
        $ticket->request_id = $serviceRequest->id;
        $ticket->ticket_category = $catabbr;
        $ticket->ticket_year = $year;
        $ticket->ticket_month = $month;
        $ticket->ticket_series = $series;
        $ticket->ticket_full = $ticketFull;
        $ticket->save();

        // Step 4: Store the initial status in request_status table
        $requestStatus = new RequestStatus();
        $requestStatus->request_id = $serviceRequest->id;
        $requestStatus->status_id = 1; // Assuming 1 corresponds to 'Pending' in lib_status table
        $requestStatus->save();

        // Step 5: Add entry to request_status_history table
        // Get the authenticated user's philrice_id
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }
        $userPhilriceId = $user->philrice_id;
        if (!$userPhilriceId) {
            throw new \Exception('User philrice_id not found');
        }

        // Insert status history record
        DB::table('request_status_history')->insert([
            'request_id' => (int)$serviceRequest->id,
            'status' => 'pending', // Initial status is 'pending'
            'changed_by' => $userPhilriceId,
            'remarks' => 'Initial request submission',
            'problem_id' => null, // No problem ID yet
            'action_id' => null, // No action ID yet
            'created_at' => now(),
            'updated_at' => now(),
            // 'created_by' => $userPhilriceId
        ]);
        return redirect()->back()->with('success', 'Request added successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->pluck('sub_category_name', 'id');

        return response()->json($subcategories);
    }
}
