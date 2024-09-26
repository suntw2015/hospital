<?php

namespace App\Enums;

enum ResultCodeEnum
{
    const SUCCESS_CODE = 2000;
    const SUCCESS_PHRASE = '操作成功';

    const UNAUTHENTICATED_CODE = 4001;
    const UNAUTHENTICATED_PHRASE = '暂未登录或token已经过期';

    const PERMISSION_DENIED_CODE = 4003;
    const PERMISSION_DENIED_PHRASE = '没有相关权限';

    const PARAM_ILLEGAL_CODE = 4004;
    const PARAM_ILLEGAL_PHRASE = '参数校验失败';

    const BUSINESS_ERROR_CODE = 4005;
    const BUSINESS_ERROR_PHRASE = '业务异常';

    const BUSINESS_TOO_MANY_REQUEST_CODE = 4029;
    const BUSINESS_TOO_MANY_REQUEST_CODE_PHRASE = '请求频繁';

    const SERVER_ERROR_CODE = 5000;
    const SERVER_ERROR_PHRASE = '操作失败,服务端异常';

    const INVOKE_ERROR_CODE = 6000;
    const INVOKE_ERROR_PHRASE = '调用其他服务接口错误';

    const OTHER_ERROR_CODE = 7000;
    const OTHER_ERROR_PHRASE = '其他错误';

    const ERROR_CODE_TO_PHRASE_MAP = [
        self::SUCCESS_CODE           => self::SUCCESS_PHRASE,
        self::UNAUTHENTICATED_CODE   => self::UNAUTHENTICATED_PHRASE,
        self::PERMISSION_DENIED_CODE => self::PERMISSION_DENIED_PHRASE,
        self::PARAM_ILLEGAL_CODE     => self::PARAM_ILLEGAL_PHRASE,
        self::SERVER_ERROR_CODE      => self::SERVER_ERROR_PHRASE,
        self::INVOKE_ERROR_CODE      => self::INVOKE_ERROR_PHRASE,
        self::OTHER_ERROR_CODE       => self::OTHER_ERROR_PHRASE,
        self::BUSINESS_ERROR_CODE    => self::BUSINESS_ERROR_PHRASE
    ];
}
