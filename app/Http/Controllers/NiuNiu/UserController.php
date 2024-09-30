<?php

namespace App\Http\Controllers\NiuNiu;

use App\Http\Controllers\Controller;
use App\Services\WeixinUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $weixinUserService;

    public function __construct(
        WeixinUserService $weixinUserService
    )
    {
        $this->weixinUserService = $weixinUserService;
    }

    public function login(Request $request)
    {
        $code = $request->input('code');
        $token = $request->header('token');
        $source = $request->header('source');
        $result = $this->weixinUserService->login($code, $token, $source);
        return $this->success($result);
    }
}