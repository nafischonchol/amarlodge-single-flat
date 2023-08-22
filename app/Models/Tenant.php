<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'building_id',
        'flat_id',
        'name',
        'mobile',
        'email',
        'address',
        'nid',
        'member',
        'advanced_amount',
        'rent_per_month',
        'issue_date',
        'rent_month',
        'image',
        'additional_notes',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('mobile', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
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
        return $this->belongsTo(Flat::class)->withTrashed();
    }
}
