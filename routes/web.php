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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BannerController;
use App\Models\Banner;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\TelrController;

Route::get('/test-telr-credentials', function() {
    $storeId = config('telr.store_id');
    $authKey = config('telr.auth_key');
    
    $payload = [
        'ivp_method' => 'create',
        'ivp_store' => $storeId,
        'ivp_authkey' => $authKey,
        'ivp_test' => '1',
        'ivp_amount' => '1.00',
        'ivp_currency' => 'SAR',
        'ivp_cart' => 'test-' . time(),
        'ivp_desc' => 'Test credentials',
        'return_auth' => url('/telr/return_auth'),
        'return_can' => url('/telr/return_can'),
        'return_decl' => url('/telr/return_decl'),
    ];
    
    $response = Http::asForm()->post('https://secure.telr.com/gateway/order.json', $payload);
    
    return [
        'status' => $response->status(),
        'response' => $response->json(),
        'credentials_used' => [
            'store_id' => $storeId,
            'auth_key_present' => !empty($authKey)
        ]
    ];
});

Route::prefix('telr')->name('telr.')->group(function () {
    Route::get('pay', [TelrController::class, 'pay']);
    Route::post('pay', [TelrController::class, 'pay'])->name('pay');
    Route::post('paypal/pay', [PaypalController::class, 'pay'])->name('paypal.pay');
    Route::any('return_auth', [TelrController::class, 'handleReturn'])->name('return_auth');
    Route::any('return_can', [TelrController::class, 'handleReturn'])->name('return_can');
    Route::any('return_decl', [TelrController::class, 'handleReturn'])->name('return_decl');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/payments/settings', [PaymentSettingController::class, 'edit'])->name('admin.payments.settings.edit');
    Route::put('/admin/payments/settings', [PaymentSettingController::class, 'update'])->name('admin.payments.settings.update');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/page-contents', [PageContentController::class, 'index'])->name('admin.page_contents.index');
    Route::post('/admin/page-contents', [PageContentController::class, 'update'])->name('admin.page_contents.update');
});

Route::middleware(['auth', 'admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site_settings.index');
    Route::post('site-settings', [SiteSettingController::class, 'update'])->name('site_settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.admin');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/contact-messages', [ContactController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactController::class, 'show'])->name('admin.contact-messages.show');
    Route::get('/contact-messages/{contactMessage}/create', [ContactController::class, 'create'])->name('admin.contact-messages.create');
    Route::post('/contact-messages/{contactMessage}/reply', [ContactController::class, 'reply'])->name('admin.contact-messages.reply');
    Route::delete('/contact-messages/{contactMessage}', [ContactController::class, 'destroy'])->name('admin.contact-messages.destroy');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::middleware(['auth', 'admin'])->resource('bank-transfers', BankTransferController::class)
    ->only(['index', 'show', 'update'])
    ->names([
        'index' => 'bank-transfers.index',
        'show' => 'bank-transfers.show',
        'update' => 'bank-transfers.update',
    ]);

Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang.switch');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/admin/banners/save', [BannerController::class, 'save'])->name('banners.save');
    Route::get('/admin/banners/{id}/toggle', [BannerController::class, 'toggleStatus'])->name('banners.toggle');
    Route::get('/admin/banners/{id}/delete-file', [BannerController::class, 'deleteFile'])->name('banners.deleteFile');
});

Route::get('/api/banners', [BannerController::class, 'getBanners'])->name('api.banners');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/save-settings', [SettingController::class, 'saveSettings'])->name('dashboard.settings.save');
});

Route::post('/paypal/pay', [PayPalController::class, 'pay'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::post('/payment/bank-transfer', [PaymentController::class, 'submitBankTransfer'])->name('payment.bank_transfer.submit');

Route::get('/premium', [PremiumController::class, 'index'])->name(name: 'premium');

Route::get('/payment/{id}', [PaymentController::class, 'showPaymentPage'])->name('payment');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/bank-details', [BankDetailController::class, 'edit'])->name('payments.bank_details');
    Route::put('/bank-details', [BankDetailController::class, 'update'])->name('payments.bank_details.update');
});
Route::middleware(['auth', 'admin'])->resource('users', UserController::class);

// Route::get('payment', function () {
//     return view('payment');
// })->name('payment');

Route::get('/', function () {
    $banners = Banner::where('is_active', 1)
        ->whereNotIn('name', ['banner_4', 'banner_5', 'banner_6', 'banner_7'])
        ->get();

    return view('welcome', compact('banners'));
})->name('/');

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('privacy-policy', [PageContentController::class, 'showPrivacyPolicy'])->name('privacy-policy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', action: [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/history', function () {
    $user = auth()->user();
    return view('history', compact('user'));
})->name('history');

Auth::routes();

require __DIR__ . '/auth.php';
require __DIR__ . '/actions_routes.php';
