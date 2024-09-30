<?php

namespace App\Exceptions;

use App\Enums\ResultCodeEnum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *不做日志记录的异常错误
     * @var array
     */
    protected $dontReport = [
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *认证异常时不被flashed的数据
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function __construct(public Exceptions $excepHandler)
    {
    }

    public function handle()
    {
        $this->excepHandler->dontReport($this->dontReport);
        $this->excepHandler->dontFlash($this->dontFlash);

        // 异常处理
        $this->excepHandler->render(function (Throwable $e) {
            //验证器异常统一处理
            $httpCode = 200;
            $msg = ResultCodeEnum::OTHER_ERROR_PHRASE;
            $statusCode = ResultCodeEnum::OTHER_ERROR_CODE;

            if ($e instanceof ValidationException) {
                $statusCode = ResultCodeEnum::PARAM_ILLEGAL_CODE;
                $msg = array_values($e->errors())[0][0];
            } else if ($e instanceof HttpException) {
                $msg = $e->getMessage();
                return response('', $e->getStatusCode());
            } else if ($e instanceof BizException) {
                Log::error($e->getMessage());
                $statusCode = $e->getCode();
                $msg = $e->getMessage();
            }

            //api返回json，web返回页面
            if ($this->isAjax()) {
                $return = [
                    'code' => $statusCode,
                    'msg' => $msg
                ];
                return response()->json($return,$httpCode);
            }else{
                return response()->view('error',['errCode'=>$statusCode,'msg'=>$msg]);
            }
        });
    }

    public function isAjax()
    {
        $request = request();
        return $request->ajax() || strpos($request->path(), "api") === 0;
    }
}