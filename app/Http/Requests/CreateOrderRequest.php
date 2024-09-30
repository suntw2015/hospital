<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends BaseRequest
{
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'body.required' => 'A message is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '',
            'age'  => '',
            'sex' => '',
            'doctor' => '',
            'followUserName' => '',
            'material' => '',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'age'  => 'required|int|min:10',
            'sex' => 'required|int|in:1,2',
            'doctors' => 'required',
            'follows' => 'required',
            'materials' => 'required|array',
            'in_no'      => 'required|string',
            'operate_date'  => 'required|string',
        ];
    }
}
