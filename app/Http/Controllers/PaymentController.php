<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\BankDetail; // استدعاء الموديل الجديد
use App\Models\BankTransfer; // <-- Add this line


class PaymentController extends Controller
{
    public function submitBankTransfer(Request $request)
    {
        // 1. Validate the data, including the subscription_id
        $request->validate([
            'subscription_id' => 'required|numeric|exists:subscriptions,id', // Add this line
            'sender_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'transfer_receipt' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // 2. Store the receipt image
        $path = $request->file('transfer_receipt')->store('bank_receipts', 'public');

        // 3. Create a record in the database
        BankTransfer::create([
            'subscription_id' => $request->subscription_id,
            'user_id' => auth()->id(),
            'sender_name' => $request->sender_name,
            'amount' => $request->amount,
            'receipt_path' => $path,
            'status' => 'pending',
        ]);

        // 4. Return a success message and stay on the same page
        return back()->with('success', 'تم إرسال طلب التحويل بنجاح. سيتم مراجعته وتفعيل اشتراكك قريباً.');
    }

    public function show(Request $request, $id = null)
    {
        $id = $id ?? $request->query('id');
        if (!$id || !is_numeric($id)) {
            return redirect()->route('premium')->with('error', 'معرف الاشتراك غير صالح.');
        }
        $subscription = Subscription::findOrFail($id);
        $bankDetail = BankDetail::first(); // بما أنك بتخزن تفاصيل بنك واحد فقط

        return view('payment', compact('subscription', 'bankDetail'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|numeric'
        ]);
        $subscription = [
            'id' => $request->subscription_id,
            'name_ar' => 'الاشتراك الأول',
            'name_en' => 'First Subscription',
            'price' => 100,
            'duration_in_days' => 30
        ];
        return redirect('/dashboard')->with('success', 'تمت معالجة الدفع بنجاح!');
    }
}
