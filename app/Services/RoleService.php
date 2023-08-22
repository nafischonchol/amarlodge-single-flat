<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function list()
    {
        return Role::get();
    }

    public function listPaginate()
    {
        // $user = User::find(auth()->user()->id);
        // $user->assignRole('Admin');
        $selectColumns = ['id', 'name', 'guard_name'];

        return Role::select($selectColumns)->paginate(10);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['guard_name'] = 'web';

        return Role::create($data);
    }

    public function get($id)
    {
        $selectColumns = ['id', 'name'];

        return Role::where('id', $id)->select($selectColumns)->first();
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $update = Role::find($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Role::findOrFail($id);
        $data->delete();
    }
}
