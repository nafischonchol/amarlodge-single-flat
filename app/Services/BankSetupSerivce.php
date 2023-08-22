<?php

namespace App\Services;

use App\Models\BankSetup;

class BankSetupSerivce
{
    public function list()
    {
        $selectColumns = ['id', 'bank_name', 'bank_type'];

        return BankSetup::orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->get();
    }

    public function listPaginate()
    {
        $selectColumns = ['id', 'bank_name', 'bank_type'];

        return BankSetup::orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->paginate(10);
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;

        return BankSetup::create($data);
    }

    public function get($id)
    {
        $selectColumns = ['id', 'bank_name', 'bank_type'];

        return BankSetup::where('id', $id)
            ->select($selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $update = BankSetup::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = BankSetup::findOrFail($id);
        $data->delete();
    }
}
