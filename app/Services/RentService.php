<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Rent;

class RentService
{
    public function listPaginate($request)
    {
        $selectColumns = ['*'];

        return Rent::with('building:id,name')
            ->with('flat:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->paginate(10);
    }

    public function store($request)
    {
        $data = $request->validated();
        if ($this->isBillAlreadyGenerated($data['flat_id'])) {
            throw new \Exception('Bill already generated for this flat!');
        }
        $data['date'] = date('Y-m-d');
        $rent = Rent::create($data);
        $this->billStore($data, $rent->id);

        return $rent;
    }

    private function billStore(array $data, $rent_id)
    {
        $billFields = ['rent_amount', 'water_bill', 'gas_bill', 'security_bill', 'garbage_bill', 'service_charge', 'electric_bill', 'other_bill'];
        $total_amount = 0;

        foreach ($billFields as $field) {
            if (isset($data[$field]) && is_numeric($data[$field])) {
                $total_amount += $data[$field];
            }
        }

        $data['title'] = 'Monthly Rent';
        $data['type'] = 'Rent';
        $data['amount'] = $total_amount;
        $data['doc'] = $rent_id;
        $data['paid_status'] = 0;

        Bill::create($data);
    }

    private function isBillAlreadyGenerated($flat_id)
    {
        $currentMonth = date('Y-m');

        $bill = Rent::where('flat_id', $flat_id)
            ->where('date', 'like', $currentMonth.'%')
            ->orderBy('created_at', 'desc')
            ->first();

        return ! is_null($bill);
    }

    public function get($id)
    {
        $selectColumns = ['*'];

        return Rent::with('building:id,name')
            ->with('flat:id,name')
            ->where('id', $id)
            ->select($selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        if ($this->isBillUpdateAble($id)) {
            throw new \Exception("Rent can't update. Payment in process!");
        }
        $update = Rent::findOrFail($id);
        if ($update) {
            $update->update($data);
        }
        $this->billUpdate($data, $update->id);

        return $update;
    }

    private function isBillUpdateAble($rent_id)
    {
        $rent = Bill::where('doc', $rent_id)
            ->where('type', 'Rent')
            ->whereIn('paid_status', [1, 2])->first();
        //1 = confirm,2=pending

        return $rent;
    }

    private function billUpdate(array $data, $rent_id)
    {
        $bill = Bill::where('doc', $rent_id)
            ->where('type', 'Rent')
            ->first();
        $billFields = ['rent_amount', 'water_bill', 'gas_bill', 'security_bill', 'garbage_bill', 'service_charge', 'electric_bill', 'other_bill'];
        $total_amount = 0;

        foreach ($billFields as $field) {
            if (isset($data[$field]) && is_numeric($data[$field])) {
                $total_amount += $data[$field];
            }
        }
        $data['amount'] = $total_amount;

        return $bill->update($data);
    }

    public function invoiceInfo($id)
    {

        $data = Rent::with('building:id,name,contact_name,contact_number')
            ->with(['flat:id,name'])
            ->findOrFail($id);

        if (isset($data->flat->tenant)) {
            $data['tenant'] = $data->flat->tenant->only(['id', 'name', 'mobile', 'email']);
            unset($data->flat->tenant);
        }

        if (isset($data->bill->paymentBill)) {
            $data['payment_info'] = $data->bill->paymentBill->only(['id', 'date', 'payment_method']);
            unset($data->bill);
        }

        return $data;
    }
}
