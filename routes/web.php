<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Livewire\Stockspage;
use app\Livewire\Test;

// Basic views

// Authentication routes (presuming they are handled via included routes)
require __DIR__.'/auth.php';

Route::get('/stockspage', Stockspage::class)->name('stockspage');

Route::view('/', 'homepage')->name('/');
Route::view('/portfolio', 'portfoliopage')->name('portfoliopage');
Route::view('/community', 'communitypage')->name('communitypage');
Route::view('/profile', 'profilepage')->middleware(['auth'])->name('profile');


// Grouped routes for better middleware management
Route::middleware('auth:api')->group(function () {
    // Stock routes
    Route::get('/stocks', [StockController::class, 'index']);
    Route::get('/stocks/{id}', [StockController::class, 'show'])->name('stocks.show');
    Route::post('/stocks', [StockController::class, 'store']);
    Route::put('/stocks/{id}', [StockController::class, 'update']);

    // Transaction routes
    Route::post('/transactions/buy', [TransactionController::class, 'buy']);
    Route::post('/transactions/sell', [TransactionController::class, 'sell']);
});
