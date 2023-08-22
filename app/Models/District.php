<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'division_id',
        'name',
        'bn_name',
        'status',
        'created_at',
        'updated_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    // Define the relationship with the Division model
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
