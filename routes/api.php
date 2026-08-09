<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;
use App\Models\Rentals;
use App\Models\Payments;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    /*
    |--------------------------------------------------------------------------
    | Renter Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/my-payments', function (Request $request) {

        $rentalIds = Rentals::where('user_id', $request->user()->id)
            ->pluck('id');

        return Payments::with(['rental.user', 'rental.house'])
            ->whereIn('rental_id', $rentalIds)
            ->latest('due_date')
            ->get();
    });

    Route::get('/my-rentals', function (Request $request) {

        return Rentals::with('house')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Users
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user', [UserController::class, 'store']);
        Route::put('/user/{user}', [UserController::class, 'update']);
        Route::patch('/user/{user}/tools', [UserController::class, 'updatetools']);
        Route::delete('/user/{user}', [UserController::class, 'destroy']);

        // Houses
        Route::apiResource('house', HouseController::class);

        // Rentals
        Route::apiResource('rental', RentalController::class);

        // Payments
        Route::apiResource('payment', PaymentController::class);
    });
});
