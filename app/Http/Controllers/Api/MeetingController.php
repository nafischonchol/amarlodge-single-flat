<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingStoreRequest;
use App\Http\Requests\MeetingUpdateRequest;
use App\Services\MeetingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    private $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function index(Request $request)
    {
        $data = $this->meetingService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function store(MeetingStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->meetingService->store($request);
            DB::commit();

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->meetingService->get($id);

        return response()->json($data, 200);
    }

    public function update(MeetingUpdateRequest $request, string $id)
    {
        try {
            $this->meetingService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            return response()->json('An error occurred');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->meetingService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
