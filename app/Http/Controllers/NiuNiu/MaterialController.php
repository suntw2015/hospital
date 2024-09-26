<?php

namespace App\Http\Controllers\NiuNiu;

use App\Http\Controllers\Controller;
use App\Models\MaterialConfig;

class MaterialController extends Controller
{
    public function getConfig()
    {
        $data = MaterialConfig::all()->toArray();
        return $this->success($data);
    }
}