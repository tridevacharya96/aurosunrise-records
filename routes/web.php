<?php

/**
 * =====================================================
 * AUROSUNRISE RECORDS — Web Routes
 * =====================================================
 *
 * 📚 LEARNING NOTE: In a Single Page Application (SPA), Vue Router
 * handles ALL page routing in the browser. But when a user:
 *   - Directly visits a URL like /artists in their browser
 *   - Refreshes the page while on /artists
 *
 * ...the browser sends a GET /artists request to the Laravel server.
 * Laravel needs to return the Vue app HTML for ANY URL.
 *
 * The {any?} wildcard route is the solution:
 * ALL web requests → return app.blade.php → Vue Router takes over.
 *
 * IMPORTANT: This catch-all must be LAST so it doesn't swallow
 * other specific routes like file uploads, OAuth callbacks, etc.
 */

use Illuminate\Support\Facades\Route;

// Specific non-SPA routes (keep these above the catch-all)
Route::get('login', fn() => view('auth.login'))->name('login');

// Laravel Sanctum CSRF cookie endpoint (needed for API auth)
// This is handled automatically by Sanctum's built-in route

/*
|--------------------------------------------------------------------------
| SPA Catch-All Route
|--------------------------------------------------------------------------
| This route catches EVERY other URL and returns our Vue app.
| Vue Router then reads the URL and shows the correct page component.
*/
Route::get('/{any?}', function () {
    return view('app'); // resources/views/app.blade.php
})->where('any', '^(?!api|sanctum|login|logout).*$'); // Don't catch /api/* routes
