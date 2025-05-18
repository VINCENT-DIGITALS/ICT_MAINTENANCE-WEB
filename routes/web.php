<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\dashboardPendingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompletedRequestController;
use App\Http\Controllers\CustomerFeedbackController;
use App\Http\Controllers\DashboardCotroller;
use App\Http\Controllers\DatabaseServiceController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\OngoingRequestController;
use App\Http\Controllers\PendingRequestController;
use App\Http\Controllers\PickedRequestController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\RequestStatusController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PickedRequestApiController;
use App\Http\Controllers\ServiceRequestController;

use App\Models\LibProblemsEncountered;
use App\Models\LibActionsTaken;

Route::post('/login', [UserController::class, 'login']);
Route::get('/picked', [PickedRequestApiController::class, 'fetchpPickedRequests']);

// Base routes - redirect to login if not authenticated
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Login routes with guest middleware to prevent authenticated users from accessing login page
// Login route – manually check if already authenticated
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login');

// Login POST
Route::post('/login', function (Request $request) {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return app(AuthController::class)->login($request);
});


// All protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardCotroller::class, 'dashboardData'])->name('dashboard');
    Route::get('/dashboard/subcategories/{categoryId}', [DashboardCotroller::class, 'getSubcategories']);
    Route::post('/dashboard/new-request', [DashboardCotroller::class, 'storeNewRequest'])->name('dashboard.new-request');

    // Unified endpoint for checking request limits
    Route::get('/api/check-request-limit', [DashboardCotroller::class, 'checkRequestLimit'])->name('api.check-request-limit');

    // Request management routes
    Route::get('/pending', [PendingRequestController::class, 'fetchpPendingRequests'])->name('pending');
    Route::get('/picked', [PickedRequestController::class, 'fetchpPickedRequests'])->name('picked');
    Route::get('/ongoing', [OngoingRequestController::class, 'fetchOngoingRequests'])->name('ongoing');
    Route::get('/completed', [CompletedRequestController::class, 'fetchpCompleteRequests'])->name('completed');
    Route::post('/pending/changeToPicked/{id}', [PendingRequestController::class, 'markAsPicked']);

    Route::post('/picked/changeToOngoing/{id}', [PickedRequestController::class, 'markAsOngoing']);
    Route::post('/message/send', [OngoingRequestController::class, 'sendMessageToClient'])->name('message.send');

    // Add the new route for sending messages from completed requests section
    Route::post('/completed/message/send', [CompletedRequestController::class, 'sendMessageToClient'])->name('completed.message.send');

    Route::post('/picked/changeOngoingStatus/{id}', [OngoingRequestController::class, 'changeToOngoing']);
    Route::post('/picked/changeOngoingStatus/{id}', [OngoingRequestController::class, 'markAsComplete']);
    Route::post('/picked/changeOngoingStatus/{id}', [OngoingRequestController::class, 'markAsPaused']);
    Route::post('/picked/changeOngoingStatus/{id}', [OngoingRequestController::class, 'markAsDenied']);

    Route::middleware(['auth'])->group(function () {
        // Request status update routes
        Route::post('/request/complete', [OngoingRequestController::class, 'markAsComplete'])->name('request.completed');
        Route::post('/request/pause', [OngoingRequestController::class, 'markAsPaused'])->name('request.paused');
        Route::post('/request/deny', [OngoingRequestController::class, 'markAsDenied'])->name('request.denied');
        Route::post('/request/cancel', [OngoingRequestController::class, 'markAsCancelled'])->name('request.cancelled');
        Route::post('/request/ongoing', [OngoingRequestController::class, 'markAsOngoing'])->name('request.ongoing');

        // API routes for problems and actionss
        Route::get('/api/problems-by-category/{category_id}', [OngoingRequestController::class, 'getProblemsByCategory']);
        Route::get('/api/actions-by-category/{category_id}', [OngoingRequestController::class, 'getActionsByCategory']);
    });
    // Feedback and reports
    Route::get('/customer_feed', [CustomerFeedbackController::class, 'customerFeedRequests'])->name('customer_feed');
    Route::get('/incident_reports', [IncidentReportController::class, 'customerFeedRequests'])->name('incident_reports');

    // Database management
    Route::get('/database_service', [DatabaseServiceController::class, 'index'])->name('database_service');
    Route::get('/database-service', [DatabaseServiceController::class, 'index'])->name('database_service.index');
    Route::post('/database-service/add-problem', [DatabaseServiceController::class, 'addProblem'])->name('database_service.add_problem');
    Route::delete('/database-service/delete-problem/{id}', [DatabaseServiceController::class, 'deleteProblem'])->name('database_service.delete_problem');
    Route::post('/database-service/add-action', [DatabaseServiceController::class, 'addAction'])->name('database_service.add_action');
    Route::delete('/database-service/delete-action/{id}', [DatabaseServiceController::class, 'deleteAction'])->name('database_service.delete_action');
    Route::post('/database-service/archive-problem/{id}', [DatabaseServiceController::class, 'archiveProblem'])->name('database_service.archive_problem');
    Route::post('/database-service/archive-action/{id}', [DatabaseServiceController::class, 'archiveAction'])->name('database_service.archive_action');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'categoryDropdown'])->name('analytics');
    Route::get('/analytics/data', [AnalyticsController::class, 'getResolutionTimeData'])->name('analytics.data');

    // Add this route to your existing routes
    Route::get('/analytics/requests-by-office', [AnalyticsController::class, 'getRequestsByOffice'])
        ->name('analytics.requests-by-office');

    // Incident reports
    Route::post('/incident-reports/store', [IncidentReportController::class, 'store'])->name('incident_reports.store');
    Route::put('/incident-reports/update/{id}', [IncidentReportController::class, 'update'])->name('incident_reports.update');
    Route::post('/incident-reports/resolve/{id}', [IncidentReportController::class, 'resolve'])->name('incident_reports.resolve');

    // Add these routes to your web.php file

    Route::get('/incident_reports/verifiers', [IncidentReportController::class, 'getVerifiers'])
        ->name('incident_reports.verifiers');

    Route::get('/incident_reports/approvers', [IncidentReportController::class, 'getApprovers'])
        ->name('incident_reports.approvers');

    // API routes for problems and actions


    // Add the submit-evaluation route to the RequestController
    Route::post('/submit-evaluation', [App\Http\Controllers\RequestController::class, 'submitEvaluation'])->name('submit-evaluation');

    // Authentication check endpoint
    Route::get('/api/check-auth', function () {
        if (Auth::check()) {
            return response()->json(['authenticated' => true], 200);
        }
        return response()->json(['authenticated' => false], 401);
    });

    // Customer Feedback routes
    Route::get('/customer_feed', [App\Http\Controllers\CustomerFeedbackController::class, 'index'])->name('customer_feed');
    Route::post('/customer_feed/filtered', [App\Http\Controllers\CustomerFeedbackController::class, 'getFilteredStats'])->name('customer_feed.filtered');
});

// Routes specifically for super administrators
Route::middleware(['auth', 'superadmin'])->group(function () {
    // Technician routes
    Route::get('/technician', [TechnicianController::class, 'technicians'])->name('technician.index');
    Route::post('/technician', [TechnicianController::class, 'store'])->name('technician.store');
    Route::put('/technician/{id}', [TechnicianController::class, 'update'])->name('technician.update');
    Route::get('/technician/{id}/stats', [TechnicianController::class, 'getStats'])->name('technician.stats');
    Route::post('/update-technician', [TechnicianController::class, 'updateTechnician'])->name('technician.update-role'); // Add this line
    Route::post('/archive-technician', [TechnicianController::class, 'archiveTechnician'])->name('technician.archive');

    // Add this route for technician details
    Route::get('/technician/{id}', [App\Http\Controllers\TechnicianController::class, 'technicianDetail'])->name('technician.detail');

    // Add routes for technician management
    Route::get('/technicians', [App\Http\Controllers\TechnicianController::class, 'technicians'])->name('technicians');
    Route::get('/technician/{id}', [App\Http\Controllers\TechnicianController::class, 'technicianDetail'])->name('technician.detail');
    Route::post('/update-technician', [App\Http\Controllers\TechnicianController::class, 'updateTechnician'])->name('technician.update');
    Route::post('/archive-technician', [App\Http\Controllers\TechnicianController::class, 'archiveTechnician'])->name('technician.archive');

    // Add this new route for calculating technician average turnaround time
    Route::get('/technician/{id}/turnaround-time', [TechnicianController::class, 'getTurnaroundTime'])
        ->name('technician.turnaround-time');

    // Request management route
    Route::get('/request', [RequestController::class, 'index'])->name('request.index');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/requests', function () {
    return view('ICT Main.requests');
})->name('requests');

// Add this if it doesn't exist
Route::get('/requests', [ServiceRequestController::class, 'getFirstTicketForTechnicians'])->name('requests');
