<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WithdrawHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bank_type' => 'required|in:Cash,Mobile Bank,Traditional Bank',
            'fdate' => 'required|date',
            'tdate' => 'required|date|after_or_equal:fdate',
        ];
    }

    public function messages(): array
    {
        return [
            'fdate.required' => 'From date is required',
            'tdate.required' => 'To date is required',
            'tdate.after_or_equal' => 'The To Date must be equal to or greater than the From Date.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
