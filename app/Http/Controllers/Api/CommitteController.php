<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommitteStoreRequest;
use App\Http\Requests\CommitteUpdateRequest;
use App\Services\CommitteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommitteController extends Controller
{
    private $committeService;

    public function __construct(CommitteService $committeService)
    {
        $this->committeService = $committeService;
    }

    public function index(Request $request)
    {
        $data = $this->committeService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(CommitteStoreRequest $request)
    {
        try {
            $this->committeService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->committeService->get($id);

        return response()->json($data, 200);
    }

    public function update(CommitteUpdateRequest $request, string $id)
    {
        try {
            $this->committeService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->committeService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
}
