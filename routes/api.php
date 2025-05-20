<?php

use App\Http\Controllers\Api\PendingRequestApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PickedRequestApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\OngoingRequestApiController;
use App\Http\Controllers\Api\CompletedRequestApiController;
use App\Http\Controllers\Api\PingController;
use App\Http\Controllers\Api\IncidentReportApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Add this with your other API routes
Route::get('/ping', [PingController::class, 'ping']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::get('/dashboard', [DashboardApiController::class, 'dashboardData']);
Route::post('/dashboard/storeNewRequest', [DashboardApiController::class, 'storeNewRequest']);
Route::post('/dashboard/checkUserPendingRequestsLimit/{id}', [DashboardApiController::class, 'checkUserPendingRequestsLimit']);

Route::get('/picked', [PickedRequestApiController::class, 'fetchpPickedRequests']);
Route::post('/picked/changeToOngoing/{id}/{user_idno}', [PickedRequestApiController::class, 'markAsOngoing']);

Route::get('/pending', [PendingRequestApiController::class, 'fetchpPendingRequests']);

Route::post('/pending/changeToPicked/{id}/{user_idno}', [PendingRequestApiController::class, 'markAsPicked']);

Route::get('/ongoing', [OngoingRequestApiController::class, 'fetchOngoingRequests']);
Route::get('/ongoing/historyDetails/{id}/', [OngoingRequestApiController::class, 'fetchRequestWithHistoryAndWorkingTime']);
Route::post('/ongoing/sendMessageToClient', [OngoingRequestApiController::class, 'sendMessageToClient']);
// Request status update routes
Route::post('/ongoing/complete', [OngoingRequestApiController::class, 'markAsComplete']);
Route::post('/ongoing/pause', [OngoingRequestApiController::class, 'markAsPaused']);
Route::post('/ongoing/deny', [OngoingRequestApiController::class, 'markAsDenied']);
Route::post('/ongoing/cancel', [OngoingRequestApiController::class, 'markAsCancelled']);
Route::post('/ongoing/ongoing', [OngoingRequestApiController::class, 'markAsOngoing']);
Route::get('/technicians/available', [OngoingRequestApiController::class, 'fetchAvailableTechnicians']);
Route::post('/ongoing/service-requests/update-technicians', [OngoingRequestApiController::class, 'updateTechnicians']);
Route::get('/ongoing/actions-taken', [OngoingRequestApiController::class, 'fetchActionsTaken']);

Route::get('/ongoing/problems-encountered', [OngoingRequestApiController::class, 'fetchProblemsEncountered']);



Route::get('/completed', [CompletedRequestApiController::class, 'fetchCompleteRequests']);
Route::post('/completed/sendMessageToClient', [CompletedRequestApiController::class, 'sendMessageToClient']);


Route::get('/incident-reports', [IncidentReportApiController::class, 'customerFeedRequests']);
//For resolve
Route::post('/incident-reports/resolve', [IncidentReportApiController::class, 'resolve']);
//For store
Route::post('/incident-reports/store', [IncidentReportApiController::class, 'store']);
Route::post('/incident-reports/update/{id}', [IncidentReportApiController::class, 'update']);
// Service Category API Routes
// Route::get('/categories', [App\Http\Controllers\Api\DashboardApiController::class, 'getServiceCategories']);
// Route::get('/categories/{categoryId}/subcategories', [App\Http\Controllers\Api\DashboardApiController::class, 'getSubcategories']);
Route::get('/categories-with-subcategories', [App\Http\Controllers\Api\DashboardApiController::class, 'getCategoriesWithSubcategories']);