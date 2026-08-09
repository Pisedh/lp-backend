<?php


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');




Route::get('/deploy-migrate-{secret}', function ($secret) {
    if ($secret !== env('MIGRATE_SECRET')) abort(403);
    Artisan::call('migrate', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    return Artisan::output();
});
