<?php

namespace App\Enums;

enum SexEnum
{
    const MAN   = 1; //男
    const WOMEN = 2; //女

    const MAP = [
        self::MAN => '男',
        self::WOMEN => '女',
    ];

    public static function getText($code)
    {
        return self::MAP[$code] ?? '';
    }
}
