<?php

namespace App\Services;

use App\Models\FlatCost;

class FlatCostService
{
    private $selectColumns = ['*'];

    private $tenant;

    public function __construct()
    {
        $this->selectColumns = ['*'];
        // $this->tenant = auth()->user()->tenant;
    }

    public function listPaginate($request)
    {
        $this->tenant = auth()->user()->tenant;

        return FlatCost::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->where('flat_id', $this->tenant->flat_id)
            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns)
            ->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $this->tenant = auth()->user()->tenant;
        $data = $request->validated();
        $data['building_id'] = $this->tenant->building_id;
        $data['flat_id'] = $this->tenant->flat_id;
        $data['created_by'] = auth()->user()->id;
        $flatCost = FlatCost::create($data);

        return $flatCost;
    }

    public function get($id)
    {
        return FlatCost::where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $update = FlatCost::findOrFail($id);
        $data['updated_by'] = auth()->user()->id;
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = FlatCost::findOrFail($id);
        $data->delete();
    }
}
