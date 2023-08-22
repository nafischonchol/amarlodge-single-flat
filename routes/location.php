<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::get('country', [LocationController::class, 'country']);
    Route::get('country-wise-division/{country_id}', [LocationController::class, 'countryWiseDivision']);
    Route::get('division-wise-district/{division_id}', [LocationController::class, 'divisionWiseDistrict']);
    Route::get('district-wise-upozila/{district_id}', [LocationController::class, 'districtWiseUpozila']);
});
