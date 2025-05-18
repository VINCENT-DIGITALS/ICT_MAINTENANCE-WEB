<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibApprover extends Model
{
    use HasFactory;

    protected $table = 'lib_approvers';

    protected $fillable = [
        'name',
        'position',
        'email',
        'is_active'
    ];
}
