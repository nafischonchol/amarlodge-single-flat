<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TenantAdvancedMoneyService;

class TenantAdvanedMoneyController extends Controller
{
    private $advancedMoneyService;

    public function __construct(TenantAdvancedMoneyService $advancedMoneyService)
    {
        $this->advancedMoneyService = $advancedMoneyService;
    }

    public function myAdvancedMoney()
    {
        $data = $this->advancedMoneyService->currentMoney();

        return response()->json($data, 200);
    }

    public function history($tenant_id)
    {
        try {
            $data = $this->advancedMoneyService->history($tenant_id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
