<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('/users', UserController::class);
// ->middleware('auth:sanctum');
