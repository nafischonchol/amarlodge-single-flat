<?php

namespace App\Services;

use App\Models\Notice;

class NoticeService
{
    public function listPaginate()
    {
        $selectColumns = ['id', 'title', 'status', 'details', 'created_at', 'building_id'];

        return Notice::query()
            ->with('building:id,name')
            ->orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->paginate(10);
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;

        return Notice::create($data);
    }

    public function get($id)
    {
        $selectColumns = ['id', 'title', 'status', 'details', 'created_at', 'building_id'];

        return Notice::with('building:id,name')
            ->where('id', $id)
            ->select($selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $update = Notice::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Notice::findOrFail($id);
        $data->delete();
    }
}
