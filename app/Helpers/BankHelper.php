<?php

namespace App\Helpers;

use App\Models\BankSetup;

class BankHelper
{
    public static function bankType($paymentMethod)
    {
        if ($paymentMethod == 'Cash') {
            return 'Cash';
        }

        $cacheKey = 'bank_type:'.':'.$paymentMethod;
        $cachedValue = cache($cacheKey);

        if ($cachedValue) {
            return $cachedValue;
        }

        $bank = BankSetup::where('bank_name', $paymentMethod)
            ->select('bank_type')
            ->first();

        $bankType = $bank ? $bank->bank_type : 'Unknown';

        cache([$cacheKey => $bankType], 60); // Cache the value for 60 minutes

        return $bankType;
    }
}
