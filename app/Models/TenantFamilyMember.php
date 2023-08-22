<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantFamilyMember extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'tenant_information_id',
        'member_name',
        'member_age',
        'member_profession',
        'member_mobile',
    ];

    public function tenantInformation()
    {
        return $this->belongsTo(TenantInformation::class, 'tenant_information_id');
    }
}
