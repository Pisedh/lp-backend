<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/my-payments', function (Request $request) {
        $rentalIds = \App\Models\Rentals::where('user_id', $request->user()->id)->pluck('id');

        return \App\Models\Payments::with(['rental.user', 'rental.house'])
            ->whereIn('rental_id', $rentalIds)
            ->latest('due_date')
            ->get();
    });

    Route::get('/my-rentals', function (Request $request) {
        return \App\Models\Rentals::with('house')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
    });

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('user', UserController::class)->except(['show']);
        Route::patch('/user/{user}/tools', [UserController::class, 'updatetools']);

        Route::apiResource('house', HouseController::class);
        Route::apiResource('rental', RentalController::class);
        Route::apiResource('payment', PaymentController::class);
    });
});
