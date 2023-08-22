<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'title',
        'complaint_by',
        'complaint_against',
        'details',
        'date',
        'status',
        'created_by',
        'updated_by',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%'.$search.'%')
            ->orWhere('details', 'LIKE', '%'.$search.'%')
            ->orWhere('complaint_by', 'LIKE', '%'.$search.'%')
            ->orWhere('complaint_against', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function complainAgainstInfo()
    {
        return $this->belongsTo(Flat::class, 'complaint_against', 'id');
    }

    public function complainer()
    {
        return $this->belongsTo(Flat::class, 'complaint_by', 'id');
    }
}
