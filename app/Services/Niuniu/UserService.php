<?php

namespace App\Services\Niuniu;

use App\Enums\ResultCodeEnum;
use App\Enums\UserStatusEnum;
use App\Exceptions\AuthException;
use App\Exceptions\BizException;
use App\Models\Niuniu\User;
use App\Services\BaseService;
use App\Services\WeixinService;

class UserService extends BaseService
{
    private $weixinService;

    public function __construct(
        WeixinService $weixinService
    )
    {
        $this->weixinService = $weixinService;
    }

    public function login($wxCode)
    {
        $wxUser = $this->weixinService->codeToSession($wxCode);
        if (empty($wxUser['openid']) || empty($wxUser['session_id'])) {
            throw new BizException("openid sessionid为空");
        }

        $user = User::where('openid', $wxUser['openid'])->first();
        if (empty($user)) {
            $user = User::create([
                'open_id' => $wxUser['openid'],
                'union_id' => $wxUser['union_id'],
                'session_key' => $wxUser['session_key'],
                'token' => md5($user['openid']),
                'token_expire' => now() + 3600*24*365,
                'status' => UserStatusEnum::PENDING_AUDIT,
            ]);
        }
        if ($user->status == UserStatusEnum::PENDING_AUDIT) {
            throw new AuthException("暂无使用权限, 联系相关人审核通过", ResultCodeEnum::PERMISSION_DENIED_CODE);
        } else if ($user->status == UserStatusEnum::FORBIDDEN) {
            throw new AuthException("账号已被禁用", ResultCodeEnum::PERMISSION_DENIED_CODE);
        }
        if ($user->token_expire < now()) {
            $user->token_expire = now() + 3600*24*365;
            $user->save();
        }

        return $this->formatUser($user);
    }

    public function auth($token)
    {
        $user = User::where('token', $token)->first();
        if (empty($user)) {
            throw new AuthException("无效token");
        }
        if ($user->token_expire < now()) {
            throw new AuthException("登录已过期");
        }
        return $user;
    }

    private function formatUser($user)
    {
        return [
            'name'      => $user->name,
            'realName'  => $user->realName,
            'avatar'    => $user->avatar,
            'token'     => $user->token,
        ];
    }
}