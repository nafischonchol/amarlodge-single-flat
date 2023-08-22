<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeStoreRequest;
use App\Http\Requests\NoticeUpdateRequest;
use App\Services\NoticeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    private $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    public function index()
    {
        $data = $this->noticeService->listPaginate();

        return response()->json($data, 200);
    }

    public function store(NoticeStoreRequest $request)
    {
        try {
            $this->noticeService->store($request);

            return response()->json('Insert Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $data = $this->noticeService->get($id);

        return response()->json($data, 200);
    }

    public function update(NoticeUpdateRequest $request, string $id)
    {
        try {
            $this->noticeService->update($request, $id);

            return response()->json('Update Successfully!');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->noticeService->delete($id);

            return response()->json('Deleted success');
        } catch (ModelNotFoundException $e) {
            return response()->json('Data not found', 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json('An error occurred while deleting the data');
        }
    }
}
