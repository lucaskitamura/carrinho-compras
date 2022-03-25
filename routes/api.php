<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\CartController;
use App\Http\Controllers\V1\SaleController;
use App\Http\Controllers\V1\CreditCardController;

Route::prefix('v1/catestore')->group(function () {
    Route::post('/credit-cards', [CreditCardController::class, 'store'])->name('credit-card.store');
    Route::post('/credit-cards/{id}', [CreditCardController::class, 'update'])->name('credit-card.update');
    Route::post('/credit-cards/{id}/delete', [CreditCardController::class, 'delete'])->name('credit-card.delete');

    Route::get('/cart/{userId}', [CartController::class, 'list'])->name('cart.list');

    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales', [SaleController::class, 'list'])->name('sales.list');
    Route::get('/sales/{userId}', [SaleController::class, 'listByUserId'])->name('sales.list-by-user-id');
});
