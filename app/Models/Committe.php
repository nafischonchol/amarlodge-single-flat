<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committe extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'name',
        'mobile',
        'email',
        'present_address',
        'permanent_address',
        'nid',
        'designation',
        'status',
        'joining_date',
        'end_date',
        'details_info',
        'image',
    ];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('nid', 'LIKE', '%'.$search.'%')
            ->orWhere('mobile', 'LIKE', '%'.$search.'%')
            ->orWhere('designation', 'LIKE', '%'.$search.'%')
            ->orWhere('present_address', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
