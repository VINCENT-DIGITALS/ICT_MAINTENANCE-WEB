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
        $averageTurnaroundTime = ServiceRequest::whereNotNull('updated_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as average_turnaround_time_seconds')
            ->value('average_turnaround_time_seconds');

        // Calculate hours and minutes
        $hours = floor($averageTurnaroundTime / 3600);
        $minutes = floor(($averageTurnaroundTime % 3600) / 60);

        // Format the output as "X hrs Y mins"
        $averageTurnaroundTimeFormatted = "{$hours} hrs {$minutes} mins";

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

    public function getResolutionTimeData()
    {
        $categories = DB::table('lib_categories')->pluck('category_name');

        // Dummy average resolution time (modify this based on actual data)
        $averageTimes = array_fill(0, count($categories), 12.5);

        return response()->json([
            'categories' => $categories,
            'averageTimes' => $averageTimes
        ]);
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
}
