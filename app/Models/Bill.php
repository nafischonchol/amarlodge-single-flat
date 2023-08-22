<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'flat_id',
        'date',
        'title',
        'type',
        'amount',
        'doc',
        'paid_status',
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
        return $this->hasOne(PaymentDetails::class, 'bill_id');
    }

    public function paymentBill()
    {
        return $this->hasOneThrough(
            PaymentBill::class,
            PaymentDetails::class,
            'bill_id', // Foreign key on the PaymentDetails table
            'id', // Local key on the PaymentBill table
            'id', // Local key on the Bill table
            'payment_bill_id' // Foreign key on the PaymentBill table
        );
    }
}
