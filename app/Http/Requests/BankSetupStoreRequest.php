<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class BankSetupStoreRequest extends FormRequest
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
        $request = $this->request->all();

        return [
            'bank_name' => [
                'required',
                Rule::unique('bank_setups')->where(function ($query) use ($request) {
                    return $query->where('bank_name', $request['bank_name']);
                }),
            ],
            'bank_type' => 'required|in:Mobile Bank,Traditional Bank',
        ];
    }

    public function messages(): array
    {
        return [
            'bank_type.required' => 'Bank type is required',
            'bank_type.in' => 'Please choose either "Mobile Bank" or "Traditional Bank".',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
