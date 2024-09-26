<?php

namespace App\Enums;

enum UserStatusEnum
{
    const NOTMAL = 1; //正常
    const PENDING_AUDIT = 2; //待审核
    const FORBIDDEN = 3; //被禁止
}
