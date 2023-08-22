<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DistrictBelongsToDivision implements Rule
{
    protected $division_id;

    public function __construct($division_id)
    {
        $this->division_id = $division_id;
    }

    public function passes($attribute, $value)
    {
        return DB::table('districts')
            ->where('id', $value)
            ->where('division_id', $this->division_id)
            ->exists();
    }

    public function message()
    {
        return 'The selected districts does not exist in the specified division.';
    }
}
