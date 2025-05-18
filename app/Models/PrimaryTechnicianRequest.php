<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryTechnicianRequest extends Model
{
    protected $table = 'primarytechnician_request';

    protected $fillable = [
        'technician_emp_id',
        'request_id',
    ];
}
