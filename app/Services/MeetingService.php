<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\Notification;
use App\Models\User;

class MeetingService
{
    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'building_id', 'title', 'date', 'description'];
    }

    public function listPaginate($request)
    {
        $query = Meeting::query()
            ->with('building:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->select($this->selectColumns);

        return $query->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->validated();

        $meeting = Meeting::create($data);
        $this->notificaionStore($meeting);

        return $meeting;
    }

    private function notificaionStore($meeting)
    {
        $now = now();

        $users = User::join('tenants', 'users.tenant_id', '=', 'tenants.id')
            ->where('tenants.building_id', $meeting->building_id)
            ->select('users.id')
            ->get();
        $notificationData = $users->map(function ($user) use ($meeting, $now) {
            return [
                'user_id' => $user->id,
                'target_id' => $meeting->id,
                'notification_type' => 'Meeting',
                'details' => 'Request for new meeting',
                'is_read' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->toArray();

        Notification::insert($notificationData);
    }

    public function get($id)
    {
        return Meeting::with('building:id,name')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $update = Meeting::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Meeting::findOrFail($id);
        $data->delete();
    }
}
