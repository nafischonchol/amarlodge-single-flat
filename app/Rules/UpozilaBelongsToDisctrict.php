<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpozilaBelongsToDisctrict implements Rule
{
    protected $district_id;

    public function __construct($district_id)
    {
        $this->district_id = $district_id;
    }

    public function passes($attribute, $value)
    {
        return DB::table('upozilas')
            ->where('id', $value)
            ->where('district_id', $this->district_id)
            ->exists();
    }

    public function message()
    {
        return 'The selected upozila does not exist in the specified district.';
    }
}
