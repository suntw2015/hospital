<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'niuniu_order';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'sex',
        'union_id',
        'hospital_name',
        'in_no',
        'operate_date',
        'doctors',
        'follows',
        'status',
        'total_price',
        'delete_status'
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(OrderMaterial::class);
    }
}
