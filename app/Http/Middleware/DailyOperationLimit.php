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
        $limit = (int) \App\Models\Setting::where('key', 'daily_free_limit')->value('value') ?? 3;

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->subscription_id && $user->subscription) {
                $limit = $user->subscription->daily_operations_limit;
            }

            if (is_null($user->daily_reset_date) || Carbon::parse($user->daily_reset_date)->isBefore(Carbon::today())) {
                $user->daily_operations = 0;
                $user->daily_reset_date = Carbon::today();
                $user->save();
            }

            \Log::info("User {$user->id} operations: {$user->daily_operations}, Limit: {$limit}");

            if ($user->daily_operations >= $limit) {
                return response()->json([
                    'error' => "لقد تجاوزت الحد الأقصى المسموح من العمليات اليومية ({$limit}).",
                ], 429);
            }
        } else {
            $guestOperations = session('daily_operations', 0);
            $lastOperationDate = session('daily_reset_date');

            if (is_null($lastOperationDate) || Carbon::parse($lastOperationDate)->isBefore(Carbon::today())) {
                session(['daily_operations' => 0, 'daily_reset_date' => Carbon::today()]);
                $guestOperations = 0;
            }

            \Log::info("Guest operations: {$guestOperations}, Limit: {$limit}");

            if ($guestOperations >= $limit) {
                return response()->json([
                    'error' => "لقد تجاوزت الحد الأقصى المسموح للزوار ({$limit} عمليات يومياً). سجل دخولك أو اشترك للمتابعة.",
                ], 429);
            }
        }

        return $next($request);
    }
}
