<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class FlatAccountService
{
    private $selectColumns = ['*'];

    private $tenant;

    public function __construct()
    {
        // $this->tenant = auth()->user()->tenant;
    }

    public function summery()
    {
        $this->tenant = auth()->user()->tenant;
        $flat_id = $this->tenant->flat_id;

        $totalBillAmountQuery = DB::table('bills')
            ->selectRaw('YEAR(date) AS year, MONTH(date) AS month, SUM(amount) AS total_bill_amount')
            ->where('flat_id', $flat_id)
            ->groupBy('year', 'month');

        $totalPayAmountQuery = DB::table('payment_bills')
            ->selectRaw('YEAR(date) AS year, MONTH(date) AS month, SUM(pay_amount) AS total_pay_amount')
            ->where('flat_id', $flat_id)
            ->groupBy('year', 'month');

        // Manually bind the flat_id value to the subqueries
        $totalBillAmountQuery->addBinding($flat_id, 'where');
        $totalPayAmountQuery->addBinding($flat_id, 'where');

        $results = DB::table(DB::raw("({$totalBillAmountQuery->toSql()}) AS b"))
            ->mergeBindings($totalBillAmountQuery)
            ->leftJoin(DB::raw("({$totalPayAmountQuery->toSql()}) AS p"), function ($join) {
                $join->on('b.year', '=', 'p.year')
                    ->on('b.month', '=', 'p.month');
            })
            ->selectRaw('CONCAT(MONTHNAME(CONCAT(b.year, "-", b.month, "-01")), ", ", b.year) AS date, b.total_bill_amount, COALESCE(p.total_pay_amount, 0) AS total_pay_amount')
            ->get();

        return $results;
    }
}
