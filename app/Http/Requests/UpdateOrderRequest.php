<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'    => 'required|int|min:0',
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
