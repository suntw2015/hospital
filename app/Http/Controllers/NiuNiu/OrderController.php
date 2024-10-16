<?php

namespace App\Http\Controllers\NiuNiu;

use App\Exceptions\BizException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\Niuniu\OrderDetailRequest;
use App\Http\Requests\Niuniu\OrderListRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\MaterialConfig;
use App\Services\Niuniu\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(
        OrderService $orderService
    )
    {
        $this->orderService = $orderService;
    }
    public function todayList(Request $request)
    {
        $res = $this->orderService->todayList();
        return $this->success($res);
    }

    public function list(OrderListRequest $request)
    {
        $params = $request->validated();
        $res = $this->orderService->list($params);
        return $this->success($res);
    }

    public function detail(OrderDetailRequest $request)
    {
        $params = $request->validated();
        $res = $this->orderService->detail($params['id']);
        return $this->success($res);
    }

    public function create(CreateOrderRequest $request)
    {
        $params = $request->validated();
        $res= $this->orderService->create($params);
        return $this->success($res);
    }

    public function update(UpdateOrderRequest $request)
    {
        $params = $request->validated();
        $res = $this->orderService->update($params);
        return $this->success($res);
    }
}