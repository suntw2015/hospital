<?php

namespace App\Http\Controllers\NiuNiu;

use App\Exceptions\BizException;
use App\Exports\NiuniuOrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\Niuniu\OrderDetailRequest;
use App\Http\Requests\Niuniu\OrderExportRequest;
use App\Http\Requests\Niuniu\OrderListRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\MaterialConfig;
use App\Services\Niuniu\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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

    public function delete(DeleteOrderRequest $request)
    {
        $params = $request->validated();
        $this->orderService->delete($params['id']);
        return $this->success("");
    }

    public function export(OrderExportRequest $request)
    {
        $params = $request->validated();
        list($start, $end) = $this->orderService->getDateRange($params['range']);
        $userIds = [Auth::id()];
        $fileName = sprintf("%s-%s_%s.xlsx", $start, $end, time());
        return Excel::download(new NiuniuOrderExport($start, $end, $userIds), $fileName);
    }
}