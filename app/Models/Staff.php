<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'salary',
        'address',
        'type',
        'nid',
        'nid_image',
        'details_info',
        'created_by',
        'updated_by',
    ];

    public function buildingStaffRelations()
    {
        return $this->hasMany(BuildingStaffRelation::class, 'staff_id');
    }
}
