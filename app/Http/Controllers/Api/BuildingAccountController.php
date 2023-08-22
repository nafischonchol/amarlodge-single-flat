<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Requests\WithdrawHistoryRequest;
use App\Http\Requests\WithdrawStoreRequest;
use App\Services\BuildingAccountService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuildingAccountController extends Controller
{
    private $accountService;

    public function __construct(BuildingAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function summary()
    {
        $data = $this->accountService->summary();

        return response()->json($data, 200);
    }

    public function getAllPaymentsByTenant()
    {
        $data = $this->accountService->tenantPayments();

        return response()->json($data, 200);
    }

    public function updatePaymentStatus(PaymentUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->accountService->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function paymentDetails($payment_id)
    {
        $data = $this->accountService->paymentDetails($payment_id);

        return response()->json($data, 200);
    }

    public function bankTypeWiseCurrentBalance($bank_type)
    {
        $data = $this->accountService->bankTypeWiseCurrentBalance($bank_type);

        return response()->json($data, 200);
    }

    public function withdraw(WithdrawStoreRequest $request)
    {
        try {
            $this->accountService->withdraw($request);

            return response()->json('Successfully withdraw done!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 400);
        }
    }

    public function withdrawHistory(WithdrawHistoryRequest $request)
    {
        try {
            $data = $this->accountService->withdrawHistory($request);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 400);
        }
    }
}
