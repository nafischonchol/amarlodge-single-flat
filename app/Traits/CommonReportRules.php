<?php

namespace App\Traits;

use App\Rules\FlatBelongsToBuilding;

trait CommonReportRules
{
    public function commonRules()
    {
        return [
            'building_id' => 'nullable|exists:buildings,id',
            'flat_id' => [
                'nullable',
                new FlatBelongsToBuilding($this->input('building_id')),
            ],
            'month' => 'nullable|date',
        ];
    }
}
