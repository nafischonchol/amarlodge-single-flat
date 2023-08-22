<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInfoUpdateRequest;
use App\Services\CompanyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function show()
    {
        $data = $this->companyService->get();

        return response()->json($data, 200);
    }

    public function update(CompanyInfoUpdateRequest $request)
    {
        try {
            $this->companyService->update($request);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage());
        }
    }
}
