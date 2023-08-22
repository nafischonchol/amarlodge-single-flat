<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentStoreRequest;
use App\Http\Requests\RentUpdateRequest;
use App\Services\RentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{
    private $rentService;

    public function __construct(RentService $rentService)
    {
        $this->rentService = $rentService;
    }

    public function index(Request $request)
    {
        $data = $this->rentService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(RentStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->rentService->store($request);
            });

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json('Building is not found!', 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->rentService->get($id);

        return response()->json($data, 200);
    }

    public function update(RentUpdateRequest $request, string $id)
    {
        try {
            $this->rentService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 404);
        }
    }

    public function invoiceInfo(string $rent_id)
    {
        try {
            $data = $this->rentService->invoiceInfo($rent_id);

            return response()->json($data, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while fatching the data');
        }
    }
}
