<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseServiceController extends Controller
{
    public function index()
    {
        // Fetch only non-archived data from the database
        $problems = DB::table('lib_problems_encountered')
            ->where('is_archived', false) // Fetch only non-archived problems
            ->select('id', 'encountered_problem_name', 'category_id')
            ->get();

        $actions = DB::table('lib_actions_taken')
            ->where('is_archived', false) // Fetch only non-archived actions
            ->select('id', 'action_name', 'category_id')
            ->get();

        $categories = DB::table('lib_categories')->select('id', 'category_name')->get();

        $problemsCount = $problems->count();
        $actionsCount = $actions->count();

        // Pass data to the Blade view
        return view('ICT Main/database_service', compact('problems', 'actions', 'problemsCount', 'actionsCount', 'categories'));
    }

    public function addProblem(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:lib_categories,id', // Allow null if category_id is not mandatory
            'problem_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50', // Match the form field name
        ]);

        DB::table('lib_problems_encountered')->insert([
            'category_id' => $request->category_id, // This will be null if not provided
            'encountered_problem_name' => $request->problem_name,
            'encountered_problem_abbr' => $request->abbreviation, // Correctly map the abbreviation field
        ]);

        return redirect()->route('database_service.index')->with('success', 'Problem added successfully.');
    }

    public function deleteProblem($id)
    {
        try {
            $problem = DB::table('lib_problems_encountered')->where('id', $id)->first();

            if (!$problem) {
                return response()->json(['message' => 'Problem not found.'], 404);
            }

            // Archive the problem instead of deleting it
            DB::table('lib_problems_encountered')->where('id', $id)->update(['is_archived' => true]);

            return response()->json(['message' => 'Problem archived successfully.'], 200);
        } catch (\Exception $e) {
            \Log::error('Error archiving problem: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while archiving the problem.'], 500);
        }
    }

    public function archiveProblem($id)
    {
        try {
            // Log the incoming request for debugging
            \Log::info("Archiving problem with ID: $id");

            // Fetch the problem by ID
            $problem = DB::table('lib_problems_encountered')->where('id', $id)->first();

            if (!$problem) {
                \Log::error("Problem not found with ID: $id");
                return response()->json(['message' => 'Problem not found.'], 404);
            }

            // Archive the problem
            DB::table('lib_problems_encountered')->where('id', $id)->update(['is_archived' => true]);

            \Log::info("Problem archived successfully with ID: $id");
            return response()->json(['message' => 'Problem archived successfully.'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error archiving problem: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while archiving the problem.'], 500);
        }
    }

    public function addAction(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:lib_categories,id',
            'action_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:50',
        ]);

        DB::table('lib_actions_taken')->insert([
            'category_id' => $request->category_id,
            'action_name' => $request->action_name,
            'action_abbr' => $request->abbreviation,
        ]);

        return redirect()->route('database_service.index')->with('success', 'Action added successfully.');
    }

    public function deleteAction($id)
    {
        try {
            $action = DB::table('lib_actions_taken')->where('id', $id)->first();

            if (!$action) {
                return response()->json(['message' => 'Action not found.'], 404);
            }

            // Archive the action instead of deleting it
            DB::table('lib_actions_taken')->where('id', $id)->update(['is_archived' => true]);

            return response()->json(['message' => 'Action archived successfully.'], 200);
        } catch (\Exception $e) {
            \Log::error('Error archiving action: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while archiving the action.'], 500);
        }
    }

    public function archiveAction($id)
    {
        try {
            // Log the incoming request for debugging
            \Log::info("Archiving action with ID: $id");

            // Fetch the action by ID
            $action = DB::table('lib_actions_taken')->where('id', $id)->first();

            if (!$action) {
                \Log::error("Action not found with ID: $id");
                return response()->json(['message' => 'Action not found.'], 404);
            }

            // Archive the action
            DB::table('lib_actions_taken')->where('id', $id)->update(['is_archived' => true]);

            \Log::info("Action archived successfully with ID: $id");
            return response()->json(['message' => 'Action archived successfully.'], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error archiving action: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while archiving the action.'], 500);
        }
    }
}
