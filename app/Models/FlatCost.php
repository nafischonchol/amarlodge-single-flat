<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlatCost extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'flat_id',
        'date',
        'amount',
        'cause',
        'payment_method',
        'receiver_number',
        'transaction_id',
        'from_account',
        'to_account',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('date', 'LIKE', '%'.$search.'%')
            ->orWhere('cause', 'LIKE', '%'.$search.'%')
            ->orWhere('amount', $search);
    }
}
