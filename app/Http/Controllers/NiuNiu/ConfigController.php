<?php

namespace App\Http\Controllers\NiuNiu;

use App\Enums\NiuniuConfigEnum;
use App\Http\Controllers\Controller;
use App\Models\Niuniu\MaterialConfig;
use App\Models\Niuniu\NiuniuConfig;

class ConfigController extends Controller
{

    public function getAll()
    {
        $configs = NiuniuConfig::where([
            'delete_status' => 0,
        ])->get();

        $doctors = [];
        $follows = [];
        $hospitals = [];
        $departments = [];
        
        foreach($configs as $config) {
            switch ($config->type) {
                case NiuniuConfigEnum::TYPE_DOCTOR:
                    $doctors[] = $config->value;
                    break;
                case NiuniuConfigEnum::TYPE_FOLLOW_USER:
                    $follows[] = $config->value;
                    break;
                case NiuniuConfigEnum::TYPE_HOSPITAL:
                    $hospitals[] = $config->value;
                    break;
                case NiuniuConfigEnum::TYPE_DEPARTMENT:
                    $departments[] = $config->value;
                    break;
                default:
                    break;
            }
        }

        $res = [
            'doctors' => $doctors,
            'follows' => $follows,
            'hospitals' => $hospitals,
            'departments' => $departments
        ];

        return $this->success($res);
    }

    public function getMaterialConfig()
    {
        $data = MaterialConfig::where([
            'delete_status' => 0
        ])->get()->toArray();
        return $this->success($data);
    }
}