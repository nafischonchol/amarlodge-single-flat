<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilitySetup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'building_id',
        'water_bill',
        'gas_bill',
        'security_bill',
        'garbage_bill',
        'service_charge',
        'created_by',
        'updated_by',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
