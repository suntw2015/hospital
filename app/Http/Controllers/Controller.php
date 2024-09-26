<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function success($data) {
        $data = [
            'code' => 0,
            'data' => $data
        ];

        return response($data);
    }
}
