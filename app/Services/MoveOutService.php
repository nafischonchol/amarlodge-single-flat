<?php

namespace App\Services;

use App\Models\Flat;
use App\Models\MoveOutHistory;
use App\Models\MoveOutRequest;
use App\Models\Tenant;

class MoveOutService
{
    public function requestPaginate($request)
    {
        $listQuery = MoveOutRequest::query()
            ->with('flat:id,name')
            ->with('tenant:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc');

        if (auth()->user()->hasRole('Tenant')) {
            $listQuery->where('tenant_id', auth()->user()->tenant_id);
        }

        return $listQuery->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        if (! auth()->user()->hasRole('Tenant')) {
            throw new \Exception('You are not tenant!');
        }
        $data = $request->validated();
        $tenant = auth()->user()->tenant;

        $data['tenant_id'] = $tenant->id;
        $data['flat_id'] = $tenant->flat_id;

        return MoveOutRequest::create($data);
    }

    public function updateStatus($request, $id)
    {
        $data['status'] = $request->input('status');
        if (is_null($data) || empty($data['status'])) {
            throw new \Exception("Staus can't be null");
        }
        $moveOut = MoveOutRequest::findOrFail($id);
        $moveOut->update($data);

        if ($data['status'] == 1) {
            $flat = Flat::where('id', $moveOut->flat_id)->update(['move_out_date' => $moveOut->move_out_date]);
        }

        return $moveOut;
    }

    public function tenantMoveOut($tenant_id)
    {
        $tenant = Tenant::findOrFail($tenant_id);
        $flat = Flat::findOrFail($tenant->flat_id);
        $flat->update(['booked' => 0]);

        MoveOutHistory::create([

            'flat_id' => $tenant->flat_id,
            'tenant_id' => $tenant_id,
            'rent_month' => $tenant->rent_month,
            'move_out_date' => date('Y-m-d'),
            'status' => 1,
        ]);

        $tenant->update(['flat_id' => null, 'building_id' => null, 'status' => 0]);
    }

    public function moveOutList($request)
    {
        $listQuery = MoveOutHistory::query()
            ->with('flat:id,name')
            ->with('tenant:id,name,mobile,image')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc');

        return $listQuery->paginate($request->get('per_page', 10));
    }
}
