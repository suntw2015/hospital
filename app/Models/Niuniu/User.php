<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'niuniu';

    protected $table = 'niuniu_user';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'real_name',
        'avatar',
        'open_id',
        'union_id',
        'session_key',
        'token',
        'password',
        'status'
    ];
}
