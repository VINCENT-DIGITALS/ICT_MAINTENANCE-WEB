<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProblemEncountered extends Model
{
    use HasFactory;

    protected $table = 'request_problem_encountered';
    
    // Define relationships, if needed
    public function libProblemEncountered()
    {
        return $this->belongsTo(LibProblemEncountered::class, 'encountered_problem_id', 'id');
    }
}
