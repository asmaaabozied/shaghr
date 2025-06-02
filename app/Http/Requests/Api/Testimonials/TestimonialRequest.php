<?php

namespace App\Http\Requests\Api\Testimonials;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class TestimonialRequest extends FormRequest
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
//        |min:240
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
            'position' => 'nullable',
            'submission_date' => 'required|date',
            'review_text_ar' => 'nullable',
            'review_text_ar' => 'nullable',
            'rating' => 'nullable',
            'status' => 'nullable',
            'active' => 'nullable',
            'Published' => 'nullable',

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
