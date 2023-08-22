<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveOutRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'flat_id',
        'tenant_id',
        'move_out_date',
        'reason',
        'status',
    ];

    protected $dates = [
        'move_out_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('reason', 'LIKE', '%'.$search.'%')
            ->orWhereHas('flat', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            })
            ->orWhereHas('tenant', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
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
