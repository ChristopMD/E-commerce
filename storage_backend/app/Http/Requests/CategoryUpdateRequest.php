<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:250'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status'=>'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'erros' => $validator->errors()
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }
}
