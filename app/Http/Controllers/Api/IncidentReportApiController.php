<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Servicecategory;
use App\Models\Technician;
use App\Models\User;  // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncidentReportApiController extends Controller
{

    public function customerFeedRequests()
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Get technicians 
        $technicians = Technician::has('libTechnician')->get();

        // Fetch all incident reports, including resolved ones
        $incidents = DB::table('lib_incident_reports')
            ->select(
                'id',
                'incident_nature',
                'date_reported',
                'incident_date',
                'incident_name',
                'subject',
                'description',
                'reporter_id',
                'reporter_name',
                'reporter_position',
                'verifier_id',
                'verifier_name',
                'approver_id',
                'approver_name',
                'priority_level',
                'status',
                'location',
                'impact',
                'affected_areas'
            )
            ->get();

        // Return response in standardized format
        return response()->json([
            'status' => true,
            'data' => [
                'incidents' => $incidents,
                'incidentsCount' => $incidents->count(),
                'categories' => $categories,
                'technicians' => $technicians
            ]
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'priority_level' => 'required|string',
            'incident_name' => 'required|string',
            'incident_nature' => 'required|string',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'location' => 'required|string',
            'reporter_id' => 'required|integer', // Require reporter ID from the request
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $reporterId = (int)$request->reporter_id;

                // Get user information from the database
                $reporter = DB::table('users')->where('id', $reporterId)->first();

                $reporterName = $request->reporter_name ?? null;
                if (empty($reporterName) && $reporter) {
                    $reporterName = $reporter->name ?? ($reporter->firstname . ' ' . $reporter->lastname) ?? 'Unknown';
                } else if (empty($reporterName)) {
                    $reporterName = 'Anonymous';
                }

                $verifierId = !empty($request->verifier_id) ? (int)$request->verifier_id : null;
                $verifierName = $verifierId ? optional(DB::table('users')->where('id', $verifierId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $verifierId)->first())->lastname : null;

                $approverId = !empty($request->approver_id) ? (int)$request->approver_id : null;
                $approverName = $approverId ? optional(DB::table('users')->where('id', $approverId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $approverId)->first())->lastname : null;

                $incidentDateTime = date('Y-m-d H:i:s', strtotime($request->incident_date . ' ' . $request->incident_time));

                $incidentId = DB::table('lib_incident_reports')->insertGetId([
                    'incident_nature' => (string)$request->incident_nature,
                    'date_reported' => now(),
                    'incident_date' => $incidentDateTime,
                    'incident_name' => (string)$request->incident_name,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'reporter_id' => $reporterId,
                    'reporter_name' => (string)$reporterName,
                    'reporter_position' => $request->reporter_position,
                    'verifier_id' => $verifierId,
                    'verifier_name' => $verifierName,
                    'approver_id' => $approverId,
                    'approver_name' => $approverName,
                    'priority_level' => (string)$request->priority_level,
                    'status' => 'Not Resolved',
                    'location' => (string)$request->location,
                    'impact' => $request->impact,
                    'affected_areas' => $request->affected_areas,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Incident reported successfully!',
                        'incident_id' => $incidentId
                    ]
                ]);
            } catch (\Exception $e) {
                // \Log::error('Error creating incident report: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Error creating incident report: ' . $e->getMessage()
                    ]
                ], 500);
            }
        });
    }

    public function update(Request $request, $id)
    {
        // Validate the ID parameter
        if (!is_numeric($id) || (int)$id <= 0) {
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Invalid incident ID'
                ]
            ], 400);
        }

        $request->validate([
            'id' => 'required|integer|exists:lib_incident_reports,id', // Add validation for ID
            'priority_level' => 'required|string',
            'incident_name' => 'required|string',
            'incident_nature' => 'required|string',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'location' => 'required|string',
        ]);

        return DB::transaction(function () use ($request, $id) {
            try {
                $incident = DB::table('lib_incident_reports')->where('id', $id)->first();

                if (!$incident) {
                    return response()->json([
                        'status' => false,
                        'data' => [
                            'message' => 'Incident report not found'
                        ]
                    ], 404);
                }

                $verifierId = !empty($request->verifier_id) ? (int)$request->verifier_id : null;
                $verifierName = $verifierId ? optional(DB::table('users')->where('id', $verifierId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $verifierId)->first())->lastname : null;

                $approverId = !empty($request->approver_id) ? (int)$request->approver_id : null;
                $approverName = $approverId ? optional(DB::table('users')->where('id', $approverId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $approverId)->first())->lastname : null;

                $incidentDateTime = date('Y-m-d H:i:s', strtotime($request->incident_date . ' ' . $request->incident_time));

                DB::table('lib_incident_reports')->where('id', $id)->update([
                    'incident_name' => (string)$request->incident_name,
                    'incident_nature' => (string)$request->incident_nature,
                    'incident_date' => $incidentDateTime,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'verifier_id' => $verifierId,
                    'verifier_name' => $verifierName,
                    'approver_id' => $approverId,
                    'approver_name' => $approverName,
                    'priority_level' => (string)$request->priority_level,
                    'location' => (string)$request->location,
                    'impact' => $request->impact,
                    'affected_areas' => $request->affected_areas,
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Incident report updated successfully!',
                        'incident_id' => $id
                    ]
                ]);
            } catch (\Exception $e) {
                // \Log::error('Error updating incident report: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Error updating incident report: ' . $e->getMessage()
                    ]
                ], 500);
            }
        });
    }


    public function resolve(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'findings' => 'required|string',
            'recommendations' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $id = $request->id;

                // Get the incident with a lock to prevent concurrent modifications
                $incident = DB::table('lib_incident_reports')
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->first();

                if (!$incident) {
                    return response()->json([
                        'status' => false,
                        'data' => [
                            'message' => 'Incident report not found.'
                        ]
                    ], 404);
                }

                // Check if already resolved to prevent duplicate resolutions
                if ($incident->status === 'Resolved') {
                    return response()->json([
                        'status' => false,
                        'data' => [
                            'message' => 'Incident report is already resolved.'
                        ]
                    ], 409);
                }

                DB::table('lib_findings_recommendations')->insert([
                    'incident_report_id' => $id,
                    'findings' => $request->findings,
                    'recommendations' => $request->recommendations,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('lib_incident_reports')->where('id', $id)->update([
                    'status' => 'Resolved',
                    'updated_at' => now(),
                ]);

                // Get the updated incident with findings
                $updatedIncident = DB::table('lib_incident_reports')
                    ->where('id', $id)
                    ->first();

                $findings = DB::table('lib_findings_recommendations')
                    ->where('incident_report_id', $id)
                    ->latest()
                    ->first();

                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Incident marked as resolved successfully!',
                        'incident' => $updatedIncident,
                        'findings' => $findings
                    ]
                ]);
            } catch (\Exception $e) {
                // \Log::error('Error resolving incident: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'Error resolving incident: ' . $e->getMessage()
                    ]
                ], 500);
            }
        });
    }
}
