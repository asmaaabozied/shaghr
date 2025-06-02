<?php

namespace App\Http\Requests\Api\Images;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ImageGalleryRequest extends FormRequest
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
            'image_name' => 'required',
            'extension' => 'required',
            'status' => 'nullable',
            'image' => 'nullable',
            'size' => 'nullable',
            'thumbnail' => 'nullable',
            'published' => 'nullable',
            'alternative_text_ar' => 'nullable',
            'alternative_text_en' => 'nullable',

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
