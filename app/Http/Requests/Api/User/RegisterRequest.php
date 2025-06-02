<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:191',
            'last_name'  => 'required|string|max:191',
            'email'      => 'nullable|email|max:191|unique:users,email',
            'phone'      => 'required|string|max:191|unique:users,phone',
            'password'   => 'required|string|min:8',
            'type'   => 'nullable|string',

        ];
    }
}
