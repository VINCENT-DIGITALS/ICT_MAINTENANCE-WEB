<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'users';

    protected $fillable = ['name', 'philrice_id', 'email'];

    public function libTechnician()
    {
        return $this->hasOne(LibTechnician::class, 'user_idno', 'philrice_id');
    }
}
