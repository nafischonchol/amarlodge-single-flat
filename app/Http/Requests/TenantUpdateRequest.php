<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TenantUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $flatId = $this->input('flat_id');
        $tenantId = $this->route('tenant');

        return [
            'flat_id' => [
                'nullable', 'exists:flats,id',
            ],
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
            'nid' => 'required',
            'member' => 'required',
            'issue_date' => 'required|date',
            'rent_month' => 'required|date',
            'image' => 'nullable',
            'additional_notes' => 'nullable',
        ];

        // in laravel on form submit. can i validate that number should be greater that 1000 , other wise get error
    }

    public function messages()
    {
        return [
            'flat_id.required' => 'Flat is required',
            'rent_per_month.min' => 'Minimum one thousand',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
