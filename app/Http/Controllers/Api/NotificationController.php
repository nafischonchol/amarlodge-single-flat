<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $data = $this->notificationService->listPaginate($request);

        return response()->json($data, 200);
    }

    public function markAsRead()
    {
        $data = $this->notificationService->markAsRead();

        return response()->json('Read successfully', 200);
    }

    public function unread()
    {
        $data['list'] = $this->notificationService->unread();
        $data['total'] = $this->notificationService->totalUnread();

        return response()->json($data, 200);
    }
}
