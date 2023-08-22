<?php

namespace App\Services;

use App\Models\UtilitySetup;

class UtilitySetupService
{
    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'water_bill', 'gas_bill', 'security_bill', 'garbage_bill', 'service_charge', 'created_at', 'building_id'];
    }

    public function listPaginate()
    {

        return UtilitySetup::with('building:id,name')

            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns)
            ->paginate(10);
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $exist = UtilitySetup::where('building_id', $data['building_id'])->first();
        if ($exist) {
            return $exist->update($data);
        }

        return UtilitySetup::create($data);
    }

    public function get($id)
    {
        return UtilitySetup::with('building:id,name')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $update = UtilitySetup::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = UtilitySetup::findOrFail($id);
        $data->delete();
    }

    public function buildingWise($building_id)
    {
        return UtilitySetup::with('building:id,name')
            ->where('building_id', $building_id)
            ->select($this->selectColumns)
            ->first();
    }
}
