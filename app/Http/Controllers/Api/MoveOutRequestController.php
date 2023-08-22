<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoveOutRequestStoreRequest;
use App\Services\MoveOutService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoveOutRequestController extends Controller
{
    private $moveService;

    public function __construct(MoveOutService $moveService)
    {
        $this->moveService = $moveService;
    }

    public function index(Request $request)
    {
        $data = $this->moveService->requestPaginate($request);

        return response()->json($data, 200);
    }

    public function store(MoveOutRequestStoreRequest $request)
    {
        try {
            $this->moveService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {

        try {
            $this->moveService->updateStatus($request, $id);

            return response()->json('Update Status Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function tenantMoveOut($tenant_id)
    {
        try {
            DB::beginTransaction();
            $this->moveService->tenantMoveOut($tenant_id);
            DB::commit();

            return response()->json('Move Out  Successfully!');
        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function moveOutList(Request $request)
    {
        $data = $this->moveService->moveOutList($request);

        return response()->json($data, 200);
    }
}
