<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommitteUpdateRequest extends FormRequest
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
        return [
            'building_id' => 'nullable|exists:buildings,id',
            'name' => 'required',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'present_address' => 'required',
            'permanet_address' => 'nullable',
            'nid' => 'required|numeric',
            'designation' => 'nullable',
            'status' => 'required|numeric',
            'joining_date' => 'required|date',
            'end_date' => 'nullable|date',
            'details_info' => 'nullable',
            'image' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
