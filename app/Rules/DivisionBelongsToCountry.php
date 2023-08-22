<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DivisionBelongsToCountry implements Rule
{
    protected $country_id;

    public function __construct($country_id)
    {
        $this->country_id = $country_id;
    }

    public function passes($attribute, $value)
    {
        return DB::table('divisions')
            ->where('id', $value)
            ->where('country_id', $this->country_id)
            ->exists();
    }

    public function message()
    {
        return 'The selected division does not exist in the specified country.';
    }
}
