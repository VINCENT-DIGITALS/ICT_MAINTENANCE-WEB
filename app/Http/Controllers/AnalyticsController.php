<?php

namespace App\Http\Controllers;

use App\Models\RequestProblemEncountered;
use App\Models\LibProblemEncountered;
use App\Models\Servicecategory;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;  // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function categoryDropdown()
    {
        $categories = Servicecategory::pluck('category_name', 'id');
        // Initialize dataset array
        $categoryData = [];

        foreach ($categories as $categoryId => $categoryName) {
            // Get the monthly count of requests per category
            $monthlyCounts = ServiceRequest::where('category_id', $categoryId)
                ->selectRaw('MONTH(created_at) as month, COUNT(id) as count')
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            // Fill missing months with 0
            $dataArray = collect(range(1, 12))->map(fn($month) => $monthlyCounts[$month] ?? 0)->toArray();

            // Add dataset for Chart.js
            $categoryData[] = [
                'label' => $categoryName,
                'data' => $dataArray,
                'borderColor' => '#' . substr(md5($categoryName), 0, 6), // Unique color per category
                'fill' => false
            ];
        }
        // Fetch technicians using Eloquent relationships
        $technicians = User::whereHas('role', function($query) {
            $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
        })->get();

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



        // Eloquent query using join, groupBy, and count
        $MostRequestProblemEncountered = RequestProblemEncountered::select('lib_problems_encountered.encountered_problem_name', DB::raw('COUNT(request_problem_encountered.encountered_problem_id) AS problem_count'))
            ->join('lib_problems_encountered', 'request_problem_encountered.encountered_problem_id', '=', 'lib_problems_encountered.id')
            ->groupBy('lib_problems_encountered.encountered_problem_name')
            ->orderByDesc('problem_count')
            ->get();
        // Calculate average resolution time for each category
        $averageTimes = $categories->mapWithKeys(function ($categoryName, $categoryId) {
            $requests = ServiceRequest::where('category_id', $categoryId)
                ->whereNotNull('updated_at')
                ->get();

            $totalResolutionTime = 0;
            $requestCount = 0;

            foreach ($requests as $request) {
                $resolutionTime = $request->updated_at->diffInSeconds($request->created_at);
                $totalResolutionTime += $resolutionTime;
                $requestCount++;
            }

            // Get the average resolution time in seconds
            $avgResolutionTimeInSeconds = $requestCount > 0 ? $totalResolutionTime / $requestCount : 0;

            // Convert seconds to hours and minutes
            $hours = floor($avgResolutionTimeInSeconds / 3600);
            $minutes = floor(($avgResolutionTimeInSeconds % 3600) / 60);

            // Format as "X hrs Y mins"
            $formattedTime = sprintf("%d hrs %d mins", $hours, $minutes);

            return [$categoryName => $formattedTime];
        });
        // Get average turnaround time for all service requests
        $averageTurnaroundTimeData = $this->calculateAverageTurnaroundTimeAllTechnicians();
        $averageTurnaroundTimeFormatted = $averageTurnaroundTimeData['average_turnaround_time'] ?? '0 hrs 0 min';

        // Get the top actions taken
        $actionsData = $this->getTopActionsTaken();

        // Get duplicate problem names (problems that appear more than once in the lib_problems_encountered table)
        $duplicateProblems = DB::select("
            SELECT encountered_problem_name, COUNT(*) as duplicate_count
            FROM lib_problems_encountered
            GROUP BY encountered_problem_name
            HAVING COUNT(*) > 1
            ORDER BY duplicate_count DESC
            LIMIT 7
        ");

        // Convert the result to a collection for easier handling in the blade template
        $duplicateProblemsCollection = collect($duplicateProblems);

        return view('ICT Main/analytics', compact(
            'averageTurnaroundTimeFormatted',
            'averageTimes',
            'MostRequestProblemEncountered',
            'totalServiceRequests',
            'totalServiceRequestCount',
            'pendingRequests',
            'categoryData',
            'categories',
            'technicians',
            'pendingRequestsCount',
            'completedRequests',
            'completedRequestsCount',
            'pickedRequests',
            'pickedRequestsCount',
            'ongoingRequests',
            'ongoingRequestsCount',
            'pausedOngoingRequestsCount',
            'actionsData',
            'duplicateProblemsCollection' // Add the new collection to the view
        ));
    }

    /**
     * Get the top actions taken from the database
     *
     * @return \Illuminate\Support\Collection
     */
    private function getTopActionsTaken()
    {
        // Query to get the count of actions taken, grouped by action name
        $actionsData = DB::table('lib_actions_taken')
            ->select('action_name', DB::raw('COUNT(*) as action_count'))
            ->where('is_archived', 0) // Only include active actions
            ->groupBy('action_name')
            ->orderByDesc('action_count')
            ->limit(7) // Limit to top 7 actions
            ->get();

        return $actionsData;
    }


    /**
     * Get service requests data grouped by office/location
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRequestsByOffice(Request $request)
    {
        // Get optional date range parameters with defaults
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $categoryId = $request->input('category_id');

        // Base query - group service requests by location
        $query = ServiceRequest::select('location', DB::raw('COUNT(*) as request_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('location', '!=', '')
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('request_count')
            ->limit(10); // Limit to top 10 locations

        // Apply optional category filter
        if ($categoryId && is_numeric($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $officeData = $query->get();

        // Format for Chart.js
        $labels = [];
        $data = [];
        $backgroundColors = [];

        foreach ($officeData as $office) {
            $locationName = trim($office->location);
            // Skip entries with empty location or default placeholders
            if (empty($locationName) || strtolower($locationName) == 'n/a') {
                continue;
            }

            $labels[] = $locationName;
            $data[] = $office->request_count;

            // Use consistent color for all bars
            $backgroundColors[] = "#1E293B";
        }

        // If no data, provide fallback for testing
        if (empty($labels)) {
            $labels = ["No location data available"];
            $data = [0];
            $backgroundColors = ["#1E293B"];
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Number of Requests',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ]);
    }

    /**
     * Get turnaround time data by category for a specific technician
     *
     * @param int $technicianId The technician's ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTurnaroundTimeByCategory($technicianId)
    {
        $result = $this->calculateTurnaroundTimeByCategory($technicianId);
        return response()->json($result);
    }

    /**
     * Calculate the average turnaround time by category for a technician
     *
     * @param int $technicianId The technician's ID
     * @return array
     */
    private function calculateTurnaroundTimeByCategory($technicianId)
    {
        try {
            $results = DB::select("
                WITH
                request_periods AS (
                    SELECT
                        rsh.request_id,
                        rsh.changed_by,
                        rsh.status,
                        rsh.created_at,
                        LEAD(rsh.created_at) OVER (PARTITION BY rsh.request_id, rsh.changed_by ORDER BY rsh.created_at) AS next_timestamp,
                        LEAD(rsh.status) OVER (PARTITION BY rsh.request_id, rsh.changed_by ORDER BY rsh.created_at) AS next_status
                    FROM request_status_history rsh
                    WHERE rsh.changed_by = ?
                ),
                active_periods AS (
                    SELECT
                        rp.request_id,
                        rp.changed_by,
                        rp.created_at AS period_start,
                        rp.next_timestamp AS period_end,
                        TIMESTAMPDIFF(SECOND, rp.created_at, rp.next_timestamp) AS period_seconds
                    FROM request_periods rp
                    WHERE
                        rp.status = 'ongoing'
                        AND rp.next_status IN ('paused', 'completed')
                ),
                request_active_times AS (
                    SELECT
                        ap.request_id,
                        sr.category_id,
                        lc.category_name,
                        SUM(ap.period_seconds) AS total_active_seconds,
                        CONCAT(
                            FLOOR(SUM(ap.period_seconds) / 86400), ' days ',
                            FLOOR((SUM(ap.period_seconds) % 86400) / 3600), ' hrs ',
                            FLOOR((SUM(ap.period_seconds) % 3600) / 60), ' min ',
                            SUM(ap.period_seconds) % 60, ' sec'
                        ) AS formatted_duration
                    FROM
                        active_periods ap
                    JOIN service_requests sr ON ap.request_id = sr.id
                    JOIN lib_categories lc ON sr.category_id = lc.id
                    GROUP BY
                        ap.request_id, sr.category_id, lc.category_name
                )
                SELECT
                    rat.category_id,
                    rat.category_name,
                    COUNT(*) AS request_count,
                    SUM(rat.total_active_seconds) AS total_seconds,
                    AVG(rat.total_active_seconds) AS avg_seconds,
                    CONCAT(
                        FLOOR(AVG(rat.total_active_seconds) / 86400), ' days ',
                        FLOOR((AVG(rat.total_active_seconds) % 86400) / 3600), ' hrs ',
                        FLOOR((AVG(rat.total_active_seconds) % 3600) / 60), ' min ',
                        FLOOR(AVG(rat.total_active_seconds) % 60), ' sec'
                    ) AS avg_formatted_duration
                FROM
                    request_active_times rat
                GROUP BY
                    rat.category_id, rat.category_name
                ORDER BY
                    avg_seconds ASC
            ", [$technicianId]);

            if (empty($results)) {
                return [
                    'success' => true,
                    'message' => 'No data found',
                    'categories' => []
                ];
            }

            // Format the results for clearer display
            $categories = [];
            foreach ($results as $result) {
                $categories[] = [
                    'category_id' => $result->category_id,
                    'category_name' => $result->category_name,
                    'request_count' => $result->request_count,
                    'avg_turnaround_time' => $result->avg_formatted_duration,
                    'avg_seconds' => $result->avg_seconds,
                    'total_seconds' => $result->total_seconds
                ];
            }

            return [
                'success' => true,
                'categories' => $categories
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating turnaround time by category: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }

    /**
     * Get the average turnaround time for a specific technician
     *
     * @param int $technicianId The technician's ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTurnaroundTime($technicianId)
    {
        $result = $this->calculateTurnaroundTime($technicianId);
        return response()->json($result);
    }

    /**
     * Helper method to calculate turnaround time with consistent formatting
     *
     * @param int $technicianId The technician's ID
     * @return array
     */
    private function calculateTurnaroundTime($technicianId)
    {
        try {
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

            if (empty($results)) {
                return [
                    'success' => true,
                    'average_turnaround_time' => '0 days 0 hrs 0 min',
                    'average_seconds' => 0,
                    'requests_processed' => 0,
                    'debug_info' => 'No active time periods found for this technician'
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
            $formattedTime .= "$seconds sec";

            return [
                'success' => true,
                'average_turnaround_time' => $formattedTime,
                'average_seconds' => $averageTimeSeconds,
                'requests_processed' => $requestsProcessed,
                'total_seconds' => $totalActiveSeconds,
                'debug_info' => $results
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error calculating turnaround time: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
        }
    }

    /**
     * Get average turnaround time by category for all technicians
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTurnaroundTimesByCategory()
    {
        try {
            // Get all technicians
            $technicians = User::whereHas('role', function($query) {
                $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
            })->pluck('philrice_id')->toArray();

            // Collect data for all technicians
            $allCategoriesData = [];

            foreach ($technicians as $techId) {
                $result = $this->calculateTurnaroundTimeByCategory($techId);

                if ($result['success'] && !empty($result['categories'])) {
                    foreach ($result['categories'] as $category) {
                        $categoryId = $category['category_id'];
                        $categoryName = $category['category_name'];

                        if (!isset($allCategoriesData[$categoryId])) {
                            $allCategoriesData[$categoryId] = [
                                'name' => $categoryName,
                                'total_seconds' => 0,
                                'request_count' => 0
                            ];
                        }

                        $allCategoriesData[$categoryId]['total_seconds'] += $category['total_seconds'];
                        $allCategoriesData[$categoryId]['request_count'] += $category['request_count'];
                    }
                }
            }

            // Calculate average for each category
            $labels = [];
            $data = [];
            $formattedTimes = [];

            foreach ($allCategoriesData as $categoryId => $category) {
                if ($category['request_count'] > 0) {
                    $avgSeconds = $category['total_seconds'] / $category['request_count'];

                    $labels[] = $category['name'];
                    $data[] = round($avgSeconds / 3600, 2); // Convert to hours

                    // Format nice human-readable time
                    $days = floor($avgSeconds / 86400);
                    $hours = floor(($avgSeconds % 86400) / 3600);
                    $minutes = floor(($avgSeconds % 3600) / 60);

                    $formattedTime = '';
                    if ($days > 0) $formattedTime .= "$days days ";
                    if ($hours > 0 || $days > 0) $formattedTime .= "$hours hrs ";
                    if ($minutes > 0 || $hours > 0 || $days > 0) $formattedTime .= "$minutes min";
                    if (empty($formattedTime)) $formattedTime = "Less than 1 min";

                    $formattedTimes[] = $formattedTime;
                }
            }

            return response()->json([
                'success' => true,
                'labels' => $labels,
                'data' => $data,
                'formattedTimes' => $formattedTimes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting turnaround times: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate average turnaround time for all technicians
     *
     * @return array
     */
    private function calculateAverageTurnaroundTimeAllTechnicians()
    {
        try {
            // Get all technicians
            $technicians = User::whereHas('role', function($query) {
                $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
            })->pluck('philrice_id')->toArray();

            $totalSeconds = 0;
            $totalRequests = 0;

            // Calculate turnaround time for each technician
            foreach ($technicians as $technicianId) {
                $result = $this->calculateTurnaroundTime($technicianId);

                if ($result['success'] && isset($result['total_seconds']) && isset($result['requests_processed'])) {
                    $totalSeconds += $result['total_seconds'];
                    $totalRequests += $result['requests_processed'];
                }
            }

            // Calculate the overall average
            if ($totalRequests > 0) {
                $averageSeconds = $totalSeconds / $totalRequests;

                // Format the time
                $days = floor($averageSeconds / 86400);
                $hours = floor(($averageSeconds % 86400) / 3600);
                $minutes = floor(($averageSeconds % 3600) / 60);
                $seconds = floor($averageSeconds % 60);

                $formattedTime = '';
                if ($days > 0) $formattedTime .= "$days days ";
                if ($hours > 0 || $days > 0) $formattedTime .= "$hours hrs ";
                if ($minutes > 0 || $hours > 0 || $days > 0) $formattedTime .= "$minutes min";

                return [
                    'success' => true,
                    'average_turnaround_time' => $formattedTime,
                    'average_seconds' => $averageSeconds,
                    'total_requests' => $totalRequests
                ];
            }

            return [
                'success' => true,
                'average_turnaround_time' => '0 hrs 0 min',
                'average_seconds' => 0,
                'total_requests' => 0
            ];

        } catch (\Exception $e) {
            \Log::error('Error calculating average turnaround time: ' . $e->getMessage());

            return [
                'success' => false,
                'average_turnaround_time' => '0 hrs 0 min',
                'average_seconds' => 0,
                'total_requests' => 0,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get average turnaround time (API endpoint)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAverageTurnaroundTime(Request $request)
    {
        $categoryId = $request->input('category_id');

        // If category_id is provided, filter by category
        if ($categoryId) {
            // Calculate category-specific turnaround time
            $technicians = User::whereHas('role', function($query) {
                $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
            })->pluck('philrice_id')->toArray();

            $totalSeconds = 0;
            $totalRequests = 0;

            foreach ($technicians as $techId) {
                $result = $this->calculateTurnaroundTimeByCategory($techId);
                if ($result['success'] && !empty($result['categories'])) {
                    foreach ($result['categories'] as $category) {
                        if ($category['category_id'] == $categoryId) {
                            $totalSeconds += $category['total_seconds'];
                            $totalRequests += $category['request_count'];
                            break;
                        }
                    }
                }
            }

            if ($totalRequests > 0) {
                $averageSeconds = $totalSeconds / $totalRequests;

                // Format the average time
                $days = floor($averageSeconds / 86400);
                $hours = floor(($averageSeconds % 86400) / 3600);
                $minutes = floor(($averageSeconds % 3600) / 60);
                $seconds = floor($averageSeconds % 60);

                $formattedTime = '';
                if ($days > 0) $formattedTime .= "$days days ";
                if ($hours > 0 || $days > 0) $formattedTime .= "$hours hrs ";
                if ($minutes > 0 || $hours > 0 || $days > 0) $formattedTime .= "$minutes min ";
                $formattedTime .= "$seconds sec";

                return response()->json([
                    'success' => true,
                    'average_turnaround_time' => $formattedTime,
                    'average_seconds' => $averageSeconds,
                    'total_requests' => $totalRequests
                ]);
            }
        }

        // Use the existing method for general average
        $data = $this->calculateAverageTurnaroundTimeAllTechnicians();
        return response()->json($data);
    }
}
