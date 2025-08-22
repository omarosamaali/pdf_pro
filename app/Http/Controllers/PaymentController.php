<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\BankDetail;
use App\Models\BankTransfer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentPage($id)
    {
        // Find the subscription by its ID. If not found, return an error.
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return redirect()->route('premium')->with('error', 'Subscription not found.');
        }

        // Get bank details if available
        $bankDetail = BankDetail::first();

        // Check for existing pending bank transfer
        $existingTransfer = null;
        if (auth()->check()) {
            $existingTransfer = BankTransfer::where('user_id', auth()->id())
                ->where('subscription_id', $id)
                ->whereIn('status', ['pending', 'processing'])
                ->first();
        }

        // Pass all required variables to the payment view
        return view('payment', compact('subscription', 'bankDetail', 'existingTransfer'));
    }

    public function show($id = null)
    {
        // If no ID is passed, show all subscriptions
        if (!$id) {
            $subscriptions = Subscription::where('is_active', 1)->orderBy('price')->get();
            $bankDetail = BankDetail::first();
            return view('payment', compact('subscriptions', 'bankDetail'));
        }

        // Find the subscription
        $subscription = Subscription::find($id);

        // Check if subscription exists
        if (!$subscription) {
            return redirect()->route('premium')->with('error', 'معرف الاشتراك غير صالح.');
        }

        // Activate subscription if not active (temporary for development)
        if (!$subscription->is_active) {
            $subscription->update(['is_active' => 1]);
            return redirect()->back()->with('success', 'تم تفعيل الاشتراك بنجاح!');
        }

        // Get bank details
        $bankDetail = BankDetail::first();

        // Check for existing pending bank transfer
        $existingTransfer = null;
        if (auth()->check()) {
            $existingTransfer = BankTransfer::where('user_id', auth()->id())
                ->where('subscription_id', $id)
                ->whereIn('status', ['pending', 'processing'])
                ->first();
        }

        return view('payment', compact('subscription', 'bankDetail', 'existingTransfer'));
    }

    public function index()
    {
        $subscriptions = Subscription::where('is_active', 1)->get();
        $bankDetail = BankDetail::first();

        // If there's only one subscription, pass it as $subscription as well
        $subscription = $subscriptions->first();

        return view('payment', compact('subscriptions', 'subscription', 'bankDetail'));
    }

    public function process(Request $request)
    {
        // Process payment
        $subscriptionId = $request->subscription_id;
        $subscription = Subscription::find($subscriptionId);

        if (!$subscription) {
            return back()->with('error', 'معرف الاشتراك غير صالح.');
        }

        // Rest of payment processing logic...

        return redirect()->route('paypal.pay')->with([
            'subscription' => $subscription
        ]);
    }

    public function submitBankTransfer(Request $request)
    {
        // Validate the request
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'sender_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'transfer_receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Check if user is authenticated
        if (!auth()->check()) {
            return back()->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        // Get the subscription
        $subscription = Subscription::find($request->subscription_id);

        if (!$subscription) {
            return back()->with('error', 'الاشتراك غير موجود.');
        }

        // Check for existing pending transfer
        $existingTransfer = BankTransfer::where('user_id', auth()->id())
            ->where('subscription_id', $request->subscription_id)
            ->whereIn('status', ['pending', 'processing'])
            ->first();

        if ($existingTransfer) {
            return back()->with('error', 'لديك طلب تحويل مصرفي معلق بالفعل لهذا الاشتراك.');
        }

        // Handle file upload
        $receiptPath = null;
        if ($request->hasFile('transfer_receipt')) {
            $receiptPath = $request->file('transfer_receipt')->store('bank_transfers', 'public');
        }

        // Create bank transfer record
        BankTransfer::create([
            'user_id' => auth()->id(),
            'subscription_id' => $request->subscription_id,
            'sender_name' => $request->sender_name,
            'amount' => $request->amount,
            'receipt_path' => $receiptPath,
            'status' => 'pending'
        ]);

        return back()->with('success', 'تم إرسال طلب التحويل البنكي بنجاح. سيتم مراجعته قريباً.');
    }
}
