<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Model;

class NiuniuConfig extends Model
{
    protected $table = 'niuniu_configs';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'key',
        'value',
        'status',
        'delete_status',
    ];
}
