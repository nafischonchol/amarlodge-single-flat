<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class FlatBelongsToBuilding implements Rule
{
    protected $buildingId;

    public function __construct($buildingId)
    {
        $this->buildingId = $buildingId;
    }

    public function passes($attribute, $value)
    {
        return DB::table('flats')
            ->where('id', $value)
            ->where('building_id', $this->buildingId)
            ->exists();
    }

    public function message()
    {
        return 'The selected flat does not exist in the specified building.';
    }
}
