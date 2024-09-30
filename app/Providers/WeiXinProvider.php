<?php

namespace App\Providers;

use App\Models\Niuniu\User;
use App\Services\Niuniu\UserService;
use App\Services\WeixinUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class WeiXinProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::viaRequest('weixin', function (Request $request) {
            $code = $request->code;
            $token = $request->header('token');
            $source = $request->header('source');
            $user = app(WeixinUserService::class)->auth($code, $token, $source);
            return $user;
        });
    }
}
