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
        ]);

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
        $serviceRequest->request_doc = now()->toDateString(); // returns 'YYYY-MM-DD'
        $serviceRequest->priority =    0; // default to 0 (low priority)
        $serviceRequest->is_complete = 0; // default to 0 (pending)
        $serviceRequest->is_paused = false;
        $serviceRequest->save();

        // Step 2: Attach Station
        $serviceRequest->stations()->attach(1); // Philrice CES station_id = 1


        // Step 3: Create Ticket
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $series = Tickets::whereYear('created_at', $year)->count() + 1;
        $ticketFull = "TKT-$year-$month-" . str_pad($series, 4, '0', STR_PAD_LEFT);

        $ticket = new Tickets();
        $ticket->request_id = $serviceRequest->id;
        $ticket->ticket_category = $request->category;
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

        return redirect()->back()->with('success', 'Request added successfully!');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->pluck('sub_category_name', 'id');

        return response()->json($subcategories);
    }
}
