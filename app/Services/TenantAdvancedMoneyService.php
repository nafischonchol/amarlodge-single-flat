<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Models\TenantAdvancedAmount;

class TenantAdvancedMoneyService
{
    public function currentMoney()
    {
        $tenant_id = auth()->user()->tenant_id;
        $amount = GeneralHelper::currentAdvancedAmount($tenant_id);

        return $amount;
    }

    public function history($tenant_id)
    {
        return TenantAdvancedAmount::where('tenant_id', $tenant_id)
            ->get();
    }
}
