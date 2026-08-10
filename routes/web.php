<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Home route for Render
Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel API is running on Render 🚀',
        'status' => 'ok'
    ]);
});

// Run migrations manually after deploy
Route::get('/deploy-migrate-{secret}', function ($secret) {
    if (! hash_equals((string) env('MIGRATE_SECRET'), (string) $secret)) {
        abort(403);
    }

    Artisan::call('migrate', ['--force' => true]);

    if (! \App\Models\User::where('email', 'admin@rental.com')->exists()) {
        Artisan::call('db:seed', ['--force' => true]);
    }

    return nl2br(Artisan::output());
})->middleware('throttle:3,1');
