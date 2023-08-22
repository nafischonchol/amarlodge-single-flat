<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Models\Bill;
use App\Models\PaymentBill;
use App\Models\PaymentDetails;
use App\Models\Rent;
use App\Models\TenantAdvancedAmount;
use Illuminate\Support\Carbon;

class BillService
{
    private $selectColumns = ['id', 'building_id', 'flat_id', 'date', 'title', 'type', 'amount'];

    private $tenant;

    public function __construct()
    {
        // $this->tenant = auth()->user()->tenant;
    }

    public function list()
    {
        $this->tenant = auth()->user()->tenant;
        $currentMonth = Carbon::now()->format('m');

        $data['due_bills'] = Bill::where('flat_id', $this->tenant->flat_id)
            ->whereNotIn('paid_status', [1, 2])
            ->where('date', '<', Carbon::now()->startOfMonth())
            ->select($this->selectColumns)
            ->get();

        $data['current_bills'] = Bill::whereMonth('date', $currentMonth)
            ->where('flat_id', $this->tenant->flat_id)
            ->whereNotIn('paid_status', [1, 2])
            ->select($this->selectColumns)
            ->get();

        return $data;
    }

    private function storeAdvancedAmount($data)
    {
        $this->tenant = auth()->user()->tenant;
        $advancedData['flat_id'] = $data['flat_id'];
        $advancedData['tenant_id'] = $this->tenant->id;
        $advancedData['date'] = date('Y-m-d');
        $advancedData['amount'] = $data['use_advanced_amount'];
        $advancedData['transaction_type'] = -1;
        $advancedData['status'] = 4;
        $advancedData['doc_number'] = $data->id;
        $advancedData['doc_type'] = 'Bill payment';
        $tenantAdvanced = TenantAdvancedAmount::create($advancedData);

        return $tenantAdvanced;
    }

    public function paymentStore($request)
    {
        $this->tenant = auth()->user()->tenant;
        $data = $request->validated();
        if (isset($data['use_advanced_amount']) && GeneralHelper::currentAdvancedAmount($this->tenant->id) < $data['use_advanced_amount']) {
            throw new \Exception("Use advanced, Can't be greater than advanced amount!");
        }

        $data['building_id'] = $this->tenant->building_id;
        $data['flat_id'] = $this->tenant->flat_id;
        $data['date'] = date('Y-m-d');

        $billList = Bill::whereIn('id', $data['checked_bills'])->whereIn('paid_status', [0, 2])->get();

        if ($data['pay_amount'] > $data['total_amount']) {
            $data['pay_amount'] = $data['total_amount'];
        }

        $paymentBill = PaymentBill::create($data);
        if (isset($data['use_advanced_amount']) && $data['use_advanced_amount'] > 0) {
            $this->storeAdvancedAmount($paymentBill);
        }
        $paymentDetails = [];
        $currentTimestamp = now();
        foreach ($billList as $bill) {
            $paymentDetails[] = [
                'payment_bill_id' => $paymentBill->id,
                'bill_id' => $bill->id,
                'amount' => $bill->amount,
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ];
            $bill->update(['paid_status' => 2]);
            if ($bill->type == 'Rent') {
                Rent::where('id', $bill->doc)->update(['status' => 2]);
            }
        }
        PaymentDetails::insert($paymentDetails);

        return $paymentBill;
    }

    public function flatPayBillHistory()
    {
        $this->tenant = auth()->user()->tenant;
        $selectColumns = ['id', 'building_id', 'flat_id', 'payment_method', 'receiver_number', 'transaction_id', 'from_account', 'to_account', 'total_amount', 'pay_amount', 'discount_amount', 'use_advanced_amount', 'date', 'status', 'note'];
        $data = PaymentBill::where('flat_id', $this->tenant->flat_id)
            ->orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->get();

        return $data;
    }

    public function payBillHistoryDetails($payment_id)
    {
        $selectColumns = ['id', 'payment_bill_id', 'bill_id', 'amount'];
        $data = PaymentDetails::with('bill:id,title,type,date')
            ->where('payment_bill_id', $payment_id)
            ->select($selectColumns)
            ->get();

        return $data;
    }
}
