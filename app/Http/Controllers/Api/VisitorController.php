<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorCreateRequest;
use App\Http\Requests\VisitorUpdateRequest;
use App\Services\VisitorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VisitorController extends Controller
{
    private $visitor;

    public function __construct(VisitorService $visitor)
    {
        $this->visitor = $visitor;
    }

    public function index(Request $request)
    {
        $data = $this->visitor->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(VisitorCreateRequest $request)
    {
        Log::info($request->input());
        try {
            $this->visitor->store($request);

            return response()->json('Insert Successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        try {
            $data = $this->visitor->get($id);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(VisitorUpdateRequest $request, $id)
    {
        try {
            $this->visitor->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->visitor->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }

    public function exportCsv()
    {
        try {
            return $this->visitor->exportCsv();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
