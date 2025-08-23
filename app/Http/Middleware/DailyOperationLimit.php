<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class DailyOperationLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        // 🔥 الإصلاح هنا - تأكد من أن الحد الأدنى هو 10 مش 0
        $settingValue = \App\Models\Setting::where('key', 'daily_free_limit')->value('value');
        $limit = (int) $settingValue;

        // إذا القيمة 0 أو null، استخدم 10 كحد أدنى
        if ($limit <= 0) {
            $limit = 10;
            \Log::info("Daily limit was 0 or null, using default: 10", [
                'setting_value' => $settingValue,
                'used_default' => true
            ]);
        }

        if (Auth::check()) {
            $user = Auth::user();

            // If user has subscription, get subscription limit
            if ($user->subscription_id && $user->subscription) {
                $limit = $user->subscription->daily_operations_limit;
                \Log::info("User has subscription", [
                    'user_id' => $user->id,
                    'subscription_limit' => $limit
                ]);
            }

            // Reset daily operations if it's a new day
            $today = Carbon::today();
            $resetDate = $user->daily_reset_date ? Carbon::parse($user->daily_reset_date) : null;

            if (is_null($resetDate) || $resetDate->isBefore($today)) {
                \Log::info("Resetting daily operations for user", [
                    'user_id' => $user->id,
                    'old_operations' => $user->daily_operations,
                    'new_reset_date' => $today->toDateString()
                ]);

                $user->daily_operations = 0;
                $user->daily_reset_date = $today;
                $user->save();
            }

            \Log::info("User daily operations check", [
                'user_id' => $user->id,
                'current_operations' => $user->daily_operations,
                'limit' => $limit,
                'can_proceed' => $user->daily_operations < $limit
            ]);

            if ($user->daily_operations >= $limit) {
                return response()->json([
                    'error' => "لقد تجاوزت الحد الأقصى المسموح من العمليات اليومية ({$limit}). العمليات المستخدمة: {$user->daily_operations}"
                ], 429);
            }
        } else {
            // Guest user logic
            $guestOperations = session('daily_operations', 0);
            $lastOperationDate = session('daily_reset_date');
            $today = Carbon::today();

            // Reset guest operations if it's a new day
            if (is_null($lastOperationDate) || Carbon::parse($lastOperationDate)->isBefore($today)) {
                session(['daily_operations' => 0, 'daily_reset_date' => $today->toDateString()]);
                $guestOperations = 0;
            }

            \Log::info("Guest daily operations check", [
                'current_operations' => $guestOperations,
                'limit' => $limit,
                'can_proceed' => $guestOperations < $limit
            ]);

            if ($guestOperations >= $limit) {
                return response()->json([
                    'error' => "لقد تجاوزت الحد الأقصى المسموح للزوار ({$limit} عمليات يومياً). العمليات المستخدمة: {$guestOperations}"
                ], 429);
            }
        }

        return $next($request);
    }
}
