<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentBill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'flat_id',
        'payment_method',
        'receiver_number',
        'transaction_id',
        'from_account',
        'to_account',
        'total_amount',
        'pay_amount',
        'use_advanced_amount',
        'discount_amount',
        'due_amount',
        'date',
        'status',
        'note',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetails::class, 'payment_bill_id');
    }
}
