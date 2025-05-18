<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePendingRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';

    protected $fillable = [
        'requester_id', 'request_title', 'request_description',
        'location', 'local_no', 'priority', 'is_complete', 
        'category_id', 'created_at', 'updated_at', 'is_paused'
    ];

    // Relationship with Servicecategory
    public function category()
    {
        return $this->belongsTo(Servicecategory::class, 'category_id');
    }
}
