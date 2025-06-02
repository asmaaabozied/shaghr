<?php

namespace App\Http\Requests\Api\Hotels;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressHotelsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'id' => 'required|exists:hotels,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',

        ];
    }
}
