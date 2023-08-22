<?php

namespace App\Http\Requests;

use App\Rules\BankTypeValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FlatCostStoreRequest extends FormRequest
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
            'date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'cause' => 'required',
            'payment_method' => 'required',
            'from_account' => [new BankTypeValidationRule($this->input('payment_method'))],
            'to_account' => [new BankTypeValidationRule($this->input('payment_method'))],
            'transection_id' => [new BankTypeValidationRule($this->input('payment_method'))],
            'recevier_number' => [new BankTypeValidationRule($this->input('payment_method'))],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
