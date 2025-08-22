<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class TelrController extends Controller
{
    public function pay(Request $request)
    {
        $subscription = Subscription::find($request->input('subscription_id'));
        if (!$subscription) {
            return back()->with('error', 'الاشتراك غير موجود.');
        }

        // حل مؤقت: تسجيل المحاولة والتوجيه لصفحة محاكاة
        Log::info('تم محاولة الدفع مؤقتاً', [
            'subscription_id' => $subscription->id,
            'amount' => $subscription->price,
            'user_id' => auth()->id(),
            'ip' => $request->ip()
        ]);

        // توجيه لصفحة محاكاة الدفع
        return redirect()->route('temp.payment.simulator', ['subscription_id' => $subscription->id]);
    }

    public function handleReturn(Request $request)
    {
        Log::info('عودة من بوابة الدفع', $request->all());

        $status = $request->input('status', 'A'); // افتراض النجاح مؤقتاً

        switch (strtoupper($status)) {
            case 'A':
                return redirect()->route('home')->with('success', 'تم الدفع بنجاح! تم تفعيل اشتراكك.');
            case 'C':
                return redirect()->route('payment.page')->with('error', 'تم إلغاء عملية الدفع.');
            case 'D':
                return redirect()->route('payment.page')->with('error', 'تم رفض عملية الدفع.');
            default:
                return redirect()->route('payment.page')->with('error', 'حالة الدفع غير معروفة.');
        }
    }

    /**
     * صفحة محاكاة الدفع المؤقتة
     */
    public function tempPaymentSimulator(Request $request)
    {
        $subscriptionId = $request->input('subscription_id');
        $subscription = Subscription::find($subscriptionId);

        if (!$subscription) {
            return redirect()->route('home')->with('error', 'الاشتراك غير موجود.');
        }

        return view('temp-payment-simulator', compact('subscription'));
    }

    /**
     * معالجة محاكاة الدفع
     */
    public function processTempPayment(Request $request)
    {
        $action = $request->input('action');
        $subscriptionId = $request->input('subscription_id');

        Log::info('محاكاة الدفع', [
            'action' => $action,
            'subscription_id' => $subscriptionId
        ]);

        switch ($action) {
            case 'success':
                // هنا يمكنك إضافة لوجيك تفعيل الاشتراك
                return redirect()->route('home')->with('success', 'تم الدفع بنجاح! (وضع تجريبي)');
            case 'cancel':
                return redirect()->route('payment.page')->with('error', 'تم إلغاء عملية الدفع.');
            case 'decline':
                return redirect()->route('payment.page')->with('error', 'تم رفض عملية الدفع.');
            default:
                return redirect()->route('payment.page')->with('error', 'عملية غير معروفة.');
        }
    }
}
