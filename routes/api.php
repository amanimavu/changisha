<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\EmailVerificationController;
use App\Http\Controllers\API\FundraiserController;
use App\Http\Controllers\API\UserController;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponse::class])->group(function () {
    // Authentication routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('verified');

    // Protected routes
    Route::middleware('auth:sanctum', 'verified')->group(function () {
        Route::resource('/users', UserController::class);
        Route::resource('/fundraisers', FundraiserController::class);
        Route::resource('/categories', CategoryController::class);
        Route::resource('/campaigns', CampaignController::class);
        Route::resource('/donations', DonationController::class);

        Route::withoutMiddleware('verified')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('api.verification.verify');
            Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
        });
    });
});
