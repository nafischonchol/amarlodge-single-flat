<?php

namespace App\Services;

use App\Models\Staff;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class StaffService
{
    use ImageUpload;
    use ExportTrait;

    public function list()
    {
        $selectColumns = ['id', 'name', 'mobile', 'email', 'salary', 'type', 'nid', 'address', 'details_info', 'nid_image'];

        return Staff::orderBy('created_at', 'desc')->select($selectColumns)->get();
    }

    public function listPaginate()
    {
        $selectColumns = ['id', 'name', 'mobile', 'email', 'salary', 'type', 'nid', 'address', 'details_info', 'nid_image'];

        return Staff::orderBy('created_at', 'desc')->select($selectColumns)->paginate(10);
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $image = $request->image;
        if ($image) {
            $data['nid_image'] = $this->uploadImage($image, 'images/staff/');
        }

        return Staff::create($data);
    }

    public function get($id)
    {
        $selectColumns = ['id', 'name', 'mobile', 'email', 'salary', 'address', 'type', 'details_info', 'nid', 'nid_image'];

        return Staff::where('id', $id)->select($selectColumns)->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $image = $request->nid_image;

        if ($image) {
            $this->deleteImage($data['old_nid_image']); //delete old image
            $data['nid_image'] = $this->uploadImage($image, 'images/staff/');
        } else {
            $data = Arr::except($data, ['nid_image']);
        }

        $update = Staff::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $staff = Staff::findOrFail($id);
        if ($staff['nid_image']) {
            $this->deleteImage($staff['nid_image']);
        }
        $staff->delete();
    }

    public function exportCsv()
    {
        $data = Staff::select('name', 'mobile', 'email', 'salary', 'address', 'type', 'nid', 'details_info')->get()->toArray();

        return $this->csv($data, 'staffs');
    }
}
