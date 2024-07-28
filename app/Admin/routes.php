<?php

use App\Admin\Controllers\CustomerController;
use App\Admin\Controllers\DataController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->resource("customer", CustomerController::class);
    $router->resource("data", DataController::class);
});
