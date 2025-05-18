<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LibProblemEncountered;
use App\Models\Action;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\LibStatus;

class RequestStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'request_status_history';

    protected $fillable = [
        'request_id',
        'status',
        'changed_by',
        'remarks',
        'problem_id',
        'action_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Relationship with ServiceRequest
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }

    // Relationship with LibStatus
    public function status()
    {
        return $this->belongsTo(LibStatus::class, 'status_id');
    }

    // Relationship with Problem
    public function problemEncountered()
    {
        return $this->belongsTo(LibProblemEncountered::class, 'problem_id');
    }

    // Relationship with Action
    public function actionTaken()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    // Relationship with User (who created the status history)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with User (who changed the status)
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Modify the latestForStatus scope to include problem and action relationships
    public static function latestForStatus($requestId, $status)
    {
        return static::with(['problemEncountered', 'actionTaken'])
            ->where('request_id', $requestId)
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    // Add this new method to get completed status details
    public static function getCompletedDetails($requestId)
    {
        $history = self::latestForStatus($requestId, 'completed');
        return [
            'problem_name' => optional($history?->problemEncountered)->encountered_problem_name ?? 'None',
            'action_name' => optional($history?->actionTaken)->action_name ?? 'None',
            'remarks' => $history?->remarks ?? 'None'
        ];
    }

    /**
     * Get the request that owns the status history.
     */
    public function request()
    {
        return $this->belongsTo(ServiceRequest::class, 'request_id');
    }
}
