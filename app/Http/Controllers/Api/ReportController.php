<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportComplainRequest;
use App\Http\Requests\ReportMaintenanceRequest;
use App\Http\Requests\ReportRentalRequest;
use App\Http\Requests\ReportVisitorRequest;
use App\Services\ReportService;
use Exception;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function rental(ReportRentalRequest $request)
    {
        try {
            $data = $this->reportService->rentalReport($request);

            return \response()->json($data, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function maintenance(ReportMaintenanceRequest $request)
    {
        try {
            $data = $this->reportService->mcReport($request);

            return \response()->json($data, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function visitor(ReportVisitorRequest $request)
    {
        try {
            $data = $this->reportService->visitorReport($request);

            return \response()->json($data, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function complain(ReportComplainRequest $request)
    {
        try {
            $data = $this->reportService->complainReport($request);

            return \response()->json($data, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
}
