<?php

namespace App\Services;

use App\Models\TenantFamilyMember;
use App\Models\TenantInformation;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class TenantInformationService
{
    use ImageUpload;
    use ExportTrait;

    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['*'];
    }

    public function listPaginate($request)
    {

        $query = TenantInformation::query()
            ->with('building:id,name')
            ->with('flat:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns);
        if (auth()->user()->hasRole('Tenant')) {
            $tenant_id = auth()->user()->tenant_id;

            $query->where(function ($query) use ($tenant_id) {
                $query->where('tenant_id', $tenant_id);
            });
        }

        return $query->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $tenant_id = auth()->user()->tenant_id;
        if ($tenant_id == null) {
            throw new ModelNotFoundException('You are not tenant');
        }
        $tenant = auth()->user()->tenant;

        $data = $request->validated();
        $data['building_id'] = $tenant->building_id;
        $data['flat_id'] = $tenant->flat_id;
        $data['tenant_id'] = $tenant_id;

        $image = $request->image;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/tenant-information/');
        }
        $tenant_info = TenantInformation::create($data);
        $this->family_members_insert($data['family_members'], $tenant_info->id);

        return $tenant_info;
    }

    private function family_members_insert($data, $tenant_info_id)
    {
        $familyData['tenant_information_id'] = $tenant_info_id;
        foreach ($data as $item) {
            $familyData['member_name'] = $item['member_name'];
            $familyData['member_age'] = $item['member_age'];
            $familyData['member_profession'] = $item['member_profession'];
            $familyData['member_mobile'] = $item['member_mobile'];
            TenantFamilyMember::create($familyData);
        }

        return true;
    }

    public function get($id)
    {
        return TenantInformation::with('familyMembers')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $update = TenantInformation::findOrFail($id);
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $image = $request->image;
        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->uploadImage($image, 'images/tenant-information/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        if ($update) {
            $update->update($data);
        }
        $this->family_members_update($data['family_members'], $update);

        return $update;
    }

    private function family_members_update($data, $update)
    {
        if (isset($data)) {
            $updatedFamilyMemberIds = [];
            foreach ($data as $familyMemberData) {
                if (isset($familyMemberData['id'])) {
                    // Update existing family member
                    $familyMember = TenantFamilyMember::find($familyMemberData['id']);
                    if ($familyMember) {
                        $familyMember->update($familyMemberData);
                        $updatedFamilyMemberIds[] = $familyMemberData['id'];
                    }
                } else {
                    // Insert new family member
                    $newFamilyMember = new TenantFamilyMember($familyMemberData);
                    $update->familyMembers()->save($newFamilyMember);
                    $updatedFamilyMemberIds[] = $newFamilyMember->id;
                }
            }
            // Remove family members that are not updated or inserted
            $update->familyMembers()->whereNotIn('id', $updatedFamilyMemberIds)->delete();
        }
    }

    public function delete($id)
    {
        $data = TenantInformation::with('familyMembers')->findOrFail($id);

        if ($data->image) {
            $this->deleteImage($data->image);
        }
        $data->delete();
        $data->familyMembers()->delete();
    }
}
