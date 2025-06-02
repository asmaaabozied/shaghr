<?php

namespace App\Http\Requests\Api\Chains\Requests\Api\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class FaqRequest extends FormRequest
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
            'title_ar' => 'required',
            'title_en' => 'required',
            'status' => 'nullable',
            'published' => 'nullable',
            'category' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
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
