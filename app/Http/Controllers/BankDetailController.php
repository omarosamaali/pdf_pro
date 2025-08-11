<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    // Display the form to edit bank details
    public function edit()
    {
        $bankDetail = BankDetail::first();
        return view('admin.payments.bank_details', compact('bankDetail'));
    }

    // Handle the form submission to update bank details
    public function update(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        $bankDetail = BankDetail::firstOrNew(); // Find the first record or create a new one
        $bankDetail->fill($request->all());
        $bankDetail->save();

        return redirect()->back()->with('success', 'تم تحديث بيانات التحويل البنكي بنجاح.');
    }
}
