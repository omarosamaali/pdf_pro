<?php

namespace App\Http\Controllers;

use App\Models\BankTransfer;
use App\Models\User;
use Illuminate\Http\Request;

class BankTransferController extends Controller
{
    public function index()
    {
        $transfers = BankTransfer::with(['user', 'subscription'])->latest()->get();
        return view('admin.bank-transfers.index', compact('transfers'));
    }

    public function show(BankTransfer $bankTransfer)
    {
        $bankTransfer->load(['user', 'subscription']);
        return view('admin.bank-transfers.show', compact('bankTransfer'));
    }

    public function update(Request $request, BankTransfer $bankTransfer)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $bankTransfer->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $user = $bankTransfer->user;
            $subscription = $bankTransfer->subscription;

            $user->update([
                'subscription_id' => $subscription->id,
                'subscription_start_date' => now(),
                'subscription_end_date' => now()->addDays($subscription->duration_in_days),
            ]);
        }

        return redirect()->route('bank-transfers.index')->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }
}
