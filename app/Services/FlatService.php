<?php

namespace App\Services;

use App\Models\Flat;
use App\Traits\ExportTrait;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FlatService
{
    use ImageUpload;
    use ExportTrait;

    private $selectColumns;

    public function __construct()
    {
        $this->selectColumns = ['id', 'name', 'floor', 'area', 'parking_area', 'room', 'washroom', 'balcony', 'utilities', 'booked', 'move_out_date as next_available_date', 'rental', 'rented_to_bachelors', 'minimumStay', 'notes', 'termsAndCondition', 'image', 'images', 'youtube_video', 'building_id'];
    }

    public function buildingWiseBooked($building_id)
    {
        $flats = Flat::where('flats.building_id', $building_id)
            ->where('booked', '1')
            ->orderBy('flats.name', 'desc')
            ->select($this->selectColumns)
            ->get();

        return $flats;
    }

    public function upcomingAvailability($building_id = null)
    {
        $query = Flat::query()
            ->with('building:id,name')
            ->where('booked', '1')
            ->whereNotNull('move_out_date')
            ->whereDate('move_out_date', '>=', Carbon::today())
            ->orderBy('flats.name', 'desc')
            ->select($this->selectColumns);
        if ($building_id != null) {
            $query->where('flats.building_id', $building_id);
        }
        $flats = $query->get();

        return $flats;
    }

    public function buildingWiseAvailableAndSelect($building_id, $tenant_id)
    {
        $flats = DB::table('flats')
            ->where('building_id', $building_id)
            ->where(function ($query) use ($tenant_id) {
                $query->where('booked', 0)
                    ->orWhereExists(function ($subquery) use ($tenant_id) {
                        $subquery->select(DB::raw(1))
                            ->from('tenants')
                            ->whereRaw('tenants.flat_id = flats.id')
                            ->where('tenants.id', $tenant_id);
                    });
            })
            ->get();

        return $flats;
    }

    public function availableFlat($building_id = null)
    {
        $query = Flat::query()
            ->with('building:id,name')
            ->where('booked', '0')
            ->orderBy('flats.name', 'desc');
        if ($building_id != null) {
            $query->where('flats.building_id', $building_id);
        }
        $flats = $query->get();

        return $flats;
    }

    public function buildingWiseList($building_id)
    {

        return Flat::where('building_id', $building_id)->orderBy('name', 'desc')->select($this->selectColumns)->get();
    }

    public function list()
    {
        return Flat::orderBy('building_id', 'desc')->select($this->selectColumns)->get();
    }

    public function listPaginate($request)
    {
        $flats = Flat::query()
            ->with('building:id,name')
            ->with('tenant')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->select($this->selectColumns)
            ->orderBy('building_id', 'desc')
            ->paginate($request->get('per_page', 10));

        return $flats;
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $image = $request->image;
        $images = $request->images;
        $multiple = null;
        if ($image) {
            $data['image'] = $this->uploadImage($image, 'images/flat/');
        }
        if ($images) {
            $multiple = $this->uploadImageMultiple($images, 'images/flat/');
        }
        $data['images'] = \json_encode($multiple);

        return Flat::create($data);
    }

    public function get($id)
    {
        return Flat::where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $update = Flat::findOrFail($id);
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $image = $request->image;
        $images = $request->images;
        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->uploadImage($image, 'images/flat/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        if ($images) {
            $multiple = $this->uploadImageMultiple($images, 'images/flat/');
            $data['images'] = \json_encode($multiple);
        } elseif (empty($images)) {
            $data['images'] = null;
        } else {
            $data = Arr::except($data, ['images']);
        }

        if ($update) {
            $update->update($data);
        }

        return $update;
    }

    public function delete($id)
    {
        $data = Flat::findOrFail($id);
        if ($data['image']) {
            $this->deleteImage($data['image']);
        }
        $data->delete();
    }

    public function exportCsv()
    {
        $data = Flat::leftJoin('buildings', 'flats.building_id', '=', 'buildings.id')
            ->select('buildings.name AS building_name', 'flats.floor', 'flats.name as flat_name', 'flats.rental')
            ->get()
            ->toArray();

        return $this->csv($data, 'flats');
    }
}
