<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryStoreRequest extends FormRequest
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
            'name' => 'required|min:1|max:150|string',
            'description' => 'nullable|string|min:1|max:150',
            'categories_id' => 'required|integer|max:250',
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
