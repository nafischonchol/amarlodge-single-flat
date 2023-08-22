<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Building;
use App\Models\Complain;
use App\Models\Flat;
use App\Models\FlatCost;
use App\Models\MaintenanceCost;
use App\Models\Rent;
use App\Models\Staff;
use App\Models\Tenant;
use App\Models\Visitor;
use Illuminate\Support\Carbon;

class DashboardService
{
    private $currentMonth;

    private $currentYear;

    private $currentDate;

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->currentDate = Carbon::now()->toDateString();
    }

    public function monthlyRentDataForChart()
    {
        $results = Rent::selectRaw('MONTH(date) AS month, SUM(rent_amount) AS total_rent')
            ->whereYear('date', $this->currentYear)
            ->where('status', '<>', 3)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = $results->map(function ($result) {
            $monthNumber = $result->month;
            $monthName = date('F', mktime(0, 0, 0, $monthNumber, 1));

            return [
                'month' => $monthName,
                'amount' => $result->total_rent,
            ];
        })->toArray();

        $data['chartLabels'] = array_column($data, 'month');
        $data['chartData'] = array_column($data, 'amount');

        return $data;
    }

    public function summary()
    {
        $data = [];
        if (auth()->user()->hasRole('Tenant')) {
            $tenant = auth()->user()->tenant;
            $this->totalCost($data, $tenant);
            $this->tenantComplainData($data, $tenant);
            $this->tenantRent($data, $tenant);
            $this->tenantMaintanceCost($data, $tenant);
            $this->tenantBill($data, $tenant);
            $this->tenantUtilityBill($data, $tenant);
        } else {
            $this->buildingData($data);
            $this->tenantData($data);
            $this->staffData($data);
            $this->visitorData($data);
            $this->complainData($data);
            $this->flatData($data);
            $this->rentData($data);
            $this->maintanceCost($data);
        }

        return $data;
    }

    //data for tenant role
    private function totalCost(&$data, $tenant)
    {
        $data['total_cost'] = FlatCost::where('flat_id', $tenant->flat_id)->sum('amount');
    }

    private function tenantComplainData(&$data, $tenant)
    {
        $data['total_complains'] = Complain::where('complaint_by', $tenant->flat_id)
            ->where('complaint_by', $tenant->flat_id)
            ->orWhere('complaint_against', $tenant->flat_id)
            ->orWhere('complaint_against', 'All')
            ->count();
    }

    private function tenantRent(&$data, $tenant)
    {
        $rent = Rent::selectRaw('SUM(CASE WHEN status IN (0,2) THEN rent_amount ELSE 0 END) as dueRent')
            ->selectRaw('SUM(rent_amount) as totalRent')
            ->where('flat_id', $tenant->flat_id)
            ->first();
        $data['total_due_rent'] = $rent->dueRent ?? 0;
        $data['total_rent'] = $rent->totalRent ?? 0;
    }

    private function tenantMaintanceCost(&$data, $tenant)
    {
        $cost = Bill::selectRaw('coalesce(SUM(amount),0) as total_maintenance_cost')
            ->selectRaw('coalesce(SUM(CASE WHEN date = ? THEN amount ELSE 0 END),0) as today_maintenance_cost', [$this->currentDate])
            ->selectRaw('coalesce(SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END),0) as this_month_maintenance_cost', [$this->currentMonth, $this->currentYear])
            ->where('flat_id', $tenant->flat_id)
            ->where('type', 'Maintenance Cost')
            ->first();
        $data['total_maintenance_cost'] = $cost->total_maintenance_cost;
        $data['today_maintenance_cost'] = $cost->today_maintenance_cost;
        $data['this_month_maintenance_cost'] = $cost->this_month_maintenance_cost;
    }

    private function tenantBill(&$data, $tenant)
    {
        $bill = Bill::selectRaw('coalesce(SUM(CASE WHEN paid_status <> 1  THEN amount ELSE 0 END) ,0) as total_due_bill')
            ->selectRaw('coalesce(SUM(CASE WHEN paid_status=1  THEN amount ELSE 0 END),0) as total_paid_bill')
            ->where('flat_id', $tenant->flat_id)
            ->first();
        $data['total_due_bill'] = $bill->total_due_bill;
        $data['today_paid_bill'] = $bill->total_paid_bill;
    }

    private function tenantUtilityBill(&$data, $tenant)
    {
        $bill = Rent::selectRaw('coalesce(SUM(water_bill + gas_bill + security_bill + garbage_bill + service_charge + electric_bill + other_bill),0) as total_utility_bill')
            ->where('flat_id', $tenant->flat_id)
            ->first();
        $data['total_utility_bill'] = $bill->total_utility_bill;
    }

    //data for Owner role
    private function buildingData(&$data)
    {
        $data['total_building'] = Building::count();
    }

    private function tenantData(&$data)
    {
        $data['total_tenant'] = Tenant::where('status', 1)->count();
    }

    private function staffData(&$data)
    {
        $data['total_staff'] = Staff::count();
    }

    private function visitorData(&$data)
    {
        $data['total_visitor'] = Visitor::count();
    }

    private function complainData(&$data)
    {
        $data['total_complains'] = Complain::count();
    }

    private function flatData(&$data)
    {
        $flats = Flat::selectRaw('coalesce(COUNT(*),0) as total_flat')
            ->selectRaw('coalesce(SUM(booked = 1),0) as total_booked_flat')
            ->selectRaw('coalesce (SUM(booked = 0),0) as total_available_flat')
            ->first();
        $data['total_flat'] = $flats->total_flat;
        $data['total_booked_flat'] = $flats->total_booked_flat;
        $data['total_available_flat'] = $flats->total_available_flat;
    }

    private function rentData(&$data)
    {
        $rent = Rent::selectRaw('SUM(CASE WHEN status IN (0, 1, 2) AND MONTH(date) = ? AND YEAR(date) = ? THEN rent_amount ELSE 0 END) as rent', [$this->currentMonth, $this->currentYear])
            ->selectRaw('SUM(CASE WHEN status IN (0,2) THEN rent_amount ELSE 0 END) as dueRent')
            ->first();

        $data['current_month_rent'] = $rent->rent ?? 0;
        $data['total_due_rent'] = $rent->dueRent ?? 0;
    }

    private function maintanceCost(&$data)
    {
        $cost = MaintenanceCost::selectRaw('coalesce(SUM(amount),0) as total_maintenance_cost')
            ->selectRaw('coalesce(SUM(CASE WHEN date = ? THEN amount ELSE 0 END),0) as today_maintenance_cost', [$this->currentDate])
            ->selectRaw('coalesce(SUM(CASE WHEN MONTH(date) = ? AND YEAR(date) = ? THEN amount ELSE 0 END),0) as this_month_maintenance_cost', [$this->currentMonth, $this->currentYear])
            ->first();
        $data['total_maintenance_cost'] = $cost->total_maintenance_cost;
        $data['today_maintenance_cost'] = $cost->today_maintenance_cost;
        $data['this_month_maintenance_cost'] = $cost->this_month_maintenance_cost;
    }
}
