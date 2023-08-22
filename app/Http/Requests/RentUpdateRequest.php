<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RentUpdateRequest extends FormRequest
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
            'building_id' => 'required',
            'flat_id' => 'required',
            'rent_amount' => 'required|numeric',
            'water_bill' => 'required|numeric',
            'gas_bill' => 'required|numeric',
            'security_bill' => 'nullable|numeric',
            'garbage_bill' => 'nullable|numeric',
            'service_charge' => 'nullable|numeric',
            'electric_bill' => 'nullable|numeric',
            'other_bill' => 'nullable|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
