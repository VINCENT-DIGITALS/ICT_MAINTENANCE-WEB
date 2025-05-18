<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibVerifier extends Model
{
    use HasFactory;

    protected $table = 'lib_verifiers';

    protected $fillable = [
        'name',
        'position',
        'email',
        'is_active'
    ];
}
