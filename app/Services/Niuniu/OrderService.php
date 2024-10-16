<?php

namespace App\Services\Niuniu;

use App\Enums\CommonEnum;
use App\Enums\ResultCodeEnum;
use App\Enums\SexEnum;
use App\Enums\UserStatusEnum;
use App\Exceptions\AuthException;
use App\Exceptions\BizException;
use App\Models\Niuniu\MaterialConfig;
use App\Models\Niuniu\Order;
use App\Models\Niuniu\OrderMaterial;
use App\Models\Niuniu\User;
use App\Services\BaseService;
use App\Services\WeixinService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    private $marerialService;

    public function __construct(
        MaterialService $marerialService
    )
    {
        $this->marerialService = $marerialService;
    }

    public function todayList()
    {
        $orderList = Order::where([
            'user_id'   => Auth::id(),
            'delete_status'    => CommonEnum::NOTMAL,
            'operate_date'  => Carbon::today()->format("Y-m-d")
        ])->with('materials')
        ->orderByDesc('operate_date')
        ->orderByDesc('id')
        ->get()->toArray();
        
        return $this->formatList($orderList);
    }

    public function list($params)
    {
        $conditions = [
            'user_id'   => Auth::id(),
            'delete_status'    => CommonEnum::NOTMAL,
        ];
        if (!empty($params['range'])) {
            list($start, $end) = $this->getDateRange($params['range']);
            $conditions[] = ['operate_date', '>=', $start];
            $conditions[] = ['operate_date', '<=', $end];
        }
        $query = Order::where($conditions);

        if (!empty($params['keyword'])) {
            $keyword = $params['keyword'];
            $query->where(function ($q) use ($keyword) {  
                $q->where('name', 'like', '%' . $keyword . '%')  
                      ->orWhere('remark', 'like', '%' . $keyword . '%');  
            });
        }

        $orderList = $query->with('materials')
        ->orderByDesc('operate_date')
        ->orderByDesc('id')
        ->get();
        
        return $this->formatList($orderList);
    }

    private function getDateRange($range)
    {
        $today = Carbon::now();
        $start = "";
        $end = "";

        if ($range == "today") {
            $start = $today->toDateString();
            $end = $today->toDateString();
        } else if ($range == "week") {
            $start = $today->startOfWeek(Carbon::MONDAY)->toDateString();
            $end = $today->startOfWeek(Carbon::SUNDAY)->toDateString();
        } else if ($range == "month") {
            $start = $today->startOfMonth()->toDateString();
            $end = $today->startOfMonth()->toDateString();
        }

        return [$start, $end];
    }

    public function detail($id)
    {
        $order = Order::where([
            'id'        => $id,
            'user_id'   => Auth::id(),
            'delete_status'    => CommonEnum::NOTMAL,
        ])->with('materials')->first();
        
        return $this->format($order);
    }

    public function create($params)
    {
        $order = Order::create([
            'name'          => $params['name'],
            'age'           => $params['age'],
            'sex'           => $params['sex'],
            'in_no'         => $params['in_no'],
            'operate_date'  => $params['operate_date'],
            'doctors'       => $params['doctors'],
            'follows'       => $params['follows'],
            'user_id'=> Auth::id(),
        ]);

        $totalPrice = 0;
        $marerialConfig = $this->marerialService->getConfigMap();
        foreach ($params['materials'] as $material) {
            if (!isset($marerialConfig[$material['material_id']])) {
                throw new BizException("商品已下架", ResultCodeEnum::BUSINESS_ERROR_CODE);
            }

            $config = $marerialConfig[$material['material_id']];
            $totalPrice += $config['unit_price'] * $material['count'];
            OrderMaterial::create([
                'order_id'      => $order->id,
                'material_id'   => $material['material_id'],
                'count'         => $material['count'],
                'brand'         => $config['brand'],
                'name'          => $config['name'],
                'unit_price'    => $config['unit_price'],
                'type' => $config['type'],
                'total_price'   => $config['unit_price'] * $material['count'],
                'model'        => $material['model'] ?? '',
                'user_id'=> Auth::id(),
            ]);
        }

        $order->total_price = $totalPrice;
        $order->save();
        return $order->id;
    }

    public function update($params)
    {
        $order = Order::find($params['id']);
        if (empty($order)) {
            throw new BizException("无效订单", ResultCodeEnum::BUSINESS_ERROR_CODE);
        }

        $totalPrice = 0;
        $marerialConfig = $this->marerialService->getConfigMap();
        OrderMaterial::where('order_id', $params['id'])->delete();
        
        foreach ($params['materials'] as $material) {
            if (!isset($marerialConfig[$material['material_id']])) {
                throw new BizException("商品已下架", ResultCodeEnum::BUSINESS_ERROR_CODE);
            }
            $config = $marerialConfig[$material['material_id']];
            $totalPrice += $config['unit_price'] * $material['count'];
            OrderMaterial::create([
                'order_id'      => $order->id,
                'material_id'   => $material['material_id'],
                'count'         => $material['count'],
                'brand'         => $config['brand'],
                'name'          => $config['name'],
                'unit_price'    => $config['unit_price'],
                'model'         => $material['model'] ?? '',
                'type' => $config['type'],
                'total_price'   => $config['unit_price'] * $material['count'],
            ]);
        }

        $order = Order::find($params['id']);
        $order->name = $params['name'];
        $order->sex = $params['sex'];
        $order->age = $params['age'];
        $order->in_no = $params['in_no'];
        $order->operate_date = $params['operate_date'];
        $order->doctors = $params['doctors'];
        $order->follows = $params['follows'];
        $order->total_price = $totalPrice;
        $order->save();


    }

    public function format($order)
    {
        return $this->formatList([$order])['list'][0];
    }

    public function formatList($orderList)
    {
        $res = [];
        $totalPrice = 0;
        foreach ($orderList as $order) {
            $totalPrice += $order['total_price'];
            $res[] = [
                'id'                    => $order['id'],
                'name'                  => $order['name'],
                'sex'                   => $order['sex'],
                'age'                   => $order['age'],
                'sexText'               => SexEnum::getText($order['sex']),
                'hospital_name'         => $order['hospital_name'],
                'in_no'                 => $order['in_no'],
                'operate_date'          => $order['operate_date'],
                'doctors'               => explode(",", $order['doctors']),
                'doctorsText'           => $order['doctors'],
                'follows'               => explode(",", $order['follows']),
                'followsText'           => $order['follows'],
                'total_price'           => $order['total_price'],
                'status'                => $order['status'],
                'ctime'                 => $order['ctime'],
                'materials'             => $order['materials']
            ];
        }
        return [
            'totalPrice' => $totalPrice,
            'list' => $res,
        ];
    }

    public function exportList($startDate, $endDate, $userIds, $type)
    {
        $orderList = Order::where([
            ['operate_date', '>=', $startDate],
            ['operate_date', '<=', $endDate],
            ['status', '=', CommonEnum::NOTMAL],
        ])->whereIn('user_id', $userIds)->with('materials')
        ->orderByDesc('operate_date')
        ->orderByDesc('id')
        ->get();
        
        $orders = $this->formatList($orderList)['list'];
        $result = [];
        $index = 1;
        foreach ($orders as $order) {
            foreach ($order['materials'] as $material) {
                if ($material['type'] == $type) {
                    $result[] = [
                        'index'     => $index++,
                        'operate_date'  => $order['operate_date'],
                        'name'          => $order['name'],
                        'in_no'         => $order['in_no'],
                        'sex'           => $order['sexText'],
                        'age'           => $order['age'],
                        'doctors'       => implode(",",$order['doctors']),
                        'material_name' => $material['name'],
                        'material_price'=> $material['total_price'],
                        'material_brand'=> $material['brand'],
                        'remark'        => '本院',
                        'ticket_price'  => '',
                        'follows'       => implode(",",$order['follows']),
                        'yeji'          => '',
                    ];
                }
            }
        }

        return $result;
    }
}