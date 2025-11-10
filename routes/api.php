<?php

use App\Http\Controllers\API\FundraiserController;
use App\Http\Controllers\API\UserController;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

// ->middleware('auth:sanctum');
Route::middleware([ForceJsonResponse::class])->group(function () {
    Route::resource('/users', UserController::class);

    Route::resource('/fundraisers', FundraiserController::class);
});
