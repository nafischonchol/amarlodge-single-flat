<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlatCostStoreRequest;
use App\Http\Requests\FlatCostUpdateRequest;
use App\Services\FlatCostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlatCostController extends Controller
{
    private $costService;

    public function __construct(FlatCostService $costService)
    {
        $this->costService = $costService;
    }

    public function index(Request $request)
    {
        $data = $this->costService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(FlatCostStoreRequest $request)
    {
        try {
            $this->costService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->costService->get($id);

        return response()->json($data, 200);
    }

    public function update(FlatCostUpdateRequest $request, string $id)
    {
        try {
            $this->costService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->costService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }
}
