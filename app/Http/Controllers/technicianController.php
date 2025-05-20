<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class technicianController extends Controller
{
    public function technicians()
    {
        // Fetch role IDs for Super Administrator, Administrator, Technician, and Station Technician
        $roleIds = DB::table('lib_roles')
            ->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician'])
            ->pluck('id');
        logger('Role IDs for Super Administrator, Administrator, Technician, and Station Technician:', $roleIds->toArray());

        // Get all users who are either:
        // 1. Have one of the specified roles, OR
        // 2. Exist in the lib_technicians table
        $technicians = User::where('archived', false)
            ->where(function ($query) use ($roleIds) {
                $query->whereIn('role_id', $roleIds)
                    ->orWhereExists(function ($subquery) {
                        $subquery->select(DB::raw(1))
                            ->from('lib_technicians')
                            ->whereColumn('user_idno', 'users.philrice_id');
                    });
            })
            ->leftJoin('lib_roles', 'users.role_id', '=', 'lib_roles.id')
            ->select('users.*', 'lib_roles.role_name')
            ->get()
            ->map(function ($user) {
                // Get count of requests by status for this user
                $picked = ServiceRequest::picked()->where('requester_id', $user->philrice_id)->count();
                $ongoing = ServiceRequest::ongoing()->where('requester_id', $user->philrice_id)->count();
                $paused = ServiceRequest::paused()->where('requester_id', $user->philrice_id)->count();
                $completed = ServiceRequest::completed()->where('requester_id', $user->philrice_id)->count();
                $evaluated = ServiceRequest::evaluated()->where('requester_id', $user->philrice_id)->count();
                $otherCompleted = $completed + $evaluated; // Non-evaluated completed requests

                // Calculate completion rate percentage, ensuring it doesn't exceed 100%
                if ($picked === 0) {
                    $completionRate = 0; // Avoid division by zero
                } else {
                    // Make sure the ratio doesn't exceed 1 (100%)
                    $ratio = min(1, $otherCompleted / $picked);
                    $completionRate = round($ratio * 100);
                }

                // Get count of incidents reported by this user
                $incidentCount = DB::table('lib_incident_reports')
                    ->where('reporter_name', $user->name)
                    ->count();

                // Get technician's rating information from evaluations
                $ratingData = $this->getTechnicianRating($user->philrice_id);
                $avgRating = $ratingData['average'];
                $ratingPercentage = $ratingData['percentage'];
                $ratingText = $this->getRatingText($ratingPercentage);
                $ratingDisplay = $ratingData['count'] > 0 ? "{$ratingPercentage}% ({$ratingData['count']} ratings)" : 'No ratings';

                // Get most serviced category for this technician
                $mostServicedCategory = $this->getMostServicedCategory($user->philrice_id);

                // Get most serviced office for this technician
                $mostServicedOffice = $this->getMostServicedOffice($user->philrice_id);

                // Get technician's requests by category for summary data
                $requestData = $this->getTechnicianRequestsByCategory($user->philrice_id);

                // Get turnaround time using the consistent helper method
                $turnaroundTimeData = $this->calculateTurnaroundTime($user->philrice_id);
                $turnaroundTime = $turnaroundTimeData['average_turnaround_time'];

                return [
                    'name' => $user->name,
                    'philrice_id' => $user->philrice_id ?? 'N/A',
                    'email' => $user->email ?? 'N/A',
                    'position' => $user->position ?? 'N/A',
                    'division' => $user->division ?? 'N/A',
                    'status' => $user->status ?? 'active',
                    'role' => $user->role_name ?? 'Technician', // Add role name
                    'counts' => [
                        'picked' => $picked,
                        'ongoing' => $ongoing,
                        'paused' => $paused,
                        'completed' => $completed,
                        'evaluated' => $evaluated,
                        'other_completed' => $otherCompleted,
                        'incidents' => $incidentCount // Add incident count
                    ],
                    'completion_rate' => $completionRate . '%', // Add formatted completion rate
                    'requests' => $requestData,
                    'rating' => [
                        'value' => $avgRating,
                        'percentage' => $ratingPercentage,
                        'text' => $ratingText,
                        'display' => $ratingDisplay,
                        'count' => $ratingData['count']
                    ],
                    'most_serviced_category' => $mostServicedCategory['name'] ?? 'N/A',
                    'most_serviced_count' => $mostServicedCategory['count'] ?? 0,
                    'most_serviced_office' => $mostServicedOffice['name'] ?? 'N/A',
                    'most_serviced_office_count' => $mostServicedOffice['count'] ?? 0,
                    'turnaround_time' => $turnaroundTime
                ];
            });

        // Debugging: Log the technicians data
        if ($technicians->isEmpty()) {
            logger('No users found for the specified roles.');
        } else {
            logger('Users found:', $technicians->toArray());
        }

        // Get all users for the dropdown, including their role_id
        $allUsers = \App\Models\User::where('archived', false)
            ->orderBy('philrice_id')
            ->get(['philrice_id', 'name', 'email', 'role_id']);

        // Get list of working technicians' IDs
        $workingTechnicianIds = \DB::table('lib_technicians')
            ->pluck('user_idno')
            ->toArray();

        // Get available roles for technician creation
        $roles = \DB::table('lib_roles')
            ->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician'])
            ->get(['id', 'role_name']);

        return view('ICT Main.technician', compact('technicians', 'allUsers', 'workingTechnicianIds', 'roles'));
    }

    /**
     * Get the most serviced category for a technician
     *
     * @param string $technicianEmpId
     * @return array
     */
    private function getMostServicedCategory($technicianEmpId)
    {
        // Get all service requests assigned to this technician
        $categoryCounts = DB::table('primarytechnician_request')
            ->where('technician_emp_id', $technicianEmpId)
            ->join('service_requests', 'primarytechnician_request.request_id', '=', 'service_requests.id')
            ->join('lib_categories', 'service_requests.category_id', '=', 'lib_categories.id')
            ->select('lib_categories.id', 'lib_categories.category_name', DB::raw('COUNT(*) as count'))
            ->groupBy('lib_categories.id', 'lib_categories.category_name')
            ->orderBy('count', 'desc')
            ->first();

        return $categoryCounts ? [
            'id' => $categoryCounts->id,
            'name' => $categoryCounts->category_name,
            'count' => $categoryCounts->count
        ] : [
            'id' => null,
            'name' => 'No Services Yet',
            'count' => 0
        ];
    }

    /**
     * Get the most serviced office (location) for a technician
     *
     * @param string $technicianEmpId
     * @return array
     */
    private function getMostServicedOffice($technicianEmpId)
    {
        // Get all service requests assigned to this technician and group by location
        $officeCount = DB::table('primarytechnician_request')
            ->where('technician_emp_id', $technicianEmpId)
            ->join('service_requests', 'primarytechnician_request.request_id', '=', 'service_requests.id')
            ->select('service_requests.location', DB::raw('COUNT(*) as count'))
            ->groupBy('service_requests.location')
            ->orderBy('count', 'desc')
            ->first();

        return $officeCount ? [
            'name' => $officeCount->location,
            'count' => $officeCount->count
        ] : [
            'name' => 'No Office Served',
            'count' => 0
        ];
    }

    /**
     * Get technician's requests grouped by category
     *
     * @param string $technicianId
     * @return array
     */
    private function getTechnicianRequestsByCategory($technicianId)
    {
        // Get the count of all requests assigned to this technician
        $totalRequests = DB::table('primarytechnician_request')
            ->where('technician_emp_id', $technicianId)
            ->count();

        // Get the breakdown by category - LIMIT TO TOP 10
        $categoryBreakdown = DB::table('primarytechnician_request')
            ->where('primarytechnician_request.technician_emp_id', $technicianId)
            ->join('service_requests', 'primarytechnician_request.request_id', '=', 'service_requests.id')
            ->join('lib_categories', 'service_requests.category_id', '=', 'lib_categories.id')
            ->select(
                'lib_categories.id',
                'lib_categories.category_name',
                DB::raw('COUNT(*) as request_count')
            )
            ->groupBy('lib_categories.id', 'lib_categories.category_name')
            ->orderBy('request_count', 'desc')
            ->limit(10) // Limit to top 10 categories
            ->get();

        // Get the count of requests that weren't included in the top 10
        $otherCategoriesCount = 0;
        if ($categoryBreakdown->count() === 10) {
            $topCategoryIds = $categoryBreakdown->pluck('id')->toArray();

            $otherCategoriesCount = DB::table('primarytechnician_request')
                ->where('primarytechnician_request.technician_emp_id', $technicianId)
                ->join('service_requests', 'primarytechnician_request.request_id', '=', 'service_requests.id')
                ->whereNotIn('service_requests.category_id', $topCategoryIds)
                ->count();
        }

        return [
            'total' => $totalRequests,
            'categories' => $categoryBreakdown,
            'other_categories_count' => $otherCategoriesCount
        ];
    }

    /**
     * Get the technician's rating based on evaluations of their service requests
     *
     * @param string $technicianEmpId
     * @return array
     */
    private function getTechnicianRating($technicianEmpId)
    {
        // Get all service requests assigned to this technician
        $technicianRequests = DB::table('primarytechnician_request')
            ->where('technician_emp_id', $technicianEmpId)
            ->pluck('request_id')
            ->toArray();

        if (empty($technicianRequests)) {
            return [
                'average' => 0,
                'percentage' => 0,
                'count' => 0
            ];
        }

        // Get evaluations for these service requests
        $evaluations = DB::table('evaluation_request')
            ->whereIn('request_id', $technicianRequests)
            ->pluck('id')
            ->toArray();

        if (empty($evaluations)) {
            return [
                'average' => 0,
                'percentage' => 0,
                'count' => 0
            ];
        }

        // Get ratings for these evaluations
        $ratings = DB::table('evaluation_ratings')
            ->whereIn('evaluation_id', $evaluations)
            ->select('overall_rating')
            ->get();

        $count = $ratings->count();
        if ($count === 0) {
            return [
                'average' => 0,
                'percentage' => 0,
                'count' => 0
            ];
        }

        $sum = $ratings->sum('overall_rating');
        $average = $sum / $count;
        $percentage = round($average); // Round to nearest integer

        return [
            'average' => $average,
            'percentage' => $percentage,
            'count' => $count
        ];
    }

    /**
     * Get descriptive text for a rating percentage
     *
     * @param int $percentage
     * @return string
     */
    private function getRatingText($percentage)
    {
        if ($percentage >= 90) {
            return 'Excellent';
        } elseif ($percentage >= 80) {
            return 'Very Good';
        } elseif ($percentage >= 70) {
            return 'Good';
        } elseif ($percentage >= 60) {
            return 'Fair';
        } elseif ($percentage > 0) {
            return 'Poor';
        }

        return 'Not Rated';
    }

    public function technicianDetail(Request $request, $id)
    {
        $technician = User::where('philrice_id', $id)
            ->where('archived', false)
            ->leftJoin('lib_roles', 'users.role_id', '=', 'lib_roles.id')
            ->first();

        if (!$technician) {
            return redirect()->route('technicians')->with('error', 'Technician not found');
        }

        // Get the technician's requests by category
        $requestData = $this->getTechnicianRequestsByCategory($technician->philrice_id);

        // Map other technician data (similar to the technicians method)
        $picked = ServiceRequest::picked()->where('requester_id', $technician->philrice_id)->count();
        $ongoing = ServiceRequest::ongoing()->where('requester_id', $technician->philrice_id)->count();
        $paused = ServiceRequest::paused()->where('requester_id', $technician->philrice_id)->count();
        $completed = ServiceRequest::completed()->where('requester_id', $technician->philrice_id)->count();
        $evaluated = ServiceRequest::evaluated()->where('requester_id', $technician->philrice_id)->count();
        $otherCompleted = $completed - $evaluated;

        // Calculate completion rate, ensuring it doesn't exceed 100%
        if ($picked === 0) {
            $completionRate = 0; // Avoid division by zero
        } else {
            // Make sure the ratio doesn't exceed 1 (100%)
            $ratio = min(1, $completed / $picked);
            $completionRate = round($ratio * 100);
        }

        // Get count of incidents reported by this user
        $incidentCount = DB::table('lib_incident_reports')
            ->where('reporter_name', $technician->name)
            ->count();

        // Get the technician's rating
        $ratingData = $this->getTechnicianRating($technician->philrice_id);
        $avgRating = $ratingData['average'];
        $ratingPercentage = $ratingData['percentage'];
        $ratingText = $this->getRatingText($ratingPercentage);
        $ratingDisplay = $ratingData['count'] > 0 ? "{$ratingPercentage}% ({$ratingData['count']} ratings)" : 'No ratings';

        // Get most serviced category and office
        $mostServicedCategory = $this->getMostServicedCategory($technician->philrice_id);
        $mostServicedOffice = $this->getMostServicedOffice($technician->philrice_id);

        // Get turnaround time using the consistent helper method
        $turnaroundTimeData = $this->calculateTurnaroundTime($technician->philrice_id);
        $turnaroundTime = $turnaroundTimeData['average_turnaround_time'];

        $technicianData = [
            'name' => $technician->name,
            'philrice_id' => $technician->philrice_id ?? 'N/A',
            'email' => $technician->email ?? 'N/A',
            'position' => $technician->position ?? 'N/A',
            'division' => $technician->division ?? 'N/A',
            'status' => $technician->status ?? 'active',
            'role' => $technician->role_name ?? 'Technician',
            'counts' => [
                'picked' => $picked,
                'ongoing' => $ongoing,
                'paused' => $paused,
                'completed' => $completed,
                'evaluated' => $evaluated,
                'other_completed' => $otherCompleted,
                'incidents' => $incidentCount
            ],
            'completion_rate' => $completionRate . '%',
            'requests' => $requestData,
            'rating' => [
                'value' => $avgRating,
                'percentage' => $ratingPercentage,
                'text' => $ratingText,
                'display' => $ratingDisplay,
                'count' => $ratingData['count']
            ],
            'most_serviced_category' => $mostServicedCategory['name'] ?? 'N/A',
            'most_serviced_count' => $mostServicedCategory['count'] ?? 0,
            'most_serviced_office' => $mostServicedOffice['name'] ?? 'N/A',
            'most_serviced_office_count' => $mostServicedOffice['count'] ?? 0,
            'turnaround_time' => $turnaroundTime
        ];

        return view('ICT Main.technician_detail', compact('technicianData'));
    }

    public function updateTechnician(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required',
                'role' => 'required|string|in:Technician,Administrator,Station Technician',
                'password' => 'nullable|string|min:6'
            ]);

            $user = User::where('philrice_id', $validated['id'])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Get role ID from role name
            $roleId = DB::table('lib_roles')
                ->where('role_name', $validated['role'])
                ->value('id');

            if (!$roleId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid role selected'
                ], 400);
            }

            $user->role_id = $roleId;

            // Update password if provided
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->save();

            if (in_array($validated['role'], ['Technician', 'Station Technician'])) {
                // Insert into lib_technicians if not already there
                $exists = DB::table('lib_technicians')->where('user_idno', $user->philrice_id)->exists();

                if (!$exists) {
                    DB::table('lib_technicians')->insert([
                        'user_idno' => $user->philrice_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif ($validated['role'] === 'Administrator') {
                // Delete from lib_technicians if exists
                DB::table('lib_technicians')->where('user_idno', $user->philrice_id)->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating technician: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the account'
            ], 500);
        }
    }

    public function archiveTechnician(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required'
            ]);

            $user = User::where('philrice_id', $validated['id'])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $user->archived = true;
            $user->archived_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Account archived successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error archiving technician: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while archiving the account'
            ], 500);
        }
    }

    /**
     * Calculate the average turnaround time for a specific technician
     *
     * @param int $technicianId The technician's ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTurnaroundTime($technicianId)
    {
        try {
            // Use the known working SQL query with Common Table Expressions (CTEs)
            $results = DB::select("
                WITH
                request_periods AS (
                    SELECT
                        request_id,
                        changed_by,
                        status,
                        created_at,
                        LEAD(created_at) OVER (PARTITION BY request_id, changed_by ORDER BY created_at) AS next_timestamp,
                        LEAD(status) OVER (PARTITION BY request_id, changed_by ORDER BY created_at) AS next_status
                    FROM request_status_history
                    WHERE changed_by = ?
                ),
                active_periods AS (
                    SELECT
                        request_id,
                        changed_by,
                        created_at AS period_start,
                        next_timestamp AS period_end,
                        TIMESTAMPDIFF(SECOND, created_at, next_timestamp) AS period_seconds
                    FROM request_periods
                    WHERE
                        status = 'ongoing'
                        AND next_status IN ('paused', 'completed')
                )
                SELECT
                    request_id,
                    SUM(period_seconds) AS total_active_seconds,
                    CONCAT(
                        FLOOR(SUM(period_seconds) / 86400), ' days ',
                        FLOOR((SUM(period_seconds) % 86400) / 3600), ' hrs ',
                        FLOOR((SUM(period_seconds) % 3600) / 60), ' min ',
                        SUM(period_seconds) % 60, ' sec'
                    ) AS formatted_duration
                FROM
                    active_periods
                GROUP BY
                    request_id
                ORDER BY
                    total_active_seconds DESC
            ", [$technicianId]);

            // If no results, return default response
            if (empty($results)) {
                return response()->json([
                    'success' => true,
                    'average_turnaround_time' => '0 days 0 hrs 0 min',
                    'average_seconds' => 0,
                    'requests_processed' => 0,
                    'debug_info' => 'No active time periods found for this technician'
                ]);
            }

            // Calculate total active time and number of requests
            $totalActiveSeconds = 0;
            $requestsProcessed = count($results);

            foreach ($results as $result) {
                $totalActiveSeconds += $result->total_active_seconds;
            }

            // Calculate average time
            $averageTimeSeconds = $totalActiveSeconds / $requestsProcessed;

            // Format the average time
            $days = floor($averageTimeSeconds / 86400);
            $hours = floor(($averageTimeSeconds % 86400) / 3600);
            $minutes = floor(($averageTimeSeconds % 3600) / 60);
            $seconds = floor($averageTimeSeconds % 60);

            $formattedTime = '';
            if ($days > 0) $formattedTime .= "$days days ";
            if ($hours > 0 || $days > 0) $formattedTime .= "$hours hrs ";
            if ($minutes > 0 || $hours > 0 || $days > 0) $formattedTime .= "$minutes min ";
            $formattedTime .= "$seconds sec"; // Always include seconds for debugging

            return response()->json([
                'success' => true,
                'average_turnaround_time' => $formattedTime,
                'average_seconds' => $averageTimeSeconds,
                'requests_processed' => $requestsProcessed,
                'total_seconds' => $totalActiveSeconds,
                'debug_info' => $results // Include individual request data for debugging
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating turnaround time: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    // Helper method to calculate turnaround time with consistent formatting
    private function calculateTurnaroundTime($technicianId)
    {
        try {
            // Use the known working SQL query with Common Table Expressions (CTEs)
            $results = DB::select("
                WITH
                request_periods AS (
                    SELECT
                        request_id,
                        changed_by,
                        status,
                        created_at,
                        LEAD(created_at) OVER (PARTITION BY request_id, changed_by ORDER BY created_at) AS next_timestamp,
                        LEAD(status) OVER (PARTITION BY request_id, changed_by ORDER BY created_at) AS next_status
                    FROM request_status_history
                    WHERE changed_by = ?
                ),
                active_periods AS (
                    SELECT
                        request_id,
                        changed_by,
                        created_at AS period_start,
                        next_timestamp AS period_end,
                        TIMESTAMPDIFF(SECOND, created_at, next_timestamp) AS period_seconds
                    FROM request_periods
                    WHERE
                        status = 'ongoing'
                        AND next_status IN ('paused', 'completed')
                )
                SELECT
                    request_id,
                    SUM(period_seconds) AS total_active_seconds,
                    CONCAT(
                        FLOOR(SUM(period_seconds) / 86400), ' days ',
                        FLOOR((SUM(period_seconds) % 86400) / 3600), ' hrs ',
                        FLOOR((SUM(period_seconds) % 3600) / 60), ' min ',
                        SUM(period_seconds) % 60, ' sec'
                    ) AS formatted_duration
                FROM
                    active_periods
                GROUP BY
                    request_id
                ORDER BY
                    total_active_seconds DESC
            ", [$technicianId]);

            // If no results, return default response
            if (empty($results)) {
                return [
                    'average_turnaround_time' => '0 days 0 hrs 0 min',
                    'average_seconds' => 0,
                    'requests_processed' => 0,
                    'total_seconds' => 0,
                ];
            }

            // Calculate total active time and number of requests
            $totalActiveSeconds = 0;
            $requestsProcessed = count($results);

            foreach ($results as $result) {
                $totalActiveSeconds += $result->total_active_seconds;
            }

            // Calculate average time
            $averageTimeSeconds = $totalActiveSeconds / $requestsProcessed;

            // Format the average time
            $days = floor($averageTimeSeconds / 86400);
            $hours = floor(($averageTimeSeconds % 86400) / 3600);
            $minutes = floor(($averageTimeSeconds % 3600) / 60);
            $seconds = floor($averageTimeSeconds % 60);

            $formattedTime = '';
            if ($days > 0) $formattedTime .= "$days days ";
            if ($hours > 0 || $days > 0) $formattedTime .= "$hours hrs ";
            if ($minutes > 0 || $hours > 0 || $days > 0) $formattedTime .= "$minutes min ";
            $formattedTime .= "$seconds sec"; // Always include seconds for debugging

            return [
                'average_turnaround_time' => $formattedTime,
                'average_seconds' => $averageTimeSeconds,
                'requests_processed' => $requestsProcessed,
                'total_seconds' => $totalActiveSeconds,
            ];

        } catch (\Exception $e) {
            return [
                'average_turnaround_time' => '0 days 0 hrs 0 min',
                'average_seconds' => 0,
                'requests_processed' => 0,
                'total_seconds' => 0,
            ];
        }
    }

    /**
     * Store a newly created technician account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = \Validator::make($request->all(), [
                'philrice_id' => 'required|exists:users,philrice_id',
                'role_id' => 'required|exists:lib_roles,id',
                'password' => 'nullable|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Find the user by philrice_id
            $user = \App\Models\User::where('philrice_id', $request->philrice_id)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Check if user is already a technician
            $existingTechnician = \DB::table('lib_technicians')->where('user_idno', $request->philrice_id)->first();

            if ($existingTechnician) {
                return response()->json([
                    'success' => false,
                    'message' => 'This user is already registered as a technician'
                ], 400);
            }

            // Begin transaction to ensure both operations succeed or fail together
            \DB::beginTransaction();

            try {
                // 1. Update user's role if needed
                if ($user->role_id != $request->role_id) {
                    $user->role_id = $request->role_id;
                }

                // 2. Update password if provided
                if ($request->filled('password')) {
                    $user->password = \Hash::make($request->password);
                }

                // Save user changes
                $user->save();

                // 3. Add user to lib_technicians
                \DB::table('lib_technicians')->insert([
                    'user_idno' => $user->philrice_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Commit transaction
                \DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Technician account successfully created'
                ]);
            } catch (\Exception $e) {
                // Rollback transaction on error
                \DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create technician account: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
