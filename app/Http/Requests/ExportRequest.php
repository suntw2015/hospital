<?php

namespace App\Http\Requests;

class ExportRequest extends BaseRequest
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
            'start' => 'required|string',
            'end' => 'required|string',
            'month' => 'required|int',
            'token' => 'required|string'
        ];
    }
}
