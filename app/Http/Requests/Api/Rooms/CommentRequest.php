<?php

namespace App\Http\Requests\Api\Rooms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class CommentRequest extends FormRequest
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
            'rating' => 'required|integer|between:1,5',
            'view' => 'nullable',
            'status' => 'nullable',
            'user_id' => 'nullable',
            'room_id' => 'required',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',

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
