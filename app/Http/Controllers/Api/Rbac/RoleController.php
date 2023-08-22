<?php

namespace App\Http\Controllers\Api\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Services\RoleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleService $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        $data = $this->role->listPaginate();

        return response()->json($data, 200);
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->role->store($request);
            DB::commit();

            return response()->json('Insert Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function edit(string $id)
    {
        $data = $this->role->get($id);

        return response()->json($data, 200);
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->role->update($request, $id);
            DB::commit();

            return response()->json('Update Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->role->delete($id);
            DB::commit();

            return response()->json('Deleted success');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the staff');
        }
    }

    public function all()
    {
        $data = $this->role->list();

        return response()->json($data, 200);
    }
}
