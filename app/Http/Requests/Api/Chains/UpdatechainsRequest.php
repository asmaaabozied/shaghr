<?php

namespace App\Http\Requests\Api\Chains;

use Illuminate\Foundation\Http\FormRequest;

class UpdatechainsRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id', // Ensure the user exists
            'name_en' => 'required|string|max:191', // Validate name in English
            'name_ar' => 'required|string|max:191', // Validate name in Arabic
            'hotels_count' => 'nullable|integer|min:0', // Number of hotels, nullable
            'image' => 'nullable', // Image nullable
            'active' => 'nullable', // active nullable
            'update_id' => 'nullable|exists:users,id', // Ensure updater exists if provided
            'delete_id' => 'nullable|exists:users,id', // Ensure deleter exists if provided
        ];
    }
}
