<?php

namespace App\Services;

use App\Models\Committe;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class CommitteService
{
    use ImageUpload;

    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'building_id', 'name', 'mobile', 'email', 'present_address', 'permanent_address', 'nid', 'designation', 'status', 'joining_date', 'end_date', 'details_info', 'image'];
    }

    public function listPaginate($request)
    {

        $query = Committe::query()
            ->with('building:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns);

        return $query->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->validated();
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/committe/');
        }

        return Committe::create($data);
    }

    public function get($id)
    {
        return Committe::with('building:id,name')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $update = Committe::findOrFail($id);
        $image = $request->image;
        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->uploadImage($image, 'images/committe/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Committe::findOrFail($id);
        $this->deleteImage($data->image);
        $data->delete();
    }
}
