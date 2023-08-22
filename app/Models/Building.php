<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'contact_name',
        'contact_number',
        'floor',
        'lift',
        'country_id',
        'division_id',
        'district_id',
        'upozila_id',
        'street',
        'post_code',
        'house_number',
        'details_info',
        'image',
        'images',
        'created_by',
        'updated_by',
    ];

    public function buildingStaffRelations()
    {
        return $this->hasMany(BuildingStaffRelation::class, 'building_id');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'building_staff_relations');
    }

    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
