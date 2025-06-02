<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOtpRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required|max:5',
            'phone' => 'required|unique:users,phone|alpha_num',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'register_from' => 'required',
        ];
    }
}
