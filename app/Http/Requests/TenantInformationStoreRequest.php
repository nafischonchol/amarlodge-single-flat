<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TenantInformationStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'father_name' => 'required|string',
            'dob' => 'required|date',
            'marital_status' => 'required|string',
            'permanent_address' => 'required|string',
            'profession' => 'nullable|string',
            'institute_address' => 'nullable|string',
            'religion' => 'required|string',
            'educational_qualification' => 'nullable|string',
            'mobile' => 'required|string',
            'email' => 'nullable|email',
            'nid' => 'required|string',
            'passport_number' => 'nullable|string',
            'emergency_name' => 'required|string',
            'emergency_mobile' => 'required|string',
            'emergency_address' => 'required|string',
            'emergency_relation' => 'required|string',
            'image' => 'required',
            'family_members' => 'required|array',
            'family_members.*.member_name' => 'required|string',
            'family_members.*.member_age' => 'required|integer',
            'family_members.*.member_profession' => 'nullable|string',
            'family_members.*.member_mobile' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
