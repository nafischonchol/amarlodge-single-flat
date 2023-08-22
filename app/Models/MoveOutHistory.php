<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveOutHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'flat_id',
        'tenant_id',
        'rent_month',
        'move_out_date',
        'status',
    ];

    protected $dates = [
        'rent_month',
        'move_out_date',
        'deleted_at',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->orWhereHas('flat', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        })
            ->orWhereHas('tenant', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
                $query->orWhere('mobile', 'LIKE', '%'.$search.'%');
            });
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
