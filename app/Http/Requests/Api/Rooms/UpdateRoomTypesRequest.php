<?php

namespace App\Http\Requests\Api\Rooms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomTypesRequest extends FormRequest
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
    public function rules()
    {
        $roomTypeId = $this->route('room_type'); // Get the room type ID from the route (assumed)

        return [
            // Validate the 'name' fields for both English and Arabic, ensuring uniqueness except for the current room type
            'name_en' => 'required|string|max:255|unique:room_types,name_en,' . $roomTypeId,
            'name_ar' => 'required|string|max:255|unique:room_types,name_ar,' . $roomTypeId,

            // Validate the 'description' fields for both English and Arabic
            'description_en' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',

            // Validate the capacity field
            'capacity' => 'nullable|integer|min:1|max:10', // Ensure the capacity is a number between 1 and 10
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_en.required' => 'The English name is required.',
            'name_ar.required' => 'The Arabic name is required.',
            'name_en.unique' => 'The English name must be unique.',
            'name_ar.unique' => 'The Arabic name must be unique.',
            'capacity.min' => 'The room capacity must be at least 1.',
            'capacity.max' => 'The room capacity cannot exceed 10.',
        ];
    }
}
