<?php

use App\Http\Controllers\Cart\Purchase\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('purchase', PurchaseController::class)->name('purchase');
    });
});
