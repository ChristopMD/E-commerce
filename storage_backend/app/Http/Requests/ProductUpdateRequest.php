<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
            'name'            => ['nullable', 'string' , 'max:50'],
            'price'           => ['nullable', 'numeric', 'between:0,9999.99'],
            'img_url'         => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'brand'           => ['nullable', 'string' , 'max:50'],
            'description'     => ['nullable', 'string' , 'max:100']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => false,
            'status_code'=> 400,
            'message'=> 'Bad Request',
            'erros'=>$validator->errors()
        ];
        throw new HttpResponseException(response()->json($response,400));
    }
}
