<?php

namespace App\Http\Controllers\NiuNiu;

use App\Exceptions\BizException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\MaterialConfig;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderList(Request $request)
    {
        $params = [];
    }

    public function create(CreateOrderRequest $request)
    {
        $params = $request->validated();
        return $this->success($params);
    }

    public function update(Request $request)
    {
        
    }
}