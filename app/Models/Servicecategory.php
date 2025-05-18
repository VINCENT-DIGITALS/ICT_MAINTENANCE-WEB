<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicecategory extends Model
{
    use HasFactory;

    protected $table = 'lib_categories';
    protected $fillable = ['category_name'];

    // Relationship with ServiceRequest
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
