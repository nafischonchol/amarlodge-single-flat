<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingStaffRelation extends Model
{
    use HasFactory;

    protected $table = 'building_staff_relations';

    public $timestamps = true;

    protected $fillable = [
        'building_id',
        'staff_id',
    ];

    // Define the relationship with the Building model
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Define the relationship with the Staff model
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
