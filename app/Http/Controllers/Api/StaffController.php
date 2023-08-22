<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Services\StaffService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    private $staff;

    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }

    public function index()
    {
        $data = $this->staff->listPaginate();

        return response()->json($data, 200);
    }

    public function store(StaffStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->staff->store($request);
            DB::commit();

            return response()->json('Insert Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->staff->get($id);

        return response()->json($data, 200);
    }

    public function update(StaffUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->staff->update($request, $id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->staff->delete($id);
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
            return $this->staff->exportCsv();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function all()
    {
        $data = $this->staff->list();

        return response()->json($data, 200);
    }
}
