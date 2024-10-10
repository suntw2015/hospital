<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'wx_user';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'source',
        'real_name',
        'avatar',
        'open_id',
        'union_id',
        'token',
        'token_expire',
        'password',
        'status',
        'delete_status'
    ];
}
