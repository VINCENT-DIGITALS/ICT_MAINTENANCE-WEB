<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';

    protected $fillable = [
        'requester_id',
        'request_title',
        'request_description',
        'location',
        'local_no',
        'priority',
        'is_complete',
        'category_id',
        'created_at',
        'updated_at'
    ];

    // Relationship with Servicecategory
    public function category()
    {
        return $this->belongsTo(Servicecategory::class, 'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function primaryTechnician()
    {
        return $this->hasOne(PrimaryTechnicianRequest::class, 'request_id', 'id');
    }

    public function statusHistories()
    {
        return $this->hasMany(RequestStatusHistory::class, 'request_id');
    }

    // Relationship with Tickets
    public function ticket()
    {
        return $this->hasOne(Tickets::class, 'request_id', 'id');
    }

    // Relationship with Stations
    public function stations()
    {
        return $this->belongsToMany(Station::class, 'service_request_station', 'service_request_id', 'station_id')
            ->withTimestamps();
    }

    // All request statuses
    public function statuses()
    {
        return $this->hasMany(RequestStatus::class, 'request_id');
    }

    // Latest request status
    public function latestStatus()
    {
        return $this->hasOne(RequestStatus::class, 'request_id')->latestOfMany();
    }

    // Add relationship to technician
    public function assignedTechnician()
    {
        return $this->belongsTo(User::class, 'technician_id', 'id');
    }

    // Add this relationship method
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id', 'philrice_id');
    }

    /**
     * Get the request status record associated with the request.
     */
    public function requestStatus()
    {
        return $this->hasOne('App\Models\RequestStatus', 'request_id', 'id')
            ->latest();
    }

    // ========== SCOPES BASED ON LATEST STATUS ==========

    // Get requests currently marked as Pending
    public function scopePending($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'PND');
        });
    }

    // Get requests that are Picked
    public function scopePicked($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'PCK');
        });
    }

    // Get requests that are Ongoing
    public function scopeOngoing($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'ONG');
        });
    }

    // Get requests that are Completed
    public function scopeCompleted($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'CPT');
        });
    }

    // Optional: Scope for Denied
    public function scopeDenied($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'DND');
        });
    }

    // Optional: Scope for Canceled
    public function scopeCanceled($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'CCL');
        });
    }

    public function scopePaused($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'PSD'); // Paused
        });
    }

    public function scopeEvaluated($query)
    {
        return $query->whereHas('latestStatus.status', function ($q) {
            $q->where('status_abbr', 'EVL'); // Paused
        });
    }

    // Combine all statuses into one scope
    public function getIsOthersAttribute()
    {
        $abbr = optional($this->latestStatus->status)->status_abbr;
        return in_array($abbr, ['EVL', 'DND', 'CCL']) ? 1 : 0;
    }



    public function getStatusLabelAttribute()
    {
        $abbr = optional($this->latestStatus->status)->status_abbr;

        return match ($abbr) {
            'CPT' => 'Completed',
            'EVL' => 'Evaluated',
            'DND' => 'Denied',
            'CCL' => 'Cancelled',
            default => 'Unknown',
        };
    }


    // ========== OPTIONAL: ACCESSOR ==========

    public function getCurrentStatusNameAttribute()
    {
        return $this->latestStatus?->status?->status_name ?? 'Unknown';
    }

    public function getCurrentStatusAbbrAttribute()
    {
        return $this->latestStatus?->status?->status_abbr ?? 'N/A';
    }

    public function statusHistory()
    {
        return $this->hasMany(\App\Models\RequestStatusHistory::class, 'request_id');
    }

    // In your RequestStatusHistory model

}
