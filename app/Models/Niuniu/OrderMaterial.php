<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMaterial extends Model
{
    protected $table = 'niuniu_order_material';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'material_id',
        'brand',
        'name',
        'type',
        'unit_price',
        'count',
        'total_price',
        'status',
        'create_user_id',
        'create_user_name'
    ];
}
