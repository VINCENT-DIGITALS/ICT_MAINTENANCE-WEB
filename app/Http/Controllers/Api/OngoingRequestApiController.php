<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\ServiceRequest;
use App\Models\Servicecategory;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tickets;
use App\Models\PrimaryTechnicianRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SubCategory;
use App\Models\RequestStatus;
use Illuminate\Support\Facades\Storage;

class OngoingRequestApiController extends Controller
{
    // New function to fetch service requests with categories
    public function fetchOngoingRequests(Request $request)
    {
        $categories = Servicecategory::pluck('category_name', 'id');
        $technicians = Technician::has('libTechnician')->get();
        $stations = Station::all();

        $withRelations = ['category', 'ticket', 'stations', 'latestStatus.status', 'subCategory', 'requester'];

        $ongoingRequests = ServiceRequest::ongoing()
            ->with($withRelations)
            ->get();
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
        $pausedRequests = ServiceRequest::paused()
            ->with($withRelations)
            ->get();
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
        return response()->json([
            'status' => true,
            'data' => [
                'ongoingRequests' => $ongoingRequests,
                'ongoingRequestsCount' => $ongoingRequests->count(),
                'pausedRequests' => $pausedRequests,
                'pausedRequestsCount' => $pausedRequests->count(),
                'categories' => $categories,
                'technicians' => $technicians,
                'stations' => $stations,
            ]
        ]);
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

        // ✅ Compute working time (only for 'ongoing' periods, stop when 'paused' or status changes)
        $workingTime = 0;
        $startTime = null;

        foreach ($histories as $history) {
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
                'ticket_number' => 'nullable|string',
                'technician_id' => 'nullable|integer'
            ]);



            // Insert message with proper data types
            DB::table('message_to_clients')->insert([
                'service_request_id' => (int)$validated['service_request_id'],
                'sender_id' => $validated['technician_id'] ?? null,
                'recipient_id' => (int)$validated['recipient_id'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ticket_number' => $validated['ticket_number'],
                'status' => 'ongoing', // Set status as 'ongoing' for messages sent from ongoing requests
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

    public function fetchAvailableTechnicians()
    {
        try {
            // Get technicians from lib_technicians table and join with users table to get names
            $technicians = DB::table('lib_technicians')
                ->join('users', 'lib_technicians.user_idno', '=', 'users.philrice_id')
                ->select(
                    'lib_technicians.id as technician_id',
                    'lib_technicians.user_idno as philrice_id',
                    'users.name as technician_name',
                    'users.email'
                )
                ->orderBy('users.name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'technicians' => $technicians
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching technicians: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateTechnicians(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required|integer',
                'primary_technician_id' => 'nullable|string',
                'secondary_technician_ids' => 'nullable|array',
                'secondary_technician_ids.*' => 'string',
                'remarks' => 'nullable|string',
                'acting_user_id' => 'required|string',
            ]);

            $requestId = $validated['request_id'];

            // Check if the request exists
            $serviceRequest = ServiceRequest::findOrFail($requestId);

            // Get current technicians for history tracking
            $currentPrimaryTech = DB::table('primarytechnician_request')
                ->where('request_id', $requestId)
                ->first();

            $currentSecondaryTechs = DB::table('secondarytechnician_request')
                ->where('request_id', $requestId)
                ->get()
                ->pluck('technician_emp_id')
                ->toArray();

            // Handle primary technician update
            if (isset($validated['primary_technician_id'])) {
                // Remove existing primary technician if any
                DB::table('primarytechnician_request')
                    ->where('request_id', $requestId)
                    ->delete();

                // Add new primary technician if provided
                if (!empty($validated['primary_technician_id'])) {
                    DB::table('primarytechnician_request')->insert([
                        'request_id' => $requestId,
                        'technician_emp_id' => $validated['primary_technician_id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Handle secondary technicians update
            if (isset($validated['secondary_technician_ids'])) {
                // Remove existing secondary technicians
                DB::table('secondarytechnician_request')
                    ->where('request_id', $requestId)
                    ->delete();

                // Add new secondary technicians if provided
                if (!empty($validated['secondary_technician_ids'])) {
                    foreach ($validated['secondary_technician_ids'] as $techId) {
                        if (!empty($techId)) {
                            DB::table('secondarytechnician_request')->insert([
                                'request_id' => $requestId,
                                'technician_emp_id' => $techId,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }
            }

            // Record in history - build a descriptive message
            $historyMessage = "Technician assignment updated.";

            // Get technician names for more descriptive history
            $primaryTechName = null;
            if (isset($validated['primary_technician_id']) && !empty($validated['primary_technician_id'])) {
                $primaryTechUser = DB::table('users')
                    ->where('philrice_id', $validated['primary_technician_id'])
                    ->first();
                $primaryTechName = $primaryTechUser ? $primaryTechUser->name : 'Unknown';
                $historyMessage .= " Primary: {$primaryTechName}";
            } elseif (isset($validated['primary_technician_id']) && empty($validated['primary_technician_id'])) {
                $historyMessage .= " Primary technician removed.";
            }

            if (isset($validated['secondary_technician_ids']) && !empty($validated['secondary_technician_ids'])) {
                $secondaryNames = [];
                foreach ($validated['secondary_technician_ids'] as $techId) {
                    $techUser = DB::table('users')
                        ->where('philrice_id', $techId)
                        ->first();
                    $secondaryNames[] = $techUser ? $techUser->name : 'Unknown';
                }
                if (!empty($secondaryNames)) {
                    $historyMessage .= " Secondary: " . implode(', ', $secondaryNames);
                }
            } elseif (isset($validated['secondary_technician_ids']) && empty($validated['secondary_technician_ids'])) {
                $historyMessage .= " Secondary technicians removed.";
            }

            // Insert the technician change into history
            DB::table('request_status_history')->insert([
                'request_id' => $requestId,
                'status' => $serviceRequest->latestStatus->status->status_name ?? 'unknown',
                'changed_by' => $validated['acting_user_id'],
                'remarks' => ($validated['remarks'] ?? '') . ' ' . $historyMessage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Technicians updated successfully',
                'data' => [
                    'primary_technician' => $validated['primary_technician_id'] ?? null,
                    'secondary_technicians' => $validated['secondary_technician_ids'] ?? []
                ]
            ]);
        });
    }

    public function fetchActionsTaken()
    {
        try {
            // Get all non-archived actions from lib_actions_taken table
            $actions = DB::table('lib_actions_taken')
                ->where('is_archived', '!=', 1)
                ->orWhereNull('is_archived')
                ->select('id', 'action_name', 'action_abbr')
                ->orderBy('action_name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'actions' => $actions,
                    'count' => $actions->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching actions taken: ' . $e->getMessage()
            ], 500);
        }
    }


    public function fetchProblemsEncountered()
    {
        try {
            // Get all non-archived problems from lib_problems_encountered table
            $problems = DB::table('lib_problems_encountered')
                ->where('is_archived', '!=', 1)
                ->orWhereNull('is_archived')
                ->select('id', 'encountered_problem_name', 'encountered_problem_abbr')
                ->orderBy('encountered_problem_name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'problems' => $problems,
                    'count' => $problems->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching problems encountered: ' . $e->getMessage()
            ], 500);
        }
    }


    public function markAsComplete(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
                'philrice_id' => 'required|string',
                'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow image uploads up to 5MB
            ]);

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $validated['request_id'])
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 7) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is already completed.',
                ], 409); // 409 Conflict
            }

            if (!in_array($currentStatus->status_id, [3, 5, 6])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request cannot be completed from its current state.',
                ], 400);
            }

            // Update the service request status
            RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 7]);

            // Get user ID
            $userPhilriceId = $validated['philrice_id'];
            // Handle image upload
            $documentationPath = null;

            if ($request->hasFile('documentation')) {
                $image = $request->file('documentation');
                $filename = 'doc_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/documentation directory
                $path = $image->storeAs('public/documentation', $filename);

                // The correct path for public access
                $documentationPath = Storage::url($path); // This will be '/storage/documentation/filename.jpg'
            }

            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'completed',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                'documentation' => $documentationPath, // Save the path to the uploaded image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as completed.',
            ]);
        });
    }

    public function markAsPaused(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
                'philrice_id' => 'required|string',
                'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow image uploads up to 5MB
            ]);

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $validated['request_id'])
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 6) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is already paused.',
                ], 409); // 409 Conflict
            }

            if ($currentStatus->status_id != 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is not in an ongoing state.',
                ], 400);
            }

            // Update the service request status
            RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 6]);

            // Get user ID
            $userPhilriceId = $validated['philrice_id'];

            // Handle image upload
            $documentationPath = null;

            if ($request->hasFile('documentation')) {
                $image = $request->file('documentation');
                $filename = 'doc_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/documentation directory
                $path = $image->storeAs('public/documentation', $filename);

                // The correct path for public access
                $documentationPath = Storage::url($path); // This will be '/storage/documentation/filename.jpg'
            }


            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'paused',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                'documentation' => $documentationPath, // Save the path to the uploaded image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as paused.',
            ]);
        });
    }

    public function markAsDenied(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
                'philrice_id' => 'required|string',
                'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow image uploads up to 5MB
            ]);

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $validated['request_id'])
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is already denied.',
                ], 409); // 409 Conflict
            }

            // Update the service request status
            RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 100]);

            // Get user ID
            $userPhilriceId = $validated['philrice_id'];

            // Handle image upload
            $documentationPath = null;

            if ($request->hasFile('documentation')) {
                $image = $request->file('documentation');
                $filename = 'doc_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/documentation directory
                $path = $image->storeAs('public/documentation', $filename);

                // The correct path for public access
                $documentationPath = Storage::url($path); // This will be '/storage/documentation/filename.jpg'
            }

            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'Denied',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                'documentation' => $documentationPath, // Save the path to the uploaded image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as denied.',
            ]);
        });
    }

    public function markAsCancelled(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
                'philrice_id' => 'required|string',
                'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow image uploads up to 5MB
            ]);

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $validated['request_id'])
                ->lockForUpdate()
                ->first();

            if (!$currentStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request not found.',
                ], 404);
            }

            if ($currentStatus->status_id == 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request is already cancelled.',
                ], 409); // 409 Conflict
            }

            // Update the service request status
            RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 200]);

            // Get user ID
            $userPhilriceId = $validated['philrice_id'];

            // Handle image upload
            $documentationPath = null;

            if ($request->hasFile('documentation')) {
                $image = $request->file('documentation');
                $filename = 'doc_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/documentation directory
                $path = $image->storeAs('public/documentation', $filename);

                // The correct path for public access
                $documentationPath = Storage::url($path); // This will be '/storage/documentation/filename.jpg'
            }

            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'cancelled',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'],
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                'documentation' => $documentationPath, // Save the path to the uploaded image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as cancelled.',
            ]);
        });
    }

    public function markAsOngoing(Request $request)
    {
        // Begin a database transaction for atomicity
        return DB::transaction(function () use ($request) {
            $validated = $request->validate([
                'request_id' => 'required',
                'problem_id' => 'nullable',
                'action_id' => 'nullable',
                'remarks' => 'nullable|string',
                'philrice_id' => 'required|string',
                'documentation' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Allow image uploads up to 5MB
            ]);

            // Check if the request exists and validate its current status
            $currentStatus = RequestStatus::where('request_id', $validated['request_id'])
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

            if ($currentStatus->status_id != 6 && $currentStatus->status_id != 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service request cannot be set to ongoing from its current state.',
                ], 400);
            }

            // Update the service request status
            RequestStatus::where('request_id', $validated['request_id'])
                ->update(['status_id' => 5]);

            // Get user ID
            $userPhilriceId = $validated['philrice_id'];

            // Handle image upload
            $documentationPath = null;

            if ($request->hasFile('documentation')) {
                $image = $request->file('documentation');
                $filename = 'doc_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/documentation directory
                $path = $image->storeAs('public/documentation', $filename);

                // The correct path for public access
                $documentationPath = Storage::url($path); // This will be '/storage/documentation/filename.jpg'
            }


            // Insert status history record
            DB::table('request_status_history')->insert([
                'request_id' => (int)$validated['request_id'],
                'status' => 'ongoing',
                'changed_by' => $userPhilriceId,
                'remarks' => $validated['remarks'] ?? 'Request marked as ongoing by technician',
                'problem_id' => $validated['problem_id'] ? (int)$validated['problem_id'] : null,
                'action_id' => $validated['action_id'] ? (int)$validated['action_id'] : null,
                'created_at' => now(),
                'updated_at' => now(),
                'documentation' => $documentationPath, // Save the path to the uploaded image
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service request marked as ongoing.',
            ]);
        });
    }
}
