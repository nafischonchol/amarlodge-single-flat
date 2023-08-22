<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FlatAccountService;

class FlatAccountController extends Controller
{
    private $accountService;

    public function __construct(FlatAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $data = $this->accountService->summery();

        return response()->json($data, 200);
    }
}
