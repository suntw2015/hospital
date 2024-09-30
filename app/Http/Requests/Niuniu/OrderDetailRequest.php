<?php

namespace App\Http\Requests\Niuniu;

use App\Http\Requests\BaseRequest;

class OrderDetailRequest extends BaseRequest
{
    public function messages(): array
    {
        return [
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => '订单号'
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
            'id' => 'required|min:1'
        ];
    }
}
