<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibRole extends Model
{
    use HasFactory;

    protected $table = 'lib_roles';

    protected $fillable = [
        'role_name',
        'description'
    ];

    /**
     * Get users with this role.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
