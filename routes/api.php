<?php

/**
 * =====================================================
 * AUROSUNRISE RECORDS — API Routes
 * =====================================================
 *
 * 📚 LEARNING NOTE: In a Laravel + Vue SPA, you have TWO route files:
 *
 * 1. routes/web.php  → Returns the Blade view that mounts Vue
 * 2. routes/api.php  → Returns JSON data for Vue components to consume
 *
 * All routes in this file are automatically prefixed with /api/
 * e.g. Route::get('artists', ...) → accessed as GET /api/artists
 *
 * Vue components call these routes using fetch() or axios.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (no authentication required)
|--------------------------------------------------------------------------
*/

// Artists
Route::get('artists', [ArtistController::class, 'index']);
Route::get('artists/{slug}', [ArtistController::class, 'show']);

// Albums
Route::get('albums', [AlbumController::class, 'index']);
Route::get('albums/featured', [AlbumController::class, 'featured']);
Route::get('albums/{slug}', [AlbumController::class, 'show']);

// Tracks
Route::get('tracks', [TrackController::class, 'index']);
Route::get('tracks/latest', [TrackController::class, 'latest']);
Route::get('tracks/{id}/stream-url', [TrackController::class, 'streamUrl']);

// Events
Route::get('events', [EventController::class, 'index']);
Route::get('events/upcoming', [EventController::class, 'upcoming']);
Route::get('events/{id}', [EventController::class, 'show']);

// Shop
Route::get('products', [ShopController::class, 'index']);
Route::get('products/{id}', [ShopController::class, 'show']);
Route::get('products/categories', [ShopController::class, 'categories']);

// Blog
Route::get('posts', [BlogController::class, 'index']);
Route::get('posts/{slug}', [BlogController::class, 'show']);
Route::get('posts/featured', [BlogController::class, 'featured']);

// Contact
Route::post('contact', [ContactController::class, 'send']);

// Newsletter
Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe']);

// Auth
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Protected Routes (require Sanctum token auth)
|--------------------------------------------------------------------------
| 📚 LEARNING NOTE: Route::middleware('auth:sanctum') wraps routes
| that require the user to be logged in. If no valid token is sent,
| Laravel returns 401 Unauthorized.
|
| The group() method lets you apply middleware to multiple routes at once.
*/

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);

    // Cart (server-side cart for logged-in users)
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/items', [CartController::class, 'addItem']);
    Route::put('cart/items/{id}', [CartController::class, 'updateItem']);
    Route::delete('cart/items/{id}', [CartController::class, 'removeItem']);
    Route::delete('cart', [CartController::class, 'clear']);

    // Checkout
    Route::post('checkout', [CartController::class, 'checkout']);

    // Event tickets
    Route::post('events/{id}/book', [EventController::class, 'bookTicket']);

    // User preferences
    Route::get('user/purchases', [AuthController::class, 'purchases']);
    Route::get('user/bookings', [AuthController::class, 'bookings']);
});
