<?php

namespace App\Services;

use App\Helpers\BankHelper;
use App\Models\AccountBalance;
use App\Models\Bill;
use App\Models\MaintenanceCost;
use App\Models\PaymentBill;
use App\Models\PaymentDetails;
use App\Models\Rent;
use App\Models\TenantAdvancedAmount;

class BuildingAccountService
{
    public function summary()
    {
        $balances = AccountBalance::selectRaw('SUM(CASE WHEN transaction_type = 1 THEN amount ELSE 0 END) AS paidAmount,
                                          SUM(amount * transaction_type) AS availableAmount,
                                          bank_type')
            ->groupBy('bank_type')
            ->get();

        $paidInfo = [
            'cash' => 0,
            'mobileBank' => 0,
            'traditionalBank' => 0,
        ];

        $available = [
            'cash' => 0,
            'mobileBank' => 0,
            'traditionalBank' => 0,
        ];

        foreach ($balances as $balance) {
            switch ($balance->bank_type) {
                case 'Traditional Bank':
                    $paidInfo['traditionalBank'] = $balance->paidAmount;
                    $available['traditionalBank'] = $balance->availableAmount;
                    break;
                case 'Cash':
                    $paidInfo['cash'] = $balance->paidAmount;
                    $available['cash'] = $balance->availableAmount;
                    break;
                case 'Mobile Bank':
                    $paidInfo['mobileBank'] = $balance->paidAmount;
                    $available['mobileBank'] = $balance->availableAmount;
                    break;
            }
        }
        $rentNutility = Rent::selectRaw('COALESCE(SUM(rent_amount), 0) as rent_amount, COALESCE(SUM(water_bill + gas_bill + security_bill + garbage_bill + service_charge + electric_bill + other_bill), 0) as utility_amount')
            ->where('status', 1)
            ->first();

        $data['rent_amount'] = $rentNutility->rent_amount;
        $data['utility_amount'] = $rentNutility->utility_amount;

        $data['mc'] = MaintenanceCost::selectRaw('COALESCE(SUM(amount), 0) as costAmount')
            ->value('costAmount');

        $data['paidInfo'] = $paidInfo;
        $data['availableBalance'] = $available;

        return $data;
    }

    public function tenantPayments()
    {
        $selectColumns = ['id', 'building_id', 'flat_id', 'payment_method', 'receiver_number', 'transaction_id', 'from_account', 'to_account', 'total_amount', 'pay_amount', 'use_advanced_amount', 'discount_amount', 'date', 'status', 'note'];
        $data = PaymentBill::with('building:id,name')
            ->with('flat:id,name')
            ->orderBy('created_at', 'desc')
            ->select($selectColumns)
            ->get();

        return $data;
    }

    public function paymentDetails($payment_id)
    {
        $selectColumns = ['id', 'payment_bill_id', 'bill_id', 'amount'];
        $data = PaymentDetails::with('bill:id,title,type,date')
            ->where('payment_bill_id', $payment_id)
            ->select($selectColumns)
            ->get();

        return $data;
    }

    public function update($request, $id)
    {
        $data = $request->validated();

        $data['updated_by'] = auth()->user()->id;
        $update = PaymentBill::findOrFail($id);
        if ($update) {
            $update->update($data);
            TenantAdvancedAmount::where('doc_number', $update->id)->where('doc_type', 'Bill payment')->update(['status' => $data['status']]);

            Bill::join('payment_details', 'payment_details.bill_id', '=', 'bills.id')
                ->where('payment_details.payment_bill_id', $id)
                ->update(['paid_status' => $data['status']]);

            $rents = Rent::whereIn('id', function ($query) use ($id) {
                $query->select('doc')
                    ->from('bills')
                    ->join('payment_details', 'payment_details.bill_id', '=', 'bills.id')
                    ->where('payment_details.payment_bill_id', $id)
                    ->where('bills.type', 'Rent');
            })
                ->update(['status' => $data['status']]);
            $this->handleAccountBalance($update);
        }

        return $update;
    }

    private function handleAccountBalance($data)
    {
        $docNumber = $data->id;
        $accountBalanceData = [
            'transaction_type' => 1,
            'bank_type' => BankHelper::bankType($data->payment_method),
            'amount' => $data->pay_amount,
            'doc_type' => 'Tenant Payment',
            'doc_number' => $docNumber,
        ];

        if ($data->status == 1) {
            $accountBalance = AccountBalance::withTrashed()
                ->where('doc_number', $docNumber)
                ->where('doc_type', 'Tenant Payment')
                ->first();

            if ($accountBalance) {
                $accountBalance->restore();
            } else {
                $accountBalance = new AccountBalance;
            }

            $accountBalance->fill($accountBalanceData);
            $accountBalance->save();
        } else {
            AccountBalance::where('doc_number', $docNumber)
                ->where('doc_type', 'Tenant Payment')
                ->delete();
        }
    }

    public function bankTypeWiseCurrentBalance($bank_type)
    {
        $balance = AccountBalance::selectRaw('COALESCE(SUM(amount * transaction_type), 0) as balance')
            ->where('bank_type', $bank_type)
            ->groupBy('bank_type')
            ->value('balance');
        if ($balance == null) {
            $balance = 0;
        }

        return $balance;
    }

    public function withdraw($request)
    {
        $data = $request->validated();
        if ($this->bankTypeWiseCurrentBalance($data['bank_type']) < $data['withdrawAmount']) {
            throw new \RuntimeException('Insufficient balance for withdraw');
        }
        $accountBalanceData = [
            'transaction_type' => -1,
            'bank_type' => $data['bank_type'],
            'amount' => $data['withdrawAmount'],
            'doc_type' => 'Withdraw',
            'doc_number' => null,
        ];

        return AccountBalance::create($accountBalanceData);
    }

    public function withdrawHistory($request)
    {
        $data = $request->validated();
        $responseData = AccountBalance::where('bank_type', $data['bank_type'])
            ->whereDate('created_at', '>=', $data['fdate'])
            ->whereDate('created_at', '<=', $data['tdate'])
            ->where('doc_type', 'Withdraw')
            ->orderBy('created_at', 'desc')
            ->get();

        return $responseData;
    }
}
