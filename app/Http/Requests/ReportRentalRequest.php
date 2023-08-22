<?php

namespace App\Http\Requests;

use App\Traits\CommonReportRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportRentalRequest extends FormRequest
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
            'payment_status' => 'nullable|numeric|in:0,1,2,3',
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
