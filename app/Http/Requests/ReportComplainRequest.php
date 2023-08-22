<?php

namespace App\Http\Requests;

use App\Traits\CommonReportRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportComplainRequest extends FormRequest
{
    use CommonReportRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id' => 'nullable|exists:buildings,id',
            'complaint_by' => 'nullable',
            'complaint_against' => 'nullable',
            'month' => 'nullable|date',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
