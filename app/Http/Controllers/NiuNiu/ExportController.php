<?php

namespace App\Http\Controllers\NiuNiu;

use App\Exports\NiuniuOrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\ExportRequest;
use App\Http\Requests\Niuniu\OrderDetailRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\Niuniu\OrderService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private $orderService;

    public function __construct(
        OrderService $orderService,
    )
    {
        $this->orderService = $orderService;
    }
    public function export(ExportRequest $request)
    {
        $params = $request->validated();
        $token = $params['token'];
        if ($token != 'loveniuniu') {
            return $this->success("hello");
        }
        
        $userIds = [2];
        return Excel::download(new NiuniuOrderExport($params['month'], $params['start'], $params['end'], $userIds), 'users.xlsx');
    }
}