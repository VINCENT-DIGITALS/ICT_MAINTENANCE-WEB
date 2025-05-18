<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\Servicecategory;
use App\Models\Station;
use App\Models\Technician;
use App\Models\RequestStatus;
use App\Models\Tickets;
use App\Models\PrimaryTechnicianRequest;
use Illuminate\Support\Facades\DB;

class PickedRequestApiController extends Controller
{
    public function fetchpPickedRequests()
    {
        // Retrieve categories, technicians, and stations
        $categories = Servicecategory::pluck('category_name', 'id');
        $technicians = Technician::has('libTechnician')->get();  // Only technicians with 'libTechnician' relation
        $stations = Station::all();

        // Build the query for picked service requests and eager load the related data
        $query = ServiceRequest::picked()->with(['category', 'ticket', 'stations', 'latestStatus.status', 'subCategory', 'requester']);

        // Execute the query and get the picked service requests
        $pickedRequests = $query->get();
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

        // Get the count of picked requests
        $pickedRequestsCount = $pickedRequests->count();

        // Return the data as a JSON response
        return response()->json([
            'status' => true,
            'data' => [
                'pickedRequests' => $pickedRequests,
                'categories' => $categories,
                'technicians' => $technicians,
                'pickedRequestsCount' => $pickedRequestsCount,
                'stations' => $stations,
            ]
        ]);
    }




    public function markAsOngoing($id, $user_idno)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($id, $user_idno) {

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $id)
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is already in ongoing status.',
                ], 409); // 409 Conflict
            }

            if ($currentStatus->status_id != 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is not in a picked state.',
                ], 400);
            }

            // Update the service request status
            RequestStatus::where('request_id', $id)
                ->update(['status_id' => 5]);

            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$id,
                'status' => 'ongoing', // Status is now 'ongoing'
                'changed_by' => $user_idno,
                'remarks' => 'Request marked as ongoing by technician',
                'problem_id' => null,
                'action_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as ongoing.',
            ]);
        });
    }
}
