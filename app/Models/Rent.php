<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'flat_id',
        'date',
        'rent_amount',
        'water_bill',
        'gas_bill',
        'security_bill',
        'garbage_bill',
        'service_charge',
        'electric_bill',
        'other_bill',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->WhereHas('building', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        })
            ->orWhereHas('flat', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'doc');
    }
}
