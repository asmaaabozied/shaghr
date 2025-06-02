<?php

namespace App\Http\Requests\Api\Rooms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class RoomRequest extends FormRequest
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
            'title_en' => 'required',
            'title_ar' => 'required',
            'number_people' => 'required',
            'name_ar' => 'nullable',
            'name_en' => 'nullable',
            'pricing' => 'nullable',
            'space' => 'nullable',
            'status' => 'nullable',
            'active' => 'nullable',
            'availabilities' => 'nullable',
            'description_ar' => 'nullable',
            'description_en' => 'required',
            'room_type_id' => 'required|exists:room_types,id',

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
