<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibFindingsRecommendation extends Model
{
    use HasFactory;

    protected $table = 'lib_findings_recommendations';

    protected $fillable = [
        'incident_report_id',
        'findings',
        'recommendations'
    ];

    public function incidentReport()
    {
        return $this->belongsTo(LibIncidentReport::class, 'incident_report_id');
    }
}
