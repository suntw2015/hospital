<?php

namespace App\Models\Niuniu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialConfig extends Model
{
    use HasFactory;

    protected $connection = 'niuniu';

    protected $table = 'material_config';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'name',
        'brand',
        'unit_price',
        'status'
    ];
}
