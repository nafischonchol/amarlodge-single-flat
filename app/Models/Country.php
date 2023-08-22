<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bn_name',
        'code',
        'status',
        'created_at',
        'updated_at',
    ];

    // Define the relationship with the Division model
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
