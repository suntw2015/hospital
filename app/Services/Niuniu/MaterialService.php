<?php

namespace App\Services\Niuniu;

use App\Models\Niuniu\MaterialConfig;
use App\Services\BaseService;

class MaterialService extends BaseService
{
    public function __construct()
    {
        
    }

    public function getConfigList()
    {
        return MaterialConfig::where([
            'delete_status' => 0
        ])->get()->toArray();
    }

    public function getConfigMap()
    {
        $res = $this->getConfigList();
        return array_column($res, null, 'id');
    }
}