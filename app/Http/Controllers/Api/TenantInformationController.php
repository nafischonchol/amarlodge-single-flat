<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantInformationStoreRequest;
use App\Http\Requests\TenantInformationUpdateRequest;
use App\Services\TenantInformationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantInformationController extends Controller
{
    private $tenantInfoService;

    public function __construct(TenantInformationService $tenantInfoService)
    {
        $this->tenantInfoService = $tenantInfoService;
    }

    public function index(Request $request)
    {
        $data = $this->tenantInfoService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(TenantInformationStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->tenantInfoService->store($request);
            DB::commit();

            return response()->json('Insert Successfully!', 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function show(string $id)
    {
        $data = $this->tenantInfoService->get($id);

        return response()->json($data, 200);
    }

    public function update(TenantInformationUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->tenantInfoService->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->tenantInfoService->delete($id);
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
}
