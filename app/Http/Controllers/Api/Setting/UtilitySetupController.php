<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\UtilitySetupStoreRequest;
use App\Http\Requests\UtilitySetupUpdateRequest;
use App\Services\UtilitySetupService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UtilitySetupController extends Controller
{
    private $utilityService;

    public function __construct(UtilitySetupService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function index()
    {
        $data = $this->utilityService->listPaginate();

        return response()->json($data, 200);
    }

    public function store(UtilitySetupStoreRequest $request)
    {
        try {
            $this->utilityService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {
            return response()->json('Building is not found!', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function show(string $id)
    {
        $data = $this->utilityService->get($id);

        return response()->json($data, 200);
    }

    public function update(UtilitySetupUpdateRequest $request, string $id)
    {
        try {
            $this->utilityService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (QueryException $e) {
            return response()->json('Building is not found!', 404);
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->utilityService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }

    public function buildingWise($building_id)
    {
        $data = $this->utilityService->buildingWise($building_id);

        return response()->json($data, 200);
    }
}
