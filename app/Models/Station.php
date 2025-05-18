<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'lib_station';

    protected $fillable = ['id','station_name', 'station_abbr'];

    public function serviceRequests()
    {
        return $this->belongsToMany(ServiceRequest::class, 'service_request_station', 'station_id', 'service_request_id')
                    ->withTimestamps();
    }
}
