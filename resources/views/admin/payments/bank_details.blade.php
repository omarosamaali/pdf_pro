@extends('layouts.admin')

@section('title', 'إعدادات التحويل البنكي')

@section('content')
<div class="content-header">
    <h2>إعدادات التحويل البنكي</h2>
    <p>قم بإدخال وتحديث تفاصيل الحساب البنكي التي ستظهر للمستخدمين.</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<div class="form-container" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <form action="{{ route('payments.bank_details.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label for="bank_name" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم البنك</label>
            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankDetail->bank_name ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="account_holder_name" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم صاحب الحساب</label>
            <input type="text" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', $bankDetail->account_holder_name ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="account_number" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">رقم الحساب</label>
            <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $bankDetail->account_number ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="iban" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">رقم الايبان (IBAN)</label>
            <input type="text" id="iban" name="iban" value="{{ old('iban', $bankDetail->iban ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">حفظ البيانات</button>
    </form>
</div>
@endsection
