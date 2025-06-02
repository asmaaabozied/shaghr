<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'city_id' => 'required|integer',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_in_time' => 'nullable|date_format:H:i:s',
            'number_of_people' => 'nullable|integer|min:1',
            'room_type_id' => 'nullable|integer|exists:room_types,id',
            'number_people' => 'nullable|integer',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'amenities' => 'nullable|array',
            'review_rate' => 'nullable|integer',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'number_of_people' => $this->number_of_people ?? 1,
        ]);
    }
}
