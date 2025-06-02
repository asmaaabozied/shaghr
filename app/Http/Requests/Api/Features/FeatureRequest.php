<?php


namespace App\Http\Requests\Api\Features;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class FeatureRequest extends FormRequest
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
            'image' => 'nullable', 'mimes:jpg,jpeg,png',
            'name_ar' => 'required',
            'name_en' => 'required',
            'status' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
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
