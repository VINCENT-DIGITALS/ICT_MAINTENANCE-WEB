<?php
namespace App\Http\Controllers;

use App\Models\Servicecategory;
use App\Models\Technician;
use App\Models\User;
use App\Models\LibVerifier;
use App\Models\LibApprover;
use App\Models\LibIncidentReport; // Add this import
use App\Models\LibFindingsRecommendation; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncidentReportController extends Controller
{
    public function customerFeedRequests()
    {
        $categories = Servicecategory::pluck('category_name', 'id');

        // Replace this line
        $technicians = User::whereHas('role', function($query) {
            $query->whereIn('role_name', ['Super Administrator', 'Administrator', 'Technician', 'Station Technician']);
        })->get();

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
            ->orderBy('date_reported', 'desc')
            ->get();

        return view('ICT Main/incident_reports', compact('categories', 'technicians', 'incidents'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the existing fields...

            // Get verifier data
            $verifierId = null;
            $verifierName = null;

            if ($request->filled('verifier_name')) {
                $verifierName = $request->input('verifier_name');
                // Store the verifier name in the lib_verifiers table for future autocomplete
                if (!empty($verifierName)) {
                    LibVerifier::firstOrCreate(
                        ['name' => $verifierName],
                        ['position' => null, 'is_active' => true]
                    );
                }
            }

            // Get approver data
            $approverId = null;
            $approverName = null;

            if ($request->filled('approver_name')) {
                $approverName = $request->input('approver_name');
                // Store the approver name in the lib_approvers table for future autocomplete
                if (!empty($approverName)) {
                    LibApprover::firstOrCreate(
                        ['name' => $approverName],
                        ['position' => null, 'is_active' => true]
                    );
                }
            }

            // Create the incident report with proper IDs and names
            $incident = new LibIncidentReport();
            $incident->incident_nature = $request->input('incident_nature');
            $incident->date_reported = now();
            $incident->incident_date = $request->input('incident_date') . ' ' . $request->input('incident_time');
            $incident->incident_name = $request->input('incident_name');
            $incident->subject = $request->input('subject');
            $incident->description = $request->input('description');
            $incident->reporter_id = $request->input('reporter_id', auth()->id() ?? 1);
            $incident->reporter_name = $request->input('reporter_name', auth()->user()->name ?? 'Anonymous');
            $incident->reporter_position = $request->input('reporter_position');
            $incident->verifier_id = null; // We're not using ID references anymore
            $incident->verifier_name = $verifierName; // Store just the name
            $incident->approver_id = null; // We're not using ID references anymore
            $incident->approver_name = $approverName; // Store just the name
            $incident->priority_level = $request->input('priority_level');
            $incident->status = 'Not Resolved';
            $incident->location = $request->input('location');
            $incident->impact = $request->input('impact');
            $incident->affected_areas = $request->input('affected_areas');
            $incident->save();

            // Redirect with success message
            return redirect()->route('incident_reports')->with('success', 'Incident report created successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating incident report: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return with error message
            return redirect()->back()->with('error', 'Error creating incident report: ' . $e->getMessage())
                ->withInput(); // Preserve the form input
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
            // Find the incident report using the model
            $incident = LibIncidentReport::find($id);

            if (!$incident) {
                return redirect()->back()
                    ->with('error', 'Incident report not found')
                    ->withInput();
            }

            // Get verifier data
            $verifierName = $request->input('verifier_name');
            if (!empty($verifierName)) {
                // Store the verifier name in the lib_verifiers table for future autocomplete
                LibVerifier::firstOrCreate(
                    ['name' => $verifierName],
                    ['position' => null, 'is_active' => true]
                );
            }

            // Get approver data
            $approverName = $request->input('approver_name');
            if (!empty($approverName)) {
                // Store the approver name in the lib_approvers table for future autocomplete
                LibApprover::firstOrCreate(
                    ['name' => $approverName],
                    ['position' => null, 'is_active' => true]
                );
            }

            // Combine date and time
            $incidentDateTime = date('Y-m-d H:i:s', strtotime($request->incident_date . ' ' . $request->incident_time));

            // Update the incident report using the model
            $incident->incident_name = $request->incident_name;
            $incident->incident_nature = $request->incident_nature;
            $incident->incident_date = $incidentDateTime;
            $incident->subject = $request->subject;
            $incident->description = $request->description;
            $incident->verifier_id = null; // We're not using ID references anymore
            $incident->verifier_name = $verifierName; // Store just the name
            $incident->approver_id = null; // We're not using ID references anymore
            $incident->approver_name = $approverName; // Store just the name
            $incident->priority_level = $request->priority_level;
            $incident->location = $request->location;
            $incident->impact = $request->impact;
            $incident->affected_areas = $request->affected_areas;
            $incident->save();

            return redirect()->route('incident_reports')
                ->with('success', 'Incident report updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating incident report: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error updating incident report: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function resolve(Request $request, $id)
    {
        $request->validate([
            'findings' => 'required|string',
            'recommendations' => 'required|string',
        ]);

        try {
            // Ensure the incident exists
            $incident = LibIncidentReport::find($id);

            if (!$incident) {
                return redirect()->back()->with('error', 'Incident report not found.');
            }

            // Insert findings and recommendations using the model
            LibFindingsRecommendation::create([
                'incident_report_id' => $id,
                'findings' => $request->findings,
                'recommendations' => $request->recommendations,
            ]);

            // Update the incident status to "Resolved"
            $incident->status = 'Resolved';
            $incident->save();

            return redirect()->route('incident_reports')->with('success', 'Incident marked as resolved successfully!');
        } catch (\Exception $e) {
            \Log::error('Error resolving incident: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error resolving incident: ' . $e->getMessage());
        }
    }

    /**
     * Get verifiers for autocomplete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVerifiers(Request $request)
    {
        $search = $request->input('search', '');

        $verifiers = LibVerifier::where('name', 'like', "%{$search}%")
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'position']);

        return response()->json($verifiers);
    }

    /**
     * Get approvers for autocomplete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApprovers(Request $request)
    {
        $search = $request->input('search', '');

        $approvers = LibApprover::where('name', 'like', "%{$search}%")
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'position']);

        return response()->json($approvers);
    }
}
