<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    use ExportTrait, ImageUpload;

    public function list()
    {
        return User::get();
    }

    public function listPaginate($request)
    {
        return User::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->with('roles:id,name')
            ->orderByDesc('created_at')
            ->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        if ($data['role_id']) {
            $this->assignRole($user, $data['role_id']);
        }

        return $user;
    }

    private function assignRole($user, $role_id)
    {
        $user->roles()->detach();
        $role = Role::find($role_id);
        $user->assignRole($role);
        $user->save();
    }

    public function get($id)
    {
        return User::where('id', $id)->first();
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $update = User::findOrFail($id);
        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        if ($data) {
            $data->delete();
        }
    }

    public function exportCsv()
    {
        $data = User::get()
            ->toArray();

        return $this->csv($data, 'users');
    }

    public function info()
    {
        $data = auth()->user();
        $data['role'] = $data->roles->value('name');
        unset($data['roles']); // Remove the roles array

        return $data;
    }

    public function profileUpdate($request)
    {
        $user_id = auth()->user()->id;
        $data = $request->validated();
        $user = User::findOrFail($user_id);
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/users/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        if ($user) {
            $user->update($data);
        }

        return $user;
    }

    public function passwordChange($request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $data = $request->validated();
        $currentPassword = $user->password;
        if (Hash::check($data['old_password'], $currentPassword)) {
            $user->update([
                'password' => Hash::make($data['new_password']),
            ]);

            return true;
        } else {
            throw new \Exception('The old password is incorrect');
        }
    }
}
