<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tickets;
use App\Models\PrimaryTechnicianRequest;

class CompletedRequestApiController extends Controller
{


    public function fetchCompleteRequests(Request $request)
    {
        try {
            $categories = Servicecategory::pluck('category_name', 'id');
            $technicians = Technician::has('libTechnician')->get();
            $stations = Station::all();

            // Get completed requests
            $completedRequests = ServiceRequest::completed()
                ->with(['category', 'ticket', 'stations', 'requester', 'subCategory', 'latestStatus.status'])
                ->get();

            // Add technician information to each request
            $completedRequests->each(function ($request) {
                // Find primary technician assigned to this request
                $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

                if ($primaryTechnician) {
                    // Find technician in the users table
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

                // Find the completion timestamp from status history
                $completionHistory = DB::table('request_status_history')
                    ->where('request_id', $request->id)
                    ->where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($completionHistory) {
                    $request->completion_date = $completionHistory->created_at;
                    $request->completed_by = $completionHistory->changed_by;
                    $request->completion_status = 'completed';

                    // Get the name of the person who completed it
                    if ($completionHistory->changed_by) {
                        $completer = DB::table('users')
                            ->where('philrice_id', $completionHistory->changed_by)
                            ->select('name')
                            ->first();

                        $request->completed_by_name = $completer ? $completer->name : 'Unknown';
                    }
                }
            });
            $completedRequestsCount = $completedRequests->count();

            // Get evaluated requests
            $evaluatedRequests = ServiceRequest::evaluated()
                ->with(['category', 'ticket', 'stations', 'requester', 'subCategory', 'latestStatus.status'])
                ->get();

            // Add technician information to each request
            $evaluatedRequests->each(function ($request) {
                // Find primary technician assigned to this request
                $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

                if ($primaryTechnician) {
                    // Find technician in the users table
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

                // Find the completion timestamp from status history (evaluated requests were also completed first)
                $completionHistory = DB::table('request_status_history')
                    ->where('request_id', $request->id)
                    ->where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($completionHistory) {
                    $request->completion_date = $completionHistory->created_at;
                    $request->completed_by = $completionHistory->changed_by;
                    $request->completion_status = 'completed';

                    // Get the name of the person who completed it
                    if ($completionHistory->changed_by) {
                        $completer = DB::table('users')
                            ->where('philrice_id', $completionHistory->changed_by)
                            ->select('name')
                            ->first();

                        $request->completed_by_name = $completer ? $completer->name : 'Unknown';
                    }
                }

                // Find the evaluation timestamp from status history
                $evaluationHistory = DB::table('request_status_history')
                    ->where('request_id', $request->id)
                    ->where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($evaluationHistory) {
                    $request->evaluation_date = $evaluationHistory->created_at;
                    $request->evaluated_by = $evaluationHistory->changed_by;

                    // Get the name of the person who evaluated it
                    if ($evaluationHistory->changed_by) {
                        $evaluator = DB::table('users')
                            ->where('philrice_id', $evaluationHistory->changed_by)
                            ->select('name')
                            ->first();

                        $request->evaluated_by_name = $evaluator ? $evaluator->name : 'Unknown';
                    }
                }
            });
            $evaluatedRequestsCount = $evaluatedRequests->count();

            // Get denied requests
            $deniedRequests = ServiceRequest::denied()
                ->with(['category', 'ticket', 'stations', 'requester', 'subCategory', 'latestStatus.status'])
                ->get();

            // Add technician information to each request
            $deniedRequests->each(function ($request) {
                // Find primary technician assigned to this request
                $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

                if ($primaryTechnician) {
                    // Find technician in the users table
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

                // Find the denial timestamp from status history
                $denialHistory = DB::table('request_status_history')
                    ->where('request_id', $request->id)
                    ->where('status', 'Denied')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($denialHistory) {
                    $request->denial_date = $denialHistory->created_at;
                    $request->denied_by = $denialHistory->changed_by;
                    $request->completion_status = 'denied';

                    // Get the name of the person who denied it
                    if ($denialHistory->changed_by) {
                        $denier = DB::table('users')
                            ->where('philrice_id', $denialHistory->changed_by)
                            ->select('name')
                            ->first();

                        $request->denied_by_name = $denier ? $denier->name : 'Unknown';
                    }
                }
            });
            $deniedRequestsCount = $deniedRequests->count();

            // Get cancelled requests
            $cancelledRequests = ServiceRequest::canceled()
                ->with(['category', 'ticket', 'stations', 'requester', 'subCategory', 'latestStatus.status'])
                ->get();

            // Add technician information to each request
            $cancelledRequests->each(function ($request) {
                // Find primary technician assigned to this request
                $primaryTechnician = PrimaryTechnicianRequest::where('request_id', $request->id)->first();

                if ($primaryTechnician) {
                    // Find technician in the users table
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

                // Find the cancellation timestamp from status history
                $cancellationHistory = DB::table('request_status_history')
                    ->where('request_id', $request->id)
                    ->where('status', 'cancelled')
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($cancellationHistory) {
                    $request->cancellation_date = $cancellationHistory->created_at;
                    $request->cancelled_by = $cancellationHistory->changed_by;
                    $request->completion_status = 'cancelled';

                    // Get the name of the person who cancelled it
                    if ($cancellationHistory->changed_by) {
                        $canceller = DB::table('users')
                            ->where('philrice_id', $cancellationHistory->changed_by)
                            ->select('name')
                            ->first();

                        $request->cancelled_by_name = $canceller ? $canceller->name : 'Unknown';
                    }
                }
            });
            $cancelledRequestsCount = $cancelledRequests->count();

            return response()->json([
                'status' => true,
                'data' => [
                    'completedRequests' => $completedRequests,
                    'completedRequestsCount' => $completedRequestsCount,
                    'evaluatedRequests' => $evaluatedRequests,
                    'evaluatedRequestsCount' => $evaluatedRequestsCount,
                    'deniedRequests' => $deniedRequests,
                    'deniedRequestsCount' => $deniedRequestsCount,
                    'cancelledRequests' => $cancelledRequests,
                    'cancelledRequestsCount' => $cancelledRequestsCount,
                    'categories' => $categories,
                    'technicians' => $technicians,
                    'stations' => $stations,
                ]
            ]);
        } catch (\Exception $e) {
            // Add error logging for debugging
            // \Log::error('Completed API error: ' . $e->getMessage());
            // \Log::error($e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing your request',
                'error' => $e->getMessage(), // Remove this in production
            ], 500);
        }
    }

    public function sendMessageToClient(Request $request)
    {
        try {
            $validated = $request->validate([
                'recipient_id' => 'required|integer',
                'service_request_id' => 'required|integer',
                'subject' => 'required|string',
                'message' => 'required|string',
                'ticket_number' => 'nullable|string'
            ]);

            DB::table('message_to_clients')->insert([
                'service_request_id' => $validated['service_request_id'],
                'sender_id' => auth()->id(),
                'recipient_id' => $validated['recipient_id'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ticket_number' => $validated['ticket_number'],
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        } catch (\Exception $e) {


            return response()->json([
                'success' => false,
                'message' => 'Error sending message: ' . $e->getMessage()
            ], 500);
        }
    }
}
