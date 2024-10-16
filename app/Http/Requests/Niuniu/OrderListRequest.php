<?php

namespace App\Http\Requests\Niuniu;

use App\Http\Requests\BaseRequest;

class OrderListRequest extends BaseRequest
{
    public function messages(): array
    {
        return [
        ];
    }

    public function attributes(): array
    {
        return [
            
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
            'keyword' => 'nullable|string',
            'range' => 'nullable|string',
            'sort' => 'nullable|string'
        ];
    }
}
