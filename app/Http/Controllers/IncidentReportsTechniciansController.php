<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Ensure User model is imported

class IncidentReportsTechniciansController extends Controller
{
    public function getTechnicians()
    {
        // Fetch all users' names
        $technicians = User::select('id', 'name')->get();

        // Return as JSON response for frontend consumption
        return response()->json($technicians);
    }
}
