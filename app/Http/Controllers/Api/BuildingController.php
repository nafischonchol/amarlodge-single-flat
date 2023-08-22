<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingStoreRequest;
use App\Http\Requests\BuildingUpdateRequest;
use App\Services\BuildingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuildingController extends Controller
{
    private $building;

    public function __construct(BuildingService $building)
    {
        $this->building = $building;
    }

    public function index()
    {
        $data = $this->building->listPaginate();

        return response()->json($data, 200);
    }

    public function store(BuildingStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->building->store($request);
            DB::commit();

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {

            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                return response()->json('Staff id not valid!', 404);
            }

            return response()->json($e->getMessage(), 500);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        try {
            $data = $this->building->get($id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(BuildingUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->building->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->building->delete($id);
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
            return $this->building->exportCsv();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function all()
    {
        $data = $this->building->list();

        return response()->json($data, 200);
    }
}
