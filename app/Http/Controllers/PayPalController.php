<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function pay(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '100.00', // قيمة الاشتراك
                ],
            ]],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        $order = $provider->createOrder($data);

        if (isset($order['links'])) {
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return redirect()->route('payment.page')->with('error', 'Something went wrong.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // هنا تكتب الكود الخاص بتأكيد الاشتراك في قاعدة البيانات
            return redirect()->route('dashboard')->with('success', 'Payment was successful!');
        }

        return redirect()->route('payment.page')->with('error', 'Payment failed.');
    }

    public function cancel()
    {
        return redirect()->route('payment.page')->with('error', 'Payment was cancelled.');
    }
}
