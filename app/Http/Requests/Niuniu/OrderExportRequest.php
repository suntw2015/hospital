<?php

namespace App\Http\Requests\Niuniu;

use App\Http\Requests\BaseRequest;

class OrderExportRequest extends BaseRequest
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
            'range' => 'required|string',
        ];
    }
}
