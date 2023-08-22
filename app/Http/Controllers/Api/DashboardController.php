<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function summary()
    {
        $data = $this->dashboardService->summary();

        return response()->json($data, 200);
    }

    public function monthlyRentData()
    {
        $data = $this->dashboardService->monthlyRentDataForChart();

        return response()->json($data, 200);
    }
}
