<?php

namespace App\Services;

use App\Helpers\BankHelper;
use App\Models\AccountBalance;
use App\Models\Bill;
use App\Models\MaintenanceCost;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class MaintenanceCostService
{
    use ImageUpload;

    private $selectColumns = ['*'];

    public function __construct()
    {
        $this->selectColumns = ['id', 'building_id', 'title', 'date', 'amount', 'details', 'image', 'payment_method', 'recevier_number', 'transection_id', 'from_account', 'to_account', 'bill_payer', 'checked_flats'];
    }

    public function listPaginate($request)
    {
        return MaintenanceCost::query()
            ->with('building:id,name')
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->orderBy('created_at', 'desc')
            ->select($this->selectColumns)
            ->paginate($request->get('per_page', 10));
    }

    public function store($request)
    {
        $data = $request->validated();
        if (! isset($data['checked_flats'])) {
            throw new \InvalidArgumentException('Checked Flats should exist');
        }
        $data['created_by'] = auth()->user()->id;
        $data['date'] = date('Y-m-d');
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->base64FileStore($image, 'images/cost/');
        }
        $data['checked_flats'] = json_encode($data['checked_flats']);
        $maintenance = MaintenanceCost::create($data);
        if ($data['bill_payer'] == 'Flat') {
            $data['date'] = date('Y-m-d');
            $this->storePayerAmount($data, $maintenance->id);
        }

        $this->handleAccountBalance($maintenance);

        return $maintenance;
    }

    private function handleAccountBalance(object $data)
    {
        $docNumber = $data->id;
        $accountBalanceData = [
            'transaction_type' => -1,
            'bank_type' => BankHelper::bankType($data->payment_method),
            'amount' => $data->amount,
            'doc_type' => 'Maintenance Cost',
            'doc_number' => $docNumber,
        ];

        AccountBalance::updateOrCreate(
            [
                'doc_number' => $docNumber,
                'doc_type' => 'Maintenance Cost',
            ],
            $accountBalanceData
        );
    }

    private function storePayerAmount($data, $doc)
    {
        $checked_flats = \json_decode($data['checked_flats']);
        if (! is_array($checked_flats) || empty($checked_flats)) {
            throw new \Exception("Please select at least 1 flat for bill payer 'Flat'");
        }

        $total_flats = count($checked_flats);
        $per_flat_amount = round(($data['amount'] / $total_flats), 2);
        $billData = [
            'date' => $data['date'],
            'building_id' => $data['building_id'],
            'title' => $data['title'],
            'type' => 'Maintenance Cost',
            'amount' => $per_flat_amount,
            'paid_status' => 0,
            'doc' => $doc,
        ];

        foreach ($checked_flats as $item) {
            $billData['flat_id'] = $item;
            Bill::create($billData);
        }

        return true;
    }

    public function get($id)
    {
        return MaintenanceCost::with('building:id,name')
            ->where('id', $id)
            ->select($this->selectColumns)
            ->first();
    }

    public function update($request, $id)
    {
        $data = $request->validated();
        if (! isset($data['checked_flats'])) {
            throw new \InvalidArgumentException('Checked Flats should exist');
        }
        $update = MaintenanceCost::findOrFail($id);
        $data['building_id'] = $update['building_id'];
        $data['updated_by'] = auth()->user()->id;
        $image = $request->image;
        if ($image) {
            $this->deleteImage($update->image);
            $data['image'] = $this->base64FileStore($image, 'images/cost/');
        } else {
            $data = Arr::except($data, ['image']);
        }
        $data['checked_flats'] = json_encode($data['checked_flats']);
        $data = $this->handlePayerAmountUpdate($data, $id, $update);
        if ($update) {
            $update->update($data);
        }
        $this->handleAccountBalance($update);

        return $update;
    }

    private function handlePayerAmountUpdate($data, $doc, $costInfo)
    {
        if ($this->isAlreadyPaid($doc) == 1 && $costInfo['bill_payer'] == 'Flat') {
            $data = Arr::except($data, ['amount']);
            $data = Arr::except($data, ['bill_payer']);
            $data = Arr::except($data, ['checked_flats']);
        } elseif ($data['bill_payer'] == 'Flat') {
            $this->deleteBillByDoc($doc);
            $data['date'] = date('Y-m-d');
            $this->storePayerAmount($data, $doc);
        } elseif ($data['bill_payer'] == 'Owner') {
            $this->deleteBillByDoc($doc);
        }

        return $data;
    }

    private function deleteBillByDoc($doc)
    {
        $bill = Bill::where('doc', $doc)->first();
        if ($bill) {
            $bill->paymentDetails()->forceDelete();
            $bill->forceDelete();
        }
    }

    public function delete($id)
    {
        $data = MaintenanceCost::findOrFail($id);
        $this->deleteImage($data->image);
        $data->delete();
    }

    public function isAlreadyPaid($doc)
    {
        $data = Bill::where('doc', $doc)->where('paid_status', 1)->first();

        return $data ? 1 : 0;
    }
}
