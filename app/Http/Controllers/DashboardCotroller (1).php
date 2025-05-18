<?php

namespace App\Http\Controllers;

use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardCotroller extends Controller
{
    // New function to fetch service requests with categories
    public function dashboardData()
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Fetch technicians using Eloquent relationships
        $technicians = Technician::has('libTechnician')->get();

        // Fetch pending requests using the scope
        $pendingRequests = ServiceRequest::pending()->with('category')->get();
        $pendingRequestsCount = $pendingRequests->count();
        // dd('No pending requests found', $pendingRequests);
        // Fetch completed requests using the scope
        $completedRequests = ServiceRequest::completed()->with('category')->get();
        $completedRequestsCount = $completedRequests->count();

        // Fetch picked requests using the scopePicked method
        $pickedRequests = ServiceRequest::picked() // Using the 'picked' scope defined in the model
            ->with('category')       // Eager load the category relationship
            ->get();
        $pickedRequestsCount = $pickedRequests->count();

        // Fetch ongoing requests (same as picked)
        $ongoingRequests = ServiceRequest::ongoing()->with('category')->get();
        $ongoingRequestsCount = $ongoingRequests->count();
        // Fetch the count of paused requests
        $pausedOngoingRequestsCount = $ongoingRequests->where('is_paused', true)->count();
        // dd('No ongoing requests found', $ongoingRequests);
        // Fetch total service requests grouped by category (top 9)
        // $totalServiceRequests = ServiceRequest::select('category_id', DB::raw('COUNT(id) as request_count'))
        //     ->groupBy('category_id')
        //     ->orderByDesc('request_count')
        //     ->limit(9)
        //     ->with('category')  // Eager load category name
        //     ->get();

        // $totalServiceRequestCount = $totalServiceRequests->count();

        $totalServiceRequests = ServiceRequest::join('lib_categories', 'service_requests.category_id', '=', 'lib_categories.id')
            ->select('lib_categories.category_name', DB::raw('COUNT(service_requests.id) as request_count'))
            ->groupBy('lib_categories.category_name')
            ->orderByDesc('request_count')
            ->limit(9)
            ->get();

        // Debugging
        $totalServiceRequestCount = $totalServiceRequests->count();




        // return response()->json($pendingRequests);
        return view('ICT Main/dashboard', compact('totalServiceRequests', 'totalServiceRequestCount', 'pendingRequests', 'categories', 'technicians', 'pendingRequestsCount', 'completedRequests', 'completedRequestsCount', 'pickedRequests', 'pickedRequestsCount', 'ongoingRequests', 'ongoingRequestsCount', 'pausedOngoingRequestsCount'));
    }
}
