<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantInformation extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'building_id',
        'flat_id',
        'tenant_id',
        'name',
        'father_name',
        'dob',
        'marital_status',
        'permanent_address',
        'profession',
        'institute_address',
        'religion',
        'educational_qualification',
        'mobile',
        'email',
        'nid',
        'passport_number',
        'emergency_name',
        'emergency_mobile',
        'emergency_address',
        'emergency_relation',
        'image',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('father_name', 'LIKE', '%'.$search.'%')
            ->orWhere('mobile', 'LIKE', '%'.$search.'%')
            ->orWhere('nid', 'LIKE', '%'.$search.'%')
            ->orWhere('permanent_address', 'LIKE', '%'.$search.'%')
            ->orWhereHas('building', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            })
            ->orWhereHas('flat', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%');
            });
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class)->withTrashed();
    }

    public function familyMembers()
    {
        return $this->hasMany(TenantFamilyMember::class, 'tenant_information_id');
    }
}
