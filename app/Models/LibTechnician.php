<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibTechnician extends Model
{
    use HasFactory;

    protected $table = 'lib_technicians';

    protected $fillable = ['user_idno']; // Add necessary fields
}
