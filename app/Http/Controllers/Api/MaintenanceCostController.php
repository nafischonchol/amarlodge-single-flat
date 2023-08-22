<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceCostStoreRequest;
use App\Http\Requests\MaintenanceCostUpdateRequest;
use App\Services\MaintenanceCostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaintenanceCostController extends Controller
{
    private $costService;

    public function __construct(MaintenanceCostService $costService)
    {
        $this->costService = $costService;
    }

    public function index(Request $request)
    {
        $data = $this->costService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(MaintenanceCostStoreRequest $request)
    {
        try {
            $this->costService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->costService->get($id);
        $data['isPaid'] = $this->costService->isAlreadyPaid($id);

        return response()->json($data, 200);
    }

    public function update(MaintenanceCostUpdateRequest $request, string $id)
    {
        try {
            $this->costService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
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

            return response()->json($e->getMessage(), 500);
        }
    }
}
