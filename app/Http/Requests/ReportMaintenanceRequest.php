<?php

namespace App\Http\Requests;

use App\Traits\CommonReportRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportMaintenanceRequest extends FormRequest
{
    use CommonReportRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $commonRules = $this->commonRules();

        return array_merge($commonRules, [
            'bill_payer' => 'nullable|in:Owner,Flat',
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
