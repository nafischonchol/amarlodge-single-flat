<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'building_id',
        'floor',
        'name',
        'area',
        'parking_area',
        'room',
        'washroom',
        'balcony',
        'utilities',
        'booked',
        'move_out_date',
        'rented_to_bachelors',
        'minimumStay',
        'flat_for',
        'rental',
        'notes',
        'termsAndCondition',
        'image',
        'images',
        'youtube_video',
        'created_by',
        'updated_by',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class)->select(['id', 'name', 'flat_id']);
    }
}
