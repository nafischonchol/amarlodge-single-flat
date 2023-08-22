<?php

namespace App\Services;

use App\Models\Building;
use App\Models\BuildingStaffRelation;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class BuildingService
{
    use ImageUpload;
    use ExportTrait;

    private $selectColumns = ['*'];

    public function __construct()
    {
        $this->selectColumns = ['id', 'name', 'contact_name', 'contact_number', 'floor', 'lift', 'country_id', 'division_id', 'district_id', 'upozila_id', 'street', 'post_code', 'house_number', 'details_info', 'image', 'images'];
    }

    public function list()
    {
        return Building::orderBy('created_at', 'desc')->select($this->selectColumns)->get();
    }

    public function listPaginate()
    {
        $paginator = Building::query()
            ->withCount(['flats as booked_flats' => function ($query) {
                $query->where('booked', 1);
            }])
            ->withCount(['flats as available_flats' => function ($query) {
                $query->where('booked', 0);
            }])
            ->orderByDesc('created_at')
            ->paginate(10);

        $result = $paginator->getCollection()->map(function ($item) {

            return [
                'id' => $item->id,
                'name' => $item->name,
                'contact_name' => $item->contact_name,
                'contact_number' => $item->contact_number,
                'floor' => $item->floor,
                'lift' => $item->lift,
                'street' => $item->street,
                'post_code' => $item->post_code,
                'house_number' => $item->house_number,
                'details_info' => $item->details_info,
                'booked_flats' => $item->booked_flats,
                'available_flats' => $item->available_flats,
                'image' => $item->image,
                'images' => $item->images,
            ];
        });

        $pagination = $paginator->toArray();
        $pagination['data'] = $result;

        return $pagination;
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $image = $request->image;
        $images = $request->images;
        $multiple = null;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/building/');
        }
        if ($images) {
            $multiple = $this->uploadImageMultiple($images, 'images/building/');
        }
        $data['images'] = \json_encode($multiple);

        $building = Building::create($data);
        if (isset($data['staff_id'][0]) && $building) {
            $buildingStaff['building_id'] = $building->id;
            foreach ($data['staff_id'] as $item) {
                $buildingStaff['staff_id'] = $item;
                BuildingStaffRelation::create($buildingStaff);
            }
        }

        return $building;
    }

    public function get($id)
    {
        $building = Building::with('buildingStaffRelations.staff')
            ->select($this->selectColumns)
            ->find($id);

        if (isset($building->buildingStaffRelations)) {
            $staff = $building->buildingStaffRelations->map(function ($relation) {
                return [
                    'id' => $relation->staff->id,
                    'name' => $relation->staff->name,
                ];
            });
            unset($building->buildingStaffRelations);

            return $building->setAttribute('staff', $staff);
        }

        return $building;
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $data['updated_by'] = auth()->user()->id;

        $building = Building::findOrFail($id);
        $oldImagesName = json_decode($building->images);

        $image = $request->image;
        $images = $request->images;
        if ($image) {
            $this->deleteImage($building->image);
            $data['image'] = $this->uploadImage($image, 'images/building/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        if ($images) {
            if ($oldImagesName) {
                $this->deleteMultipleImage($oldImagesName);
            }
            $multiple = $this->uploadImageMultiple($images, 'images/building/');
            $data['images'] = json_encode($multiple);
        } elseif (empty($images)) {
            $data['images'] = null;
        } else {
            $data = Arr::except($data, ['images']);
        }

        $existingStaffIds = $building->staff()->pluck('staff_id')->toArray();
        $newStaffIds = $request->input('staff_id');

        // Determine staff IDs to be added and removed
        $staffIdsToAdd = array_diff($newStaffIds, $existingStaffIds);
        $staffIdsToRemove = array_diff($existingStaffIds, $newStaffIds);

        // Remove building-staff relations for staff IDs to be removed
        $building->staff()->detach($staffIdsToRemove);

        // Create new building-staff relations for staff IDs to be added
        $building->staff()->attach($staffIdsToAdd);

        if ($building) {
            $building->update($data);
        }

        return $building;
    }

    public function delete($id)
    {
        $delete = Building::findOrFail($id);
        $delete->delete();
    }

    public function exportCsv()
    {
        $data = Building::select('name', 'contact_name', 'contact_number', 'floor', 'lift', 'full_address', 'details_info')->get()->toArray();

        return $this->csv($data, 'building');
    }
}
