<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\LibTechnician;
use App\Models\PrimaryTechnicianRequest;
use App\Models\Tickets;

class ServiceRequestController extends Controller
{
    public function getFirstTicketForTechnicians()
    {
        // Get all technician IDs
        $technicians = LibTechnician::pluck('user_idno');

        $nowServing = [];

        foreach ($technicians as $technicianId) {
            // Get the first primary technician request for this technician
            $primaryRequest = PrimaryTechnicianRequest::where('technician_emp_id', $technicianId)
                ->orderBy('id')
                ->first();

            if ($primaryRequest) {
                // Get the associated ticket using the request_id
                $ticket = Tickets::where('request_id', $primaryRequest->request_id)->first();

                $nowServing[] = [
                    'technician_emp_id' => $technicianId,
                    'request_id' => $primaryRequest->request_id,
                    'ticket_full' => optional($ticket)->ticket_full ?? 'No ticket found',
                ];
            } else {
                $nowServing[] = [
                    'technician_emp_id' => $technicianId,
                    'request_id' => null,
                    'ticket_full' => 'No request found',
                ];
            }
        }

        // Remove the dd() statement or comment it out for debugging
        dd($nowServing);

        return view('ICT Main.requests', compact('nowServing'));
    }
}
