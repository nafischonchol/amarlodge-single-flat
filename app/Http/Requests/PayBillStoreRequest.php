<?php

namespace App\Http\Requests;

use App\Rules\BankTypeValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PayBillStoreRequest extends FormRequest
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
            'total_amount' => 'required',
            'discount_amount' => 'nullable',
            'use_advanced_amount' => 'nullable',
            'pay_amount' => 'nullable',
            'checked_bills' => 'required|array',
            'payment_method' => 'required',
            'from_account' => [new BankTypeValidationRule($this->input('payment_method'))],
            'to_account' => [new BankTypeValidationRule($this->input('payment_method'))],
            'transaction_id' => [new BankTypeValidationRule($this->input('payment_method'))],
            'receiver_number' => [new BankTypeValidationRule($this->input('payment_method'))],
            'note' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'checked_bills.required' => 'Please select bill first!',
            'checked_bills.array' => 'Bill list should be array!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
