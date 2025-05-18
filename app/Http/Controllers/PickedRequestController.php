<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;  // Add this import
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


class PickedRequestController extends Controller
{

    // New function to fetch service requests with categories
    public function fetchpPickedRequests(Request $request, $status = null)
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Replace this line
        $technicians = User::whereHas('role', function ($query) {
            $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
        })->get();

        $stations = Station::all();

        // Get current user's philrice_id
        $currentUserPhilriceId = auth()->user()->philrice_id;

        // Start building the query
        $query = ServiceRequest::picked()
            ->with(['category', 'ticket', 'stations', 'latestStatus.status'])
            ->whereHas('primaryTechnician', function ($query) use ($currentUserPhilriceId) {
                $query->where('technician_emp_id', $currentUserPhilriceId);
            }); // Only include requests assigned to current user as technician

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

        // Filter by station
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
        $pickedRequests = $query->get();

        $pickedRequests = $pickedRequests->sortBy(function ($item) {
            $ticketNumber = 0;

            if (!empty($item->ticket) && preg_match('/-(\d+)$/', $item->ticket->ticket_full, $matches)) {
                $ticketNumber = (int) $matches[1];
            }

            $priority = $item->latestStatus->status->priority_level ?? 0;

            return sprintf('%d-%04d', 1 - $priority, $ticketNumber);
        })->values();



        $pickedRequestsCount = $pickedRequests->count();

        return view('ICT Main/picked', compact('pickedRequests', 'categories', 'technicians', 'pickedRequestsCount', 'stations'));
    }

    public function markAsOngoing($id)
    {
        try {
            // Update the service request status
            RequestStatus::where('request_id', $id)
                ->update(['status_id' => 5]);
                
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
            
            // Get the user's actual ID (primary key) instead of philrice_id
            $userId = $user->id; // This is the actual ID that matches the foreign key constraint
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID not found',
                ], 400);
            }

            // Insert status history record using the user's actual ID
            DB::table('request_status_history')->insert([
                'request_id' => $id,
                'status' => 'ongoing',
                'changed_by' => $user->philrice_id, // This can stay as philrice_id if the column accepts it
                'remarks' => 'Started by technician',
                'problem_id' => null,
                'action_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => $userId // Use the actual user ID that references the users table
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service marked as ongoing successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error changing status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
