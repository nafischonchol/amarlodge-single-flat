<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantStoreRequest;
use App\Http\Requests\TenantUpdateRequest;
use App\Services\TenantService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    private $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index(Request $request)
    {
        $data = $this->tenantService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(TenantStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->tenantService->store($request);
            DB::commit();

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->tenantService->get($id);

        return response()->json($data, 200);
    }

    public function update(TenantUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = $this->tenantService->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!', 201);
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->tenantService->delete($id);
            DB::commit();

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }

    public function exportCsv()
    {
        try {
            return $this->tenantService->exportCsv();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
