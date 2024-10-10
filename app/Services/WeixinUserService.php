<?php

namespace App\Services;

use App\Enums\CommonEnum;
use App\Enums\ResultCodeEnum;
use App\Enums\UserStatusEnum;
use App\Exceptions\AuthException;
use App\Exceptions\BizException;
use App\Models\Niuniu\User;
use App\Services\BaseService;
use App\Services\WeixinService;

class WeixinUserService extends BaseService
{
    private $weixinService;

    public function __construct(
        WeixinService $weixinService
    )
    {
        $this->weixinService = $weixinService;
    }

    public function login($wxCode, $token, $source)
    {
        $user = $this->auth($wxCode, $token, $source);
        return $this->formatUser($user);
    }

    private function generateToken($appId)
    {
        return md5($appId.now());
    }

    public function auth($wxCode, $token, $source)
    {
        if (empty($wxCode) && empty($token)) {
            throw new BizException("code和token不能同时为空", ResultCodeEnum::UNAUTHENTICATED_CODE);
        }
        if (!empty($token)) {
            $user = User::where([
                'token' => $token,
                'source' => $source,
                'delete_status' => CommonEnum::NOTMAL
            ])->first();
            if (empty($user)) {
                throw new BizException("无效token", ResultCodeEnum::UNAUTHENTICATED_CODE);
            }
        } else {
            $wxUser = $this->weixinService->codeToSession($wxCode);
            if (empty($wxUser['openid'])) {
                throw new BizException("openid sessionid为空");
            }

            $user = User::where([
                'open_id' => $wxUser['openid'],
                'source'  => $source,
                'delete_status' => CommonEnum::NOTMAL
            ])->first();
            if (empty($user)) {
                $user = User::create([
                    'open_id' => $wxUser['openid'],
                    'source' => $source,
                    'token' => $this->generateToken($wxUser['openid']),
                    'token_expire' => time() + 3600*24*365,
                    'status' => UserStatusEnum::NOTMAL,
                ]);
            }
            //校验过期
            if ($user->token_expire < time()) {
                $user->token = $this->generateToken($user->app_id);
                $user->token_expire = time() + 3600*24*365;
                $user->save();
            }
        }
        if ($user->status == UserStatusEnum::PENDING_AUDIT) {
            throw new BizException("暂无使用权限, 联系相关人审核通过", ResultCodeEnum::AUTH_PENDING_AUDIT_CODE);
        } else if ($user->status == UserStatusEnum::FORBIDDEN) {
            throw new BizException("账号已被禁用", ResultCodeEnum::PERMISSION_DENIED_CODE);
        } else if ($user->token_expire < time()) {
            throw new BizException("登录已过期", ResultCodeEnum::UNAUTHENTICATED_CODE);
        }

        return $user;
    }

    private function formatUser($user)
    {
        return [
            'name'      => $user->name,
            'realName'  => $user->realName,
            'avatar'    => $user->avatar,
            'openId'     => $user->open_id,
            'token'     => $user->token,
        ];
    }
}