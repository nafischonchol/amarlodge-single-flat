<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TenantStoreRequest extends FormRequest
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
        $flatId = $this->input('flat_id');

        return [
            'flat_id' => [
                'nullable', 'exists:flats,id',
            ],
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'address' => 'required',
            'nid' => 'required',
            'member' => 'required',
            'advanced_amount' => 'required',
            'issue_date' => 'required|date',
            'rent_month' => 'required|date',
            'image' => 'required',
            'additional_notes' => 'nullable',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'building_id.required' => 'Building is required',
            'flat_id.required' => 'Flat is required',
            'flat_id.unique' => 'Flat is not available',
            'rent_per_month.min' => 'Minimum one thousand',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
