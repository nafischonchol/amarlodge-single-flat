<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplainStoreRequest;
use App\Http\Requests\ComplainUpdateRequest;
use App\Services\ComplainService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComplainController extends Controller
{
    private $complainService;

    public function __construct(ComplainService $complainService)
    {
        $this->complainService = $complainService;
    }

    public function index(Request $request)
    {
        $data = $this->complainService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(ComplainStoreRequest $request)
    {
        try {
            $this->complainService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function show(string $id)
    {
        $data = $this->complainService->get($id);

        return response()->json($data, 200);
    }

    public function update(ComplainUpdateRequest $request, string $id)
    {
        try {
            $this->complainService->update($request, $id);

            return response()->json('Update Successfully!');
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
            $this->complainService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }
}
