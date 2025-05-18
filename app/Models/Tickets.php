<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'requester_id',
        'ticket_category',
        'ticket_year',
        'ticket_month',
        'ticket_series',
        'ticket_full',
        'created_at',
        'updated_at'
    ];
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id', 'id');
    }
}
