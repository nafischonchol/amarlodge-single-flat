<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralSettingCurrencyRequest;
use App\Http\Requests\GeneralSettingDefaultImageRequest;
use App\Services\GeneralSettingService;
use Illuminate\Support\Facades\Log;

class GeneralSettingController extends Controller
{
    private $service;

    public function __construct(GeneralSettingService $service)
    {
        $this->service = $service;
    }

    public function generalSettingCurrency()
    {
        $data = $this->service->generalSettingCurrency();

        return response()->json($data, 200);
    }

    public function currencyUpdate(GeneralSettingCurrencyRequest $request)
    {
        try {
            $this->service->updateCurrency($request);

            return response()->json('Update Successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function generalSettingDefaultImage()
    {
        $data = $this->service->generalSettingDefaultImage();

        return response()->json($data, 200);
    }

    public function setDefaultImage(GeneralSettingDefaultImageRequest $request)
    {
        try {
            $this->service->updateDefaultImage($request);

            return response()->json('Set Image Successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
}
