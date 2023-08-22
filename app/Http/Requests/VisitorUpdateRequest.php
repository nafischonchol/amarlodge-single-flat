<?php

namespace App\Http\Requests;

use App\Rules\FlatBelongsToBuilding;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VisitorUpdateRequest extends FormRequest
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
            'host_information' => 'required',
            'building_id' => 'required|exists:buildings,id',
            'flat_id' => [
                'required',
                new FlatBelongsToBuilding($this->input('building_id')),
            ],
            'name' => 'required',
            'mobile' => 'required|numeric',
            'in_time' => 'required|date_format:Y-m-d H:i:s|before:out_time',
            'out_time' => 'nullable|date_format:Y-m-d H:i:s',
            'image' => 'nullable',
            'purpose' => 'required',
            'additional_notes' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'building_id.required' => 'Building is required',
            'flat_id.required' => 'Flat is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
