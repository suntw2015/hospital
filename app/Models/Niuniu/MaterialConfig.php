<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialConfig extends Model
{
    protected $table = 'niuniu_material_config';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'name',
        'short_name',
        'brand',
        'unit_price',
        'status',
        'delete_status',
        'has_model',
        'has_batch',
    ];
}
