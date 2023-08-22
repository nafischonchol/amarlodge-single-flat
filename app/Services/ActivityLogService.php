<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['*'];
    }

    public function listPaginate($request)
    {
        $query = ActivityLog::query()
            ->with('user:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns);

        return $query->paginate($request->get('per_page', 10));
    }
}
