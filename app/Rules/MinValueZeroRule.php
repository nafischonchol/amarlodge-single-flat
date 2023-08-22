<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinValueZeroRule implements Rule
{
    public function passes($attribute, $value)
    {
        return $value > 0;
    }

    public function message()
    {
        return 'The :attribute must be greater than 0.';
    }
}
