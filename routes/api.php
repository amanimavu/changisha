<?php

use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\FundraiserController;
use App\Http\Controllers\API\UserController;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponse::class])->group(function () {
    Route::resource('/users', UserController::class);

    Route::resource('/fundraisers', FundraiserController::class);

    Route::resource('/categories', CategoryController::class);

    Route::resource('/campaigns', CampaignController::class);
});
