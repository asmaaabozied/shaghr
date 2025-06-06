<?php

namespace App\Http\Requests\Api\Places\Country;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'name_en' => 'required|string|max:191',
            'name_ar' => 'required|string|max:191',
            'code' => 'required|unique:countries|string|max:5',
            'icon' => 'nullable',
            'is_active' => 'boolean',
            'update_id' => 'nullable|integer',
            'delete_id' => 'nullable|integer',
        ];
    }
}
