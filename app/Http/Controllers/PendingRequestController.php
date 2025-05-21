<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Servicecategory;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Station;
use App\Models\Tickets;
use App\Models\PrimaryTechnicianRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SubCategory;
use App\Models\RequestStatus;
use App\Models\libTechnician;

class PendingRequestController extends Controller
{
    // New function to fetch service requests with categories
    public function fetchpPendingRequests(Request $request, $status = 'pending')
    {
        $categories = Servicecategory::pluck('category_name', 'id');
        $technicians = Technician::has('libTechnician')->get();
        $stations = Station::all();

        // Start query for pending service requests
        // $query = ServiceRequest::pending()->with('category');
        // $query = ServiceRequest::pending()->with(['category', 'ticket']);
        $query = ServiceRequest::pending()->with(['category', 'ticket', 'stations', 'latestStatus.status']);


        // Filter by date range if both are provided
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Filter by technician/requester ID
        if ($request->filled('technician_id')) {
            $query->where('requester_id', $request->technician_id);
        }
        if ($request->filled('station_id')) {
            $query->whereHas('stations', function ($q) use ($request) {
                $q->where('station_id', $request->station_id);
            });
        }


        // Filter by search term
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
        // Get the results
        $pendingRequests = $query->get();

        // Enhance each request with serial number and accountable information
        $pendingRequests->map(function ($pendingRequest) {
            // Get serial number and accountable for the service request
            $serialInfo = DB::table('request_serialnumber')
                ->where('request_id', $pendingRequest->id)
                ->select('serial_number', 'accountable', 'division', 'created_at')
                ->first();

            // And then also change:
            if ($serialInfo) {
                $pendingRequest->serial_number = $serialInfo->serial_number;
                $pendingRequest->accountable = $serialInfo->accountable;
                $pendingRequest->division = $serialInfo->division;
                $pendingRequest->created_at = $serialInfo->created_at;
            }

            // To this:
            if ($serialInfo) {
                $pendingRequest->serial_number = $serialInfo->serial_number;
                $pendingRequest->accountable = $serialInfo->accountable;
                $pendingRequest->division = $serialInfo->division;
                $pendingRequest->created_at = $serialInfo->created_at;
            }

            return $pendingRequest;
        });


        // Custom sort: priority = 1 on top, then by numeric part of ticket_full ASC
        $pendingRequests = $pendingRequests->sortBy(function ($item) {
            $ticketNumber = 0;

            if (!empty($item->ticket) && preg_match('/-(\d+)$/', $item->ticket->ticket_full, $matches)) {
                $ticketNumber = (int) $matches[1];
            }

            // '1 - priority' makes 1 come before 0
            return sprintf('%d-%04d', 1 - $item->priority, $ticketNumber);
        });
        $pendingRequestsCount = $pendingRequests->count();


        return view('ICT Main/pending', compact(
            'pendingRequests',
            'categories',
            'technicians',
            'pendingRequestsCount',
            'stations',
        ));
    }

    public function markAsPicked($id)
    {
        // $request = ServiceRequest::findOrFail($id);

        // // Update the service request status
        // $request->is_complete = 1;
        // $request->save();

        RequestStatus::where('request_id', $id)
            ->update(['status_id' => 3]);

        // Add a new record to primarytechnician_request
        PrimaryTechnicianRequest::create([
            'technician_emp_id' => Auth::id(), // or auth()->user()->id
            'request_id' => $id,
        ]);
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
            'request_id' => $id,
            'status' => 'picked', // Initial status is 'pending'
            'changed_by' => $userPhilriceId,
            'remarks' => 'Picked by technician',
            'problem_id' => null, // No problem ID yet
            'action_id' => null, // No action ID yet
            'created_at' => now(),
            'updated_at' => now(),
            // 'created_by' => $userPhilriceId
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Service marked as picked and technician assigned.',
        ]);
    }
}
