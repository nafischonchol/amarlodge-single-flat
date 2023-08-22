<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FlatUpdateRequest extends FormRequest
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
            'floor' => 'required',
            'name' => 'required',
            'area' => 'required|numeric',
            'parking_area' => 'nullable',
            'room' => 'required|numeric',
            'washroom' => 'required|numeric',
            'balcony' => 'required|boolean',
            'utilities' => 'required',
            'rental' => 'required|numeric',
            'notes' => 'nullable',
            'termsAndCondition' => 'nullable',
            'rented_to_bachelors' => 'required|boolean',
            'minimumStay' => 'required|numeric',
            'youtube_video' => 'nullable',
            'image' => 'nullable',
            'images' => ['nullable', 'array', 'max:5'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
