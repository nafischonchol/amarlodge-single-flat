<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payment_bill_id',
        'bill_id',
        'amount',
    ];

    public function paymentBill()
    {
        return $this->belongsTo(PaymentBill::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
