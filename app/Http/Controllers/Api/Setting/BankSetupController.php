<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankSetupStoreRequest;
use App\Http\Requests\BankSetupUpdateRequest;
use App\Services\BankSetupSerivce;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BankSetupController extends Controller
{
    private $bankService;

    public function __construct(BankSetupSerivce $bankService)
    {
        $this->bankService = $bankService;
    }

    public function index()
    {
        $data = $this->bankService->listPaginate();

        return response()->json($data, 200);
    }

    public function store(BankSetupStoreRequest $request)
    {
        try {
            $this->bankService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json('Query error!', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function show(string $id)
    {
        $data = $this->bankService->get($id);

        return response()->json($data, 200);
    }

    public function update(BankSetupUpdateRequest $request, string $id)
    {
        try {
            $this->bankService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json('Query error!', 404);
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
            $this->bankService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }

    public function all()
    {
        $data = $this->bankService->list();

        return response()->json($data, 200);
    }
}
