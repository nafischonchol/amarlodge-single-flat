<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankSetup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bank_name',
        'bank_type',
        'created_by',
        'updated_by',
    ];
}
