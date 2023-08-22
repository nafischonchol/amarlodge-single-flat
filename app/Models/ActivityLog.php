<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'model_id',
        'model_name',
        'activity_type',
        'activity',
        'extra_info',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('activity', 'LIKE', '%'.$search.'%')
            ->orWhere('activity_type', 'LIKE', '%'.$search.'%')
            ->orWhere('extra_info', 'LIKE', '%'.$search.'%')
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
