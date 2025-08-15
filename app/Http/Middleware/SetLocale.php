<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق من وجود locale في الـ session
        $locale = Session::get('locale');

        // إذا لم توجد، استخدم اللغة الافتراضية
        if (!$locale || !in_array($locale, ['en', 'ar'])) {
            $locale = 'ar'; // أو config('app.locale')
            Session::put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
