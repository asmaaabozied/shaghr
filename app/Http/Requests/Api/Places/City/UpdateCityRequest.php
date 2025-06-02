<?php

namespace App\Http\Requests\Api\Places\City;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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

            "country_id" => "required|exists:countries,id",
            'name_en' => 'required|string|max:191',
            'name_ar' => 'required|string|max:191',
            'image' => 'nullable',
            'is_active' => 'boolean',
            'creator_id' => 'nullable|integer',
            'delete_id' => 'nullable|integer',
        ];
    }
}
