<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upozila extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'name',
        'bn_name',
        'status',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with the District model
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
