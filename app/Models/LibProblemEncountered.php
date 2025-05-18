<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibProblemEncountered extends Model
{
    use HasFactory;

    protected $table = 'lib_problems_encountered';

    // Define relationships, if needed
    public function requestProblemEncountered()
    {
        return $this->hasMany(RequestProblemEncountered::class, 'encountered_problem_id', 'id');
    }
    public function statusHistories()
    {
        return $this->hasMany(RequestStatusHistory::class, 'problem_id');
    }
}

