<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'lib_actions_taken';

    protected $fillable = [
        'action_name',
        'action_abbr',
        'is_archived',
        'category_id'
    ];

    /**
     * Get the category that owns the action.
     */
    public function category()
    {
        return $this->belongsTo(Servicecategory::class, 'category_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(RequestStatusHistory::class, 'action_id');
    }
}
