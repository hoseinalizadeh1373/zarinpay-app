<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', [PaymentController::class, 'index'])->name('home');

Route::get('/purchase/{item}', [PaymentController::class, 'showForm'])->name('purchase.form');
Route::post('/purchase', [PaymentController::class, 'startPayment'])->name('purchase.start');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/thankyou', [PaymentController::class, 'thankyou'])->name('thankyou');

Route::middleware('admin.basic')->group(function(){
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex'])->name('admin.payments');
});