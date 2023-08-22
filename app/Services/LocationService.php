<?php

namespace App\Services;

use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Upozila;

class LocationService
{
    public function country()
    {
        return Country::all();
    }

    public function countryWiseDivision($country_id)
    {
        return Division::where('country_id', $country_id)->get();
    }

    public function divisionWiseDistrict($division_id)
    {
        return District::where('division_id', $division_id)->get();
    }

    public function districtWiseUpozila($district_id)
    {
        return Upozila::where('district_id', $district_id)->get();
    }
}
