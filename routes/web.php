<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserpageController;
use Illuminate\Support\Facades\Route;

// Games
Route::get('/game/dd/{gameId}', [GameController::class, 'dumpdata'])->name('game.dumpdata');
Route::get('/game', [GameController::class, 'index'])->name('game.index');
Route::get('/game/search', [GameController::class, 'index'])->name('game.index');
Route::get('/game/search_results', [GameController::class, 'search'])->name('game.search_results');
//Route::get('/game/all_slugs', [GameController::class, 'slugs'])->name('game.slugs');
Route::get('/game/by_igdb/{id}', [GameController::class, 'showByIGDB'])->name('game.show_by_igdb');
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.show');

// User public information
Route::get('/user', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/user/search', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/user/search_results', [ProfileController::class, 'search'])->name('profile.search_results');
Route::get('/user/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Profile and Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('auth')->group(function () {
    // Profile actions
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Userpage
    Route::patch('/userpage', [UserpageController::class, 'update'])->name('userpage.update');
    Route::post('/userpage', [UserpageController::class, 'uploadProfilePicture'])->name('userpage.upload_profile_picture');

    // Handle different user actions for games
    Route::patch('/game/{gameId}/{action}', [GameController::class, 'action'])->name('game.action');
});

require __DIR__.'/auth.php';
