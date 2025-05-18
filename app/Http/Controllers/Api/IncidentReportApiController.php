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

        $technicians = User::whereHas('role', function ($query) {
            $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
        })->get();

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
            ->orderBy('date_reported', 'desc')
            ->get();
                
        return response()->json([
            'categories' => $categories,
            'technicians' => $technicians,
            'incidents' => $incidents
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
        ]);

        try {
            $reporterId = Auth::check() ? (int)Auth::id() : 1;

            $reporterName = $request->reporter_name ?? 'Anonymous';
            if (empty($reporterName) && Auth::check()) {
                $user = Auth::user();
                $reporterName = $user->name ?? ($user->firstname . ' ' . $user->lastname) ?? 'Anonymous';
            }

            $verifierId = !empty($request->verifier_id) ? (int)$request->verifier_id : null;
            $verifierName = $verifierId ? optional(DB::table('users')->where('id', $verifierId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $verifierId)->first())->lastname : null;

            $approverId = !empty($request->approver_id) ? (int)$request->approver_id : null;
            $approverName = $approverId ? optional(DB::table('users')->where('id', $approverId)->first())->firstname . ' ' . optional(DB::table('users')->where('id', $approverId)->first())->lastname : null;

            $incidentDateTime = date('Y-m-d H:i:s', strtotime($request->incident_date . ' ' . $request->incident_time));

            DB::table('lib_incident_reports')->insert([
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

            return response()->json(['success' => true, 'message' => 'Incident reported successfully!']);
        } catch (\Exception $e) {
            // \Log::error('Error creating incident report: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error creating incident report: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'priority_level' => 'required|string',
            'incident_name' => 'required|string',
            'incident_nature' => 'required|string',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'location' => 'required|string',
        ]);

        try {
            $incident = DB::table('lib_incident_reports')->where('id', $id)->first();

            if (!$incident) {
                return response()->json(['success' => false, 'error' => 'Incident report not found'], 404);
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

            return response()->json(['success' => true, 'message' => 'Incident report updated successfully!']);
        } catch (\Exception $e) {
            // \Log::error('Error updating incident report: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error updating incident report: ' . $e->getMessage()], 500);
        }
    }


    public function resolve(Request $request, $id)
    {
        $request->validate([
            'findings' => 'required|string',
            'recommendations' => 'required|string',
        ]);

        try {
            $incident = DB::table('lib_incident_reports')->where('id', $id)->first();

            if (!$incident) {
                return response()->json(['success' => false, 'error' => 'Incident report not found.'], 404);
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

            return response()->json(['success' => true, 'message' => 'Incident marked as resolved successfully!']);
        } catch (\Exception $e) {
            // \Log::error('Error resolving incident: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error resolving incident: ' . $e->getMessage()], 500);
        }
    }
}
