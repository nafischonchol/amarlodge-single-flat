<?php

namespace App\Http\Controllers\Api\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $data = $this->user->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->user->store($request);
            DB::commit();

            return response()->json('Insert Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            $this->user->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->user->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function all()
    {
        $data = $this->user->list();

        return response()->json($data, 200);
    }

    public function userInfo()
    {
        $data = $this->user->info();

        return response()->json($data, 200);
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        try {
            $this->user->profileUpdate($request);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        try {
            $this->user->passwordChange($request);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
}
