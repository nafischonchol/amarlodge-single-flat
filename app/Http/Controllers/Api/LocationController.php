<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationService;

class LocationController extends Controller
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function country()
    {
        $data = $this->locationService->country();

        return response()->json($data, 200);
    }

    public function countryWiseDivision($country_id)
    {
        $data = $this->locationService->countryWiseDivision($country_id);

        return response()->json($data, 200);
    }

    public function divisionWiseDistrict($division_id)
    {
        $data = $this->locationService->divisionWiseDistrict($division_id);

        return response()->json($data, 200);
    }

    public function districtWiseUpozila($district_id)
    {
        $data = $this->locationService->districtWiseUpozila($district_id);

        return response()->json($data, 200);
    }
}
