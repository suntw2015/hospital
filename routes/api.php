<?php

use App\Http\Controllers\NiuNiu\MaterialController;
use App\Http\Controllers\NiuNiu\OrderController;
use App\Http\Middleware\NiuNiuMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([NiuNiuMiddleware::class])->prefix('niuniu')->group(function () {
    Route::get('/material_config', [MaterialController::class, 'getConfig']);
    Route::post('order/create', [OrderController::class, 'create']);
    Route::post('order/update', [OrderController::class, 'update']);
});