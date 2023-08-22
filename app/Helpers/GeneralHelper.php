<?php

namespace App\Helpers;

use App\Models\TenantAdvancedAmount;

class GeneralHelper
{
    public static function currentAdvancedAmount($tenant_id)
    {
        $amount = TenantAdvancedAmount::where('tenant_id', $tenant_id)
            ->whereIn('status', [1, 2])
            ->selectRaw('COALESCE(SUM(amount * transaction_type), 0) as amount')
            ->first()
            ->amount;

        return $amount;
    }
}
