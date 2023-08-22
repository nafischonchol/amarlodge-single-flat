<?php

namespace App\Services;

use App\Models\Complain;

class ComplainService
{
    public function listPaginate($request)
    {
        $selectColumns = ['id', 'title', 'date', 'complaint_by', 'complaint_against', 'status', 'details', 'created_at', 'building_id'];

        $query = Complain::query()
            ->with([
                'building' => function ($query) {
                    $query->select('id', 'name');
                },
                'complainAgainstInfo' => function ($query) {
                    $query->select('id', 'name');
                },
                'complainer' => function ($query) {
                    $query->select('id', 'name');
                },
            ])
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($selectColumns);

        if (auth()->user()->hasRole('Tenant')) {
            $tenant = auth()->user()->tenant;

            $query->where(function ($query) use ($tenant) {
                $query->where('complaint_by', $tenant->flat_id)
                    ->orWhere('complaint_against', $tenant->flat_id)
                    ->orWhere('complaint_against', 'All');
            });
        }

        return $query->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        if (auth()->user()->hasRole('Tenant')) {
            $tenant = auth()->user()->tenant;
            $data['complaint_by'] = $tenant->flat_id;
        }

        return Complain::create($data);
    }

    public function get($id)
    {
        $selectColumns = ['id', 'title', 'date', 'complaint_by', 'complaint_against', 'status', 'details', 'created_at', 'building_id'];

        return Complain::with('building:id,name')
            ->where('id', $id)
            ->select($selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $update = Complain::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Complain::findOrFail($id);
        $data->delete();
    }
}
