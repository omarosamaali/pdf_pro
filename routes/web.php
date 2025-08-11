<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\SettingController; // تأكد من استيراد الكنترولر الجديد
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('subscriptions', SubscriptionController::class);

    // المسارات الخاصة بالإعدادات
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/save-settings', [SettingController::class, 'saveSettings'])->name('dashboard.settings.save');
});

Route::post('/paypal/pay', [PayPalController::class, 'pay'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::post('/payment/bank-transfer', [PaymentController::class, 'submitBankTransfer'])->name('payment.bank_transfer.submit');

Route::get('/premium', [PremiumController::class, 'index'])->name('premium');
Route::get('/payment/{id?}', [PaymentController::class, 'show'])->name('payment');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');



Route::get('dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/bank-details', [BankDetailController::class, 'edit'])->name('payments.bank_details');
    Route::put('/bank-details', [BankDetailController::class, 'update'])->name('payments.bank_details.update');
});
Route::resource('users', UserController::class);
// Route::resource('subscriptions', SubscriptionController::class);


Route::get('payment', function () {
    return view('payment');
})->name('payment');

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Auth::routes();

require __DIR__ . '/auth.php';
require __DIR__ . '/actions_routes.php';
