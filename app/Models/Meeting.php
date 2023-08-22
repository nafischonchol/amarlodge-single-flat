<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'title',
        'date',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%'.$search.'%')
            ->orWhere('description', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
