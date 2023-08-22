<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'title',
        'date',
        'status',
        'type',
        'details',
        'created_by',
        'updated_by',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
