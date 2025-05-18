<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;

    protected $table = 'request_status';

    protected $fillable = [
        'request_id',
        'status_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the status associated with the request status.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\LibStatus', 'status_id');
    }

    /**
     * Get the service request that owns the request status.
     */
    public function serviceRequest()
    {
        return $this->belongsTo('App\Models\ServiceRequest', 'request_id');
    }
}
