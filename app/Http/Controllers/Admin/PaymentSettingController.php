<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function edit()
    {
        $paymentSetting = PaymentSetting::firstOrNew();
        return view('admin.payments.payment_settings', compact('paymentSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'paypal_mode' => 'required|string|in:sandbox,live',
            'paypal_live_client_id' => 'required_if:paypal_mode,live|nullable|string',
            'paypal_live_client_secret' => 'required_if:paypal_mode,live|nullable|string',
        ]);

        $paymentSetting = PaymentSetting::firstOrNew();
        $paymentSetting->fill($request->all());
        $paymentSetting->save();

        return redirect()->back()->with('success', 'تم تحديث إعدادات الدفع بنجاح.');
    }
}
