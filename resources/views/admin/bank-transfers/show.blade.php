@extends('layouts.admin')

@section('title', 'تفاصيل طلب التحويل')

@section('content')
<div class="content-header">
    <h2>تفاصيل طلب التحويل البنكي</h2>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">المستخدم</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $bankTransfer->user->name }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الباقة</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $bankTransfer->subscription->name_ar }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">المبلغ</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $bankTransfer->amount }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم المرسل</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $bankTransfer->sender_name }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">إيصال التحويل</h4>
        <img src="{{ asset('storage/' . $bankTransfer->receipt_path) }}" alt="إيصال التحويل" style="max-width: 100%; border-radius: 8px;">
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الحالة</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $bankTransfer->status }}</p>
    </div>

    @if ($bankTransfer->status === 'pending')
    <form action="{{ route('bank-transfers.update', $bankTransfer->id) }}" method="POST" style="display: flex; gap: 1rem; margin-top: 2rem;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="approved">
        <button type="submit" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer;">الموافقة</button>
    </form>
    <form action="{{ route('bank-transfers.update', $bankTransfer->id) }}" method="POST" style="display: flex; gap: 1rem; margin-top: 2rem;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="rejected">
        <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer;">الرفض</button>
    </form>
    @endif

    <a href="{{ route('bank-transfers.index') }}" style="background-color: #95a5a6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease; margin-top: 1rem; display: inline-block;">العودة للقائمة</a>
</div>
@endsection
