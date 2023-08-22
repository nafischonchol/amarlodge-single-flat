<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DueAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flat_id',
        'amount',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
}
