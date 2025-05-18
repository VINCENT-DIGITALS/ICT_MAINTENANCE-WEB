<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibStatus extends Model
{
    use HasFactory;

    protected $table = 'lib_status';

    protected $fillable = [
        'status_name',
        'status_abbr',
    ];

    /**
     * Get the request statuses for the status.
     */
    public function requestStatuses()
    {
        return $this->hasMany('App\Models\RequestStatus', 'status_id');
    }
}
