<?php

namespace App\Services;

use App\Models\Complain;
use App\Models\Flat;
use App\Models\MaintenanceCost;
use App\Models\Rent;
use App\Models\Visitor;

class ReportService
{
    public function applyCommonConditions($query, $input, $dateColumn = 'date')
    {
        if (isset($input['building_id'])) {
            $query->where('building_id', $input['building_id']);
        }

        if (isset($input['month'])) {
            [$year, $month] = explode('-', $input['month']);
            $query->whereYear($dateColumn, $year)
                ->whereMonth($dateColumn, $month);
        }
    }

    public function rentalReport($request)
    {
        $input = $request->validated();
        $query = Rent::query()
            ->with('building:id,name')
            ->with('flat:id,name');

        $this->applyCommonConditions($query, $input);
        if (isset($input['flat_id'])) {
            $query->where('flat_id', $input['flat_id']);
        }
        if (isset($input['payment_status'])) {
            $query->where('status', $input['payment_status']);
        }

        return $query->get();
    }

    public function mcReport($request)
    {
        $input = $request->validated();
        $query = MaintenanceCost::query()
            ->with('building:id,name');

        $this->applyCommonConditions($query, $input);

        if (isset($input['bill_payer'])) {
            $query->where('bill_payer', $input['bill_payer']);
        }

        if (isset($input['flat_id'])) {
            $query->whereJsonContains('checked_flats', $input['flat_id']);
        }

        $maintenanceCosts = $query->get();

        $flatIds = $maintenanceCosts->pluck('checked_flats')
            ->map(function ($item) {
                return json_decode($item);
            })
            ->flatten()
            ->toArray();
        $flatNames = Flat::whereIn('id', $flatIds)->pluck('name', 'id');

        $maintenanceCosts->transform(function ($cost) use ($flatNames) {
            $cost->checked_flat_names = $flatNames->only(json_decode($cost->checked_flats));

            return $cost;
        });

        return $maintenanceCosts;
    }

    public function visitorReport($request)
    {
        $input = $request->validated();
        $query = Visitor::query()
            ->with('building:id,name')
            ->with('flat:id,name');
        if (isset($input['flat_id'])) {
            $query->where('flat_id', $input['flat_id']);
        }
        $this->applyCommonConditions($query, $input, 'in_time');

        return $query->get();
    }

    public function complainReport($request)
    {
        $input = $request->validated();
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
            ]);

        if (isset($input['complaint_by'])) {
            $query->where('complaint_by', $input['complaint_by']);
        }
        if (isset($input['complaint_against'])) {
            $query->where('complaint_against', $input['complaint_against']);
        }
        $this->applyCommonConditions($query, $input);

        return $query->get();
    }
}
