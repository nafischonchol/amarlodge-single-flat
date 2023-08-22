<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayBillStoreRequest;
use App\Services\BillService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function index()
    {

        try {
            $data = $this->billService->list();

            return response()->json($data, 200);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Tenant id not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage());
        }
    }

    public function payBill(PayBillStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->billService->paymentStore($request);
            DB::commit();

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        } finally {
            DB::rollback();
        }
    }

    public function payBillHistory()
    {
        $data = $this->billService->flatPayBillHistory();

        return response()->json($data, 200);
    }

    public function PayBillHistoryDetails($payment_id)
    {
        $data = $this->billService->payBillHistoryDetails($payment_id);

        return response()->json($data, 200);
    }
}
