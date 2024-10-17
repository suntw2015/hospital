<?php

use App\Http\Controllers\NiuNiu\ConfigController;
use App\Http\Controllers\NiuNiu\ExportController;
use App\Http\Controllers\NiuNiu\MaterialController;
use App\Http\Controllers\NiuNiu\OrderController;
use App\Http\Controllers\NiuNiu\UserController;
use App\Http\Middleware\NiuNiuMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:miniProgram')->prefix('niuniu')->group(function () {
    Route::get('config/all', [ConfigController::class, 'getAll']);
    Route::get('material/config', [ConfigController::class, 'getMaterialConfig']);
    Route::get('order/todayList', [OrderController::class, 'todayList']);
    Route::get('order/list', [OrderController::class, 'list']);
    Route::get('order/detail', [OrderController::class, 'detail']);
    Route::post('order/create', [OrderController::class, 'create']);
    Route::post('order/update', [OrderController::class, 'update']);
    Route::post('order/delete', [OrderController::class, 'delete']);
    Route::get('order/export', [OrderController::class, 'export']);
});

Route::post('/weixin/user/login', [UserController::class, 'login']);
Route::get('/niuniu-export', [ExportController::class, 'export']);