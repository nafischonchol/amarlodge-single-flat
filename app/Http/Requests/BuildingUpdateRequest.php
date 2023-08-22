<?php

namespace App\Http\Requests;

use App\Rules\DistrictBelongsToDivision;
use App\Rules\DivisionBelongsToCountry;
use App\Rules\UpozilaBelongsToDisctrict;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuildingUpdateRequest extends FormRequest
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
            'name' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required|numeric',
            'floor' => 'required|numeric',
            'lift' => 'nullable',
            'staff_id' => ['nullable', 'array'],
            'country_id' => 'required|exists:countries,id',
            'division_id' => [
                'required',
                'exists:divisions,id',
                new DivisionBelongsToCountry($this->input('country_id')),
            ],
            'district_id' => [
                'required',
                'exists:districts,id',
                new DistrictBelongsToDivision($this->input('division_id')),
            ],
            'upozila_id' => [
                'required',
                'exists:upozilas,id',
                new UpozilaBelongsToDisctrict($this->input('district_id')),
            ],
            'street' => 'nullable',
            'post_code' => 'nullable',
            'house_number' => 'nullable',
            'details_info' => 'nullable',
            'image' => 'nullable',
            'images' => ['nullable', 'array', 'max:5'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
