<?php
// routes/web.php — add this
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/deploy-migrate-{secret}', function ($secret) {
    if (!hash_equals((string) env('MIGRATE_SECRET'), (string) $secret)) abort(403);
    Artisan::call('migrate', ['--force' => true]);
    if (!\App\Models\User::where('email', 'admin@rental.com')->exists()) {
        Artisan::call('db:seed', ['--force' => true]);
    }
    return Artisan::output();
})->middleware('throttle:3,1'); // rate-limit it

