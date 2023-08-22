<?php

namespace App\Services;

use App\Models\AccountBalance;
use App\Models\Flat;
use App\Models\Tenant;
use App\Models\TenantAdvancedAmount;
use App\Models\User;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class TenantService
{
    use ImageUpload;
    use ExportTrait;

    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'name', 'mobile', 'email', 'address', 'nid', 'member', 'advanced_amount', 'rent_per_month', 'issue_date', 'rent_month', 'image', 'additional_notes', 'status', 'building_id', 'flat_id'];
    }

    public function listPaginate($request)
    {
        return Tenant::query()
            ->with('building:id,name')
            ->with('flat:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderByDesc('created_at')
            ->select($this->selectColumns)
            ->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        if ($data['flat_id'] != null) {
            $flat = Flat::findOrFail($data['flat_id']);
            $this->checkFlatAvailability($data);
            $data['rent_per_month'] = $flat->rental;
            $data['building_id'] = $flat->building_id;
        }
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/tenant/');
        }
        $tenant = Tenant::create($data);
        $this->advancedMoney($tenant);
        $this->manageUser($data, $tenant->id);

        return $tenant;
    }

    private function advancedMoney($data)
    {
        $advancedData['flat_id'] = $data['flat_id'];
        $advancedData['tenant_id'] = $data['id'];
        $advancedData['date'] = date('Y-m-d');
        $advancedData['amount'] = $data['advanced_amount'];
        $advancedData['transaction_type'] = 1;
        $advancedData['doc_type'] = 'Advanced Money';
        $advancedData['doc_number'] = $data->id;

        $tenantAdvanced = TenantAdvancedAmount::create($advancedData);
        $docNumber = $tenantAdvanced->id;
        $accountBalanceData = [
            'transaction_type' => 1,
            'bank_type' => 'Cash',
            'amount' => $data->advanced_amount,
            'doc_type' => 'Advanced Money',
            'doc_number' => $docNumber,
        ];
        AccountBalance::create($accountBalanceData);
    }

    private function manageUser($data, $tenant_id)
    {
        //user create
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            if (! $user->hasRole('Tenant') && $user->getRoleNames()) {
                throw new \Exception("This email can't be tenant!");
            }
            $user_data['tenant_id'] = $tenant_id;
            $user->update($user_data);
            $this->assignTenantRole($user);

            return true;
        }
        $user_data['name'] = $data['name'];
        $user_data['email'] = $data['email'];
        $user_data['tenant_id'] = $tenant_id;
        $user_data['password'] = bcrypt($data['password']);
        $user = User::create($user_data);
        $this->assignTenantRole($user);
    }

    private function assignTenantRole($user)
    {
        $role = Role::where('name', 'Tenant')->where('guard_name', 'web')->first();

        $user->assignRole($role);
    }

    public function get($id)
    {
        return Tenant::with('building:id,name')
            ->with('flat:id,name')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    private function checkFlatAvailability($data, $tenant_id = null)
    {
        $tenantOldFlatId = null;
        if ($tenant_id) {
            $tenant = Tenant::findOrFail($tenant_id);
            $tenantOldFlatId = $tenant->flat_id;
            if ($tenantOldFlatId == $data['flat_id']) {
                Flat::where('id', $tenantOldFlatId)->update(['booked' => 1]);

                return true;
            }
        }

        $newFlat = Flat::find($data['flat_id']);
        if ($newFlat->booked == 1) {
            throw new \Exception('This flat is already booked!');
        }

        $newFlat->update(['booked' => 1]);

        if ($tenantOldFlatId) {
            Flat::where('id', $tenantOldFlatId)->update(['booked' => 0]);
        }
    }

    public function update($request, $id)
    {
        $update = Tenant::findOrFail($id);

        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        if ($data['flat_id'] != null) {
            $flat = Flat::findOrFail($data['flat_id']);
            $this->checkFlatAvailability($data, $id);
            $data['rent_per_month'] = $flat->rental;
            $data['building_id'] = $flat->building_id;
        }
        $image = $request->image;

        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->uploadImage($image, 'images/tenant/');
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
        $data = Tenant::findOrFail($id);
        if ($data['image']) {
            $this->deleteImage($data['image']);
        }
        User::where('tenant_id', $data->id)->delete();
        $flat = Flat::where('id', $data->flat_id)->update(['booked' => 0]);
        $data->update(['flat_id' => null, 'building_id' => null, 'status' => 0]);
        $data->delete();
    }

    public function exportCsv()
    {
        $data = Tenant::leftJoin('buildings', 'tenants.building_id', '=', 'buildings.id')
            ->leftJoin('flats', 'tenants.flat_id', '=', 'flats.id')
            ->select('tenants.name AS tenant_name', 'buildings.name as building_name', 'flats.name as flat_name', 'tenants.mobile', 'tenants.address', 'tenants.nid')
            ->get()
            ->toArray();

        return $this->csv($data, 'tenants');
    }
}
