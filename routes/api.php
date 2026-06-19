<?php

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/users/{user}', [TestController::class, 'index']);
Route::get('/users', [TestController::class, 'fetchAll']);
