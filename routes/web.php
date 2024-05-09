<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Livewire\Stockspage;
use App\Livewire\Home;
use App\Livewire\Portfolio;
use App\Livewire\StockDetails;

// Authentication routes (presuming they are handled via included routes)
require __DIR__.'/auth.php';

Route::get('/', Home::class)->name('/');
Route::get('/stockspage', Stockspage::class)->name('stockspage');
Route::get('/portfolio', Portfolio::class)->name('porfolio');
Route::view('/profile', 'profilepage')->middleware(['auth'])->name('profile');

Route::get('/stocks/{stockId}', StockDetails::class)->name('stockdetails');

// Stock routes
Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks', [StockController::class, 'store']);
Route::put('/stocks/{id}', [StockController::class, 'update']);

Route::middleware('auth:api')->group(function () {
    // Transaction routes
    Route::post('/transactions/buy', [TransactionController::class, 'buy']);
    Route::post('/transactions/sell', [TransactionController::class, 'sell']);
});
