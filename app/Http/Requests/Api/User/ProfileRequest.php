<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ProfileRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone' => 'required|unique:users,phone,'.auth()->id(),
            'country_code' => 'nullable|max:5',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'job_title' => 'nullable',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'nickname' => 'nullable',
            'address' => 'nullable',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'languages' => 'nullable|array',
            'intersts' => 'nullable|array',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'code' => 422,
            'message' => 'The given data is invalid',
            'errors' => $validator->errors(),
        ]);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
