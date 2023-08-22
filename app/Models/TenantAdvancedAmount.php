<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantAdvancedAmount extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'flat_id',
        'tenant_id',
        'date',
        'amount',
        'transaction_type',
        'status',
        'doc_number',
        'doc_type',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class)->withTrashed();
    }
}
