<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlatStoreRequest;
use App\Http\Requests\FlatUpdateRequest;
use App\Services\FlatService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlatController extends Controller
{
    private $flat;

    public function __construct(FlatService $flat)
    {
        $this->flat = $flat;
    }

    public function index(Request $request)
    {
        $data = $this->flat->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(FlatStoreRequest $request)
    {
        try {

            DB::beginTransaction();
            $this->flat->store($request);
            DB::commit();

            return response()->json('Insert Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function show(string $id)
    {
        $data = $this->flat->get($id);

        return response()->json($data, 200);
    }

    public function update(FlatUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->flat->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->flat->delete($id);
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
            return $this->flat->exportCsv();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function buildingWiseFlat($building_id)
    {
        $data = $this->flat->buildingWiseList($building_id);

        return response()->json($data, 200);
    }

    public function availableFlat($building_id = null)
    {
        $data = $this->flat->availableFlat($building_id);

        return response()->json($data, 200);
    }

    public function buildingWiseAvailableAndSelect($building_id, $tenant_id)
    {
        $data = $this->flat->buildingWiseAvailableAndSelect($building_id, $tenant_id);

        return response()->json($data, 200);
    }

    public function buildingWiseBooked($building_id)
    {
        $data = $this->flat->buildingWiseBooked($building_id);

        return response()->json($data, 200);
    }

    public function upcomingAvailability($building_id = null)
    {
        $data = $this->flat->upcomingAvailability($building_id);

        return response()->json($data, 200);
    }
}
