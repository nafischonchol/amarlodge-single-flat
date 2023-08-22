<?php

namespace App\Services;

use App\Models\Visitor;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class VisitorService
{
    use ExportTrait, ImageUpload;

    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'building_id', 'flat_id', 'host_information', 'name', 'mobile', 'in_time', 'out_time', 'image', 'purpose', 'additional_notes'];
    }

    public function listPaginate($request)
    {
        return Visitor::query()
            ->with('building:id,name')->with('flat:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderByDesc('created_at')
            ->select($this->selectColumns)
            ->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/visitor/');
        }

        return Visitor::create($data);
    }

    public function get($id)
    {
        return Visitor::where('id', $id)->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $update = Visitor::findOrFail($id);

        $data['updated_by'] = auth()->user()->id;
        $image = $request->image;

        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->uploadImage($image, 'images/visitor/');
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
        $data = Visitor::findOrFail($id);
        if ($data) {
            $data->delete();
        }
    }

    public function exportCsv()
    {
        $data = Visitor::leftJoin('buildings', 'visitors.building_id', '=', 'buildings.id')
            ->leftJoin('flats', 'visitors.flat_id', '=', 'flats.id')
            ->select('buildings.name AS building_name', 'flats.name as flat_name', 'host_information', 'visitors.name as visitor_name', 'mobile', 'in_time', 'out_time', 'purpose')
            ->get()
            ->toArray();

        return $this->csv($data, 'visitors');
    }
}
