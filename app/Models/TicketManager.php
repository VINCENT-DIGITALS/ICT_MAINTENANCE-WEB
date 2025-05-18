<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ServiceRequest;
use App\Models\Tickets;

class TicketManager extends Model
{
    use HasFactory;

    /**
     * This model doesn't use a database table directly
     * as it's primarily a utility class for ticket operations
     */
    public $timestamps = false;

    /**
     * Get ticket information for a service request
     *
     * @param int $requestId
     * @return array
     */
    public static function getTicketInfo($requestId)
    {
        $ticket = Tickets::where('request_id', $requestId)->first();

        if (!$ticket) {
            return [
                'status' => false,
                'ticket_full' => 'No Ticket',
                'ticket_series' => null,
                'ticket_category' => null,
                'ticket_year' => null,
                'ticket_month' => null
            ];
        }

        return [
            'status' => true,
            'ticket_full' => $ticket->ticket_full,
            'ticket_series' => $ticket->ticket_series,
            'ticket_category' => $ticket->ticket_category,
            'ticket_year' => $ticket->ticket_year,
            'ticket_month' => $ticket->ticket_month
        ];
    }

    /**
     * Get all tickets for a specific category
     *
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getTicketsByCategory($category)
    {
        return Tickets::where('ticket_category', $category)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get tickets for a date range
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getTicketsForDateRange($startDate, $endDate)
    {
        return Tickets::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Generate next ticket number for a category
     *
     * @param string $category
     * @return array
     */
    public static function generateNextTicketNumber($category)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $latestTicket = Tickets::where('ticket_category', $category)
            ->where('ticket_year', $currentYear)
            ->where('ticket_month', $currentMonth)
            ->orderBy('ticket_series', 'desc')
            ->first();

        $nextSeries = $latestTicket ? intval($latestTicket->ticket_series) + 1 : 1;
        $nextSeriesFormatted = str_pad($nextSeries, 2, '0', STR_PAD_LEFT);

        $ticketFull = "{$category}-{$currentYear}-{$currentMonth}-{$nextSeriesFormatted}";

        return [
            'ticket_category' => $category,
            'ticket_year' => $currentYear,
            'ticket_month' => $currentMonth,
            'ticket_series' => $nextSeriesFormatted,
            'ticket_full' => $ticketFull
        ];
    }

    /**
     * Associate requests with their ticket information
     *
     * @param \Illuminate\Database\Eloquent\Collection $requests
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function enrichRequestsWithTickets($requests)
    {
        foreach ($requests as $request) {
            $ticketInfo = self::getTicketInfo($request->id);
            $request->ticket_full = $ticketInfo['ticket_full'];
        }

        return $requests;
    }

    /**
     * Create a new ticket for a service request
     *
     * @param int $requestId
     * @param string $category
     * @return Tickets
     */
    public static function createTicket($requestId, $category)
    {
        $nextTicket = self::generateNextTicketNumber($category);

        return Tickets::create([
            'request_id' => $requestId,
            'ticket_category' => $nextTicket['ticket_category'],
            'ticket_year' => $nextTicket['ticket_year'],
            'ticket_month' => $nextTicket['ticket_month'],
            'ticket_series' => $nextTicket['ticket_series'],
            'ticket_full' => $nextTicket['ticket_full']
        ]);
    }
}
