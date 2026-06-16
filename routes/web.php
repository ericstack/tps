<?php

use Illuminate\Support\Facades\Route;

// The Vue SPA owns all non-API routes. This single entrypoint renders the
// app shell; vue-router takes over client-side from there.
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!api).*$');
