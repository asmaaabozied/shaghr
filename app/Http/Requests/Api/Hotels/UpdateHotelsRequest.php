<?php

namespace App\Http\Requests\Api\Hotels;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelsRequest extends FormRequest
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
            'chain_id' => 'required|exists:chains,id',
            'name_en' => 'required|string|max:191',
            'name_ar' => 'required|string|max:191',
            'total_rooms' => 'nullable|integer',
            'rating' => 'nullable|numeric|between:0,5.00',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'nullable|string|max:255',
            'building_number' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'descripton_en' => 'required|string|max:255',
            'descripton_ar' => 'nullable|string|max:255',
            'creator_id' => 'nullable|integer',
            'delete_id' => 'nullable|integer',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'document' => 'nullable',
            'images' => 'nullable',
            'images_ids' => 'nullable|array',
            'hotel_policy_ar'=>'nullable',
            'hotel_policy_en'=>'nullable',
        ];
    }
}
