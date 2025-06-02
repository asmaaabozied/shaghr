<?php

namespace App\Http\Requests\Api\Places\District;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
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
            "city_id" => "required|exists:cities,id",
            'name_en' => 'required|string|max:191',
            'name_ar' => 'required|string|max:191',
            'icon' => 'nullable|string|max:191',
            'is_active' => 'boolean',
            'update_id' => 'nullable|integer',
            'delete_id' => 'nullable|integer',
        ];
    }
}
