<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\Notification;

class NotificationService
{
    public function listPaginate($request)
    {
        $selectColumns = ['id', 'title', 'date', 'description'];
        $query = Meeting::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->select($selectColumns);

        return $query->paginate($request->get('per_page', 10));
    }

    public function unread()
    {
        return Notification::orderBy('created_at', 'desc')
            ->where('user_id', auth()->user()->id)
            ->where('is_read', 0)
            ->get();
    }

    public function totalUnread()
    {
        return Notification::where('user_id', auth()->user()->id)->where('is_read', 0)->count();
    }

    public function markAsRead()
    {
        Notification::where('user_id', auth()->user()->id)->update(['is_read' => 1]);
    }
}
