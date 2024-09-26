<?php

namespace App\Exceptions;

use App\Enums\ResultCodeEnum;
use Exception;

class AuthException extends Exception {
    
    protected $code = ResultCodeEnum::UNAUTHENTICATED_CODE;
}