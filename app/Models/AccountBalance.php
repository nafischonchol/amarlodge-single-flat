<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountBalance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_type',
        'amount',
        'transaction_type',
        'note',
        'doc_number',
        'doc_type',
    ];
}
