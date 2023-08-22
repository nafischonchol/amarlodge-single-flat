<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageStoreRequest;
use App\Http\Requests\LanguageUpdateRequest;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index()
    {
        try {
            $data = $this->languageService->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(LanguageStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->languageService->store($request);
            DB::commit();

            return response()->json('Add Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(LanguageUpdateRequest $request, $id)
    {
        try {
            $this->languageService->update($request);

            return response()->json('Add Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(string $code)
    {
        try {
            $this->languageService->delete($code);

            return response()->json('Deleted success', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function allCodes()
    {
        try {
            $data = $this->languageService->allCodes();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $this->languageService->updateStatus($request);

            return response()->json('Update successful', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateDefaultStatus(Request $request)
    {
        try {
            $this->languageService->updateDefaultStatus($request);

            return response()->json('Set default successful', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function getTranslate($code)
    {
        try {
            $data = $this->languageService->getTranslateData($code);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function translateSubmit(Request $request, $code)
    {
        try {
            $this->languageService->translateSubmit($request, $code);

            return response()->json('Update successfully', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function translate_key_remove(Request $request, $code)
    {
        try {
            $this->languageService->translate_key_remove($request, $code);

            return response()->json('Removed successfully', 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function activeList()
    {
        try {
            $data = $this->languageService->activeList();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }

    public function translations($code)
    {
        try {
            $data = $this->languageService->translations($code);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
}
