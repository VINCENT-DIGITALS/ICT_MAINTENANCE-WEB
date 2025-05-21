<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Technician;
class CustomerFeedbackController extends Controller
{
    /**
     * Display customer feedback statistics
     */
    public function index(Request $request)
    {
        // Get all technicians
       $technicians = Technician::has('libTechnician')
    ->where('archived', false)
    ->select('name', 'philrice_id')
    ->orderBy('name')
    ->get();

        // Get all categories
        $categories = DB::table('lib_categories')
            ->pluck('category_name', 'id');

        // Get feedback statistics
        $feedbackStats = $this->getFeedbackStats($request->technician_id, $request->category_id, $request->from_date, $request->to_date);

        return view('ICT Main.customer_feed', [
            'technicians' => $technicians,
            'categories' => $categories,
            'feedbackStats' => $feedbackStats
        ]);
    }

    /**
     * Get feedback statistics with optional filtering
     */
    private function getFeedbackStats($technicianId = null, $categoryId = null, $fromDate = null, $toDate = null)
    {
        // Start building the query for evaluations
        $query = DB::table('evaluation_request')
            ->join('service_requests', 'evaluation_request.request_id', '=', 'service_requests.id')
            ->join('primarytechnician_request', 'service_requests.id', '=', 'primarytechnician_request.request_id')
            ->join('evaluation_ratings', 'evaluation_request.id', '=', 'evaluation_ratings.evaluation_id');

        // Apply filters
        if ($technicianId) {
            $query->where('primarytechnician_request.technician_emp_id', $technicianId);
        }

        if ($categoryId) {
            $query->where('service_requests.category_id', $categoryId);
        }

        if ($fromDate) {
            $query->where('evaluation_request.created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->where('evaluation_request.created_at', '<=', $toDate . ' 23:59:59');
        }

        // Get evaluation data
        $evaluations = $query->select(
            'evaluation_request.realiability_quality',
            'evaluation_request.responsiveness',
            'evaluation_request.outcome',
            'evaluation_request.assurance_integrity',
            'evaluation_request.access_facility',
            'evaluation_ratings.overall_rating' // Make sure we're getting overall_rating from evaluation_ratings table
        )->get();

        $totalResponses = $evaluations->count();

        // If no responses, return zeroed stats
        if ($totalResponses === 0) {
            return [
                'total_responses' => 0,
                'overall_rating' => [
                    'percentage' => 0,
                    'label' => 'N/A'
                ],
                'dimensions' => [
                    'realiability_quality' => $this->getEmptyDimensionStats(),
                    'responsiveness' => $this->getEmptyDimensionStats(),
                    'outcome' => $this->getEmptyDimensionStats(),
                    'assurance_integrity' => $this->getEmptyDimensionStats(),
                    'access_facility' => $this->getEmptyDimensionStats()
                ],
                'rating_distribution' => [
                    'poor' => 0,
                    'fair' => 0,
                    'good' => 0,
                    'very_good' => 0,
                    'excellent' => 0
                ]
            ];
        }

        // Calculate averages and distributions for each dimension
        $dimensions = [
            'realiability_quality' => $this->calculateDimensionStats($evaluations, 'realiability_quality'),
            'responsiveness' => $this->calculateDimensionStats($evaluations, 'responsiveness'),
            'outcome' => $this->calculateDimensionStats($evaluations, 'outcome'),
            'assurance_integrity' => $this->calculateDimensionStats($evaluations, 'assurance_integrity'),
            'access_facility' => $this->calculateDimensionStats($evaluations, 'access_facility')
        ];

        // Calculate overall rating
        $overallAvg = $evaluations->avg('overall_rating');
        $overallPercentage = round($overallAvg);
        $overallLabel = $this->getRatingLabel($overallPercentage);

        // Calculate rating distribution for pie chart
        $ratingDistribution = [
            'poor' => 0,
            'fair' => 0,
            'good' => 0,
            'very_good' => 0,
            'excellent' => 0
        ];

        foreach ($evaluations as $evaluation) {
            $rating = round($evaluation->overall_rating);
            if ($rating < 60) {
                $ratingDistribution['poor']++;
            } elseif ($rating < 70) {
                $ratingDistribution['fair']++;
            } elseif ($rating < 80) {
                $ratingDistribution['good']++;
            } elseif ($rating < 90) {
                $ratingDistribution['very_good']++;
            } else {
                $ratingDistribution['excellent']++;
            }
        }

        // Convert counts to percentages
        foreach ($ratingDistribution as $key => $value) {
            $ratingDistribution[$key] = round(($value / $totalResponses) * 100);
        }

        return [
            'total_responses' => $totalResponses,
            'overall_rating' => [
                'percentage' => $overallPercentage,
                'label' => $overallLabel
            ],
            'dimensions' => $dimensions,
            'rating_distribution' => $ratingDistribution
        ];
    }

    /**
     * Get empty dimension stats
     */
    private function getEmptyDimensionStats()
    {
        return [
            'average' => 0,
            'percentage' => 0,
            'label' => 'N/A',
            'distribution' => [
                1 => ['count' => 0, 'percentage' => 0],
                2 => ['count' => 0, 'percentage' => 0],
                3 => ['count' => 0, 'percentage' => 0],
                4 => ['count' => 0, 'percentage' => 0],
                5 => ['count' => 0, 'percentage' => 0]
            ]
        ];
    }

    /**
     * Calculate statistics for a dimension
     */
    private function calculateDimensionStats($evaluations, $dimension)
    {
        $total = $evaluations->count();
        $avg = $evaluations->avg($dimension);

        // Calculate rating distribution for this dimension
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $evaluations->where($dimension, $i)->count();
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round(($count / $total) * 100)
            ];
        }

        // Convert 5-point scale to 100-point scale
        $percentage = round($avg * 20);

        return [
            'average' => $avg,
            'percentage' => $percentage,
            'label' => $this->getRatingLabel($percentage),
            'distribution' => $distribution
        ];
    }

    /**
     * Get descriptive label for a rating percentage
     */
    private function getRatingLabel($percentage)
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

        return 'N/A';
    }

    /**
     * AJAX endpoint for getting filtered feedback stats
     */
    public function getFilteredStats(Request $request)
    {
        $technicianId = $request->input('technician_id');
        $categoryId = $request->input('category_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $stats = $this->getFeedbackStats($technicianId, $categoryId, $fromDate, $toDate);

        return response()->json($stats);
    }
}
