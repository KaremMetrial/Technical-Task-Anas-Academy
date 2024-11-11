<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['log.requests', 'auth'])->group(function () {

    //=============================== Products===============================================
    Route::get('/products/expensive/{minPrice?}', [ProductController::class, 'getExpensiveProducts'])
        ->name('products.expensive');

    Route::resource('products', ProductController::class)->only(['index', 'show', 'store', 'destroy']);
    //=============================== Products===============================================

    //=============================== Payments===============================================
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/', [PaymentController::class, 'showForm'])->name('show');
        Route::post('/process', [PaymentController::class, 'processPayment'])->name('process');
        Route::get('/success', [PaymentController::class, 'success'])->name('success');
        Route::get('/error', [PaymentController::class, 'error'])->name('error');
    });
    //=============================== Payments===============================================

    //=============================== Stripe webhook ===============================================
    Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);
    //=============================== Stripe webhook ===============================================

});

require __DIR__ . '/auth.php';
