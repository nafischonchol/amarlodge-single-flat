<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceCost extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'title',
        'date',
        'amount',
        'details',
        'image',
        'payment_method',
        'recevier_number',
        'transection_id',
        'from_account',
        'to_account',
        'bill_payer',
        'checked_flats',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%'.$search.'%')
            ->orWhere('details', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
