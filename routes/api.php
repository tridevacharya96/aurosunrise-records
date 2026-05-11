<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;

/*
|----------------------------------------------------------------------
| Public API Routes
|----------------------------------------------------------------------
*/
Route::post('auth/login',  [AuthController::class, 'login']);

// Public — read only
Route::get('artists',          [ArtistController::class, 'index']);
Route::get('artists/genres',   [ArtistController::class, 'genres']);
Route::get('artists/{slug}',   [ArtistController::class, 'show']);

/*
|----------------------------------------------------------------------
| Protected Admin Routes — require Sanctum token
|----------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me',      [AuthController::class, 'me']);

    // Admin — Artists CRUD
    Route::get('admin/artists',                     [AdminArtistController::class, 'index']);
    Route::post('admin/artists',                    [AdminArtistController::class, 'store']);
    Route::get('admin/artists/{artist}',            [AdminArtistController::class, 'show']);
    Route::post('admin/artists/{artist}',           [AdminArtistController::class, 'update']); // POST for file uploads
    Route::delete('admin/artists/{artist}',         [AdminArtistController::class, 'destroy']);
    Route::patch('admin/artists/{artist}/featured', [AdminArtistController::class, 'toggleFeatured']);

});
