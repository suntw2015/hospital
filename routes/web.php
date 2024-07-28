<?php

use App\Admin\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::get('/', [CustomerController::class, 'index']);