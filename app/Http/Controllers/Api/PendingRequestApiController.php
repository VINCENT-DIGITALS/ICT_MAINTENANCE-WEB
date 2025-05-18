<?php

namespace App\Http\Controllers\Api;


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
use App\Http\Controllers\Controller;

class PendingRequestApiController extends Controller
{
    public function fetchpPendingRequests(Request $request, $status = 'pending')
    {
        $categories = Servicecategory::pluck('category_name', 'id');
        $technicians = Technician::has('libTechnician')->get();  // Only technicians with 'libTechnician' relation
        $stations = Station::all();

        $query = ServiceRequest::pending()->with(['category', 'ticket', 'stations', 'latestStatus.status', 'subCategory', 'requester']);

        $pendingRequests = $query->get();
        $pendingRequestsCount = $pendingRequests->count();

        return response()->json([
            'status' => true,
            'data' => [
                'pendingRequests' => $pendingRequests,
                'pendingRequestsCount' => $pendingRequestsCount,
                'categories' => $categories,
                'technicians' => $technicians,
                'stations' => $stations,
            ]
        ]);
    }



    public function markAsPicked($id, $user_idno)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($id, $user_idno) {
            // Check if the request is already picked (status_id = 3)
            $currentStatus = RequestStatus::where('request_id', $id)
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request has already been picked by another technician.',
                ], 409); // 409 Conflict
            }

            if ($currentStatus->status_id != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is not in a pending state.',
                ], 400);
            }

            // Update the service request status
            RequestStatus::where('request_id', $id)
                ->update(['status_id' => 3]);

            // Add a new record to primarytechnician_request
            PrimaryTechnicianRequest::create([
                'technician_emp_id' => $user_idno,
                'request_id' => $id,
            ]);

            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$id,
                'status' => 'picked', // Status is now 'in-progress' since it's being picked up
                'changed_by' => $user_idno,
                'remarks' => 'Request picked up by technician',
                'problem_id' => null,
                'action_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service marked as picked and technician assigned.',
            ]);
        });
    }
}
