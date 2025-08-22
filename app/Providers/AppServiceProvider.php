<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\BankTransfer;
use App\Models\SiteSetting;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $siteName = SiteSetting::first()->site_name ?? 'اسم موقع افتراضي';
        View::share('siteName', $siteName);

        $adminName = SiteSetting::first()->dashboard_name ?? 'اسم لوحة التحكم';
        View::share('adminName', $adminName);

        View::composer('*', function ($view) {
            $bank_transfers = BankTransfer::where('user_id', auth()->id())->where('created_at', '>', now()->subDays(7))->where('status', 'pending')->count();
            $view->with('bank_transfers', $bank_transfers);
        });
    }
}
