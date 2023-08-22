<?php

namespace App\Rules;

use App\Models\BankSetup;
use Illuminate\Contracts\Validation\Rule;

class BankTypeValidationRule implements Rule
{
    protected $paymentMethod;

    protected $bankInfo;

    public function __construct($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function passes($attribute, $value)
    {
        if ($this->paymentMethod === 'Cash') {
            return true;
        }

        $this->bankInfo = BankSetup::where('bank_name', $this->paymentMethod)->first();

        if (! $this->bankInfo) {
            return false;
        }

        $bankType = $this->bankInfo->bank_type;

        if ($bankType === 'Traditional Bank' && empty($value) && ($attribute === 'from_account' || $attribute === 'to_account')) {
            return false;
        }

        if ($bankType === 'Mobile Bank' && empty($value) && ($attribute === 'transaction_id' || $attribute === 'receiver_number')) {
            return false;
        }

        return true;
    }

    public function message()
    {
        if (! $this->bankInfo) {
            return 'The bank information for the selected payment method could not be found.';
        }

        return 'The :attribute is required based on the bank type.';
    }
}
