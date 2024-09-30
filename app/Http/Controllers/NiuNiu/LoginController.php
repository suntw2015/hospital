<?php

namespace App\Http\Controllers\NiuNiu;

use App\Exceptions\BizException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\Niuniu\UserLoginRequest;
use App\Models\MaterialConfig;
use App\Services\WeixinUserService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $userService;

    protected $user;

    public function __construct(
        WeixinUserService $weixinUserService
    )
    {
        
    }
}