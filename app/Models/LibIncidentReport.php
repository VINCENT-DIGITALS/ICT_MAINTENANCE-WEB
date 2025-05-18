<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibIncidentReport extends Model
{
    use HasFactory;

    protected $table = 'lib_incident_reports';

    protected $fillable = [
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
        'affected_areas',
        'findings',
        'resolution'
    ];

    // Relationships
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function findingsRecommendations()
    {
        return $this->hasMany(LibFindingsRecommendation::class, 'incident_report_id');
    }
}
