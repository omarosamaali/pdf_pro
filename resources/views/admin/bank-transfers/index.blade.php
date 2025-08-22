@extends('layouts.admin')

@section('title', 'طلبات التحويل البنكي')

@section('content')
<div class="content-header">
    <h2>إدارة طلبات التحويل البنكي</h2>
    <p>قائمة بجميع طلبات الدفع عبر التحويل البنكي</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<table style="width: 100%; border-collapse: collapse;">
    <thead style="background-color: #f4f7fa; text-align: right;">
        <tr>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">المستخدم</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">الباقة</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">المبلغ</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">الحالة</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd; text-align: center;">الإجراءات</th>
        </tr>
    </thead>
    <tbody style="background: white;">
        @foreach ($transfers as $transfer)
        <tr>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $transfer->user->name }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $transfer->subscription->name_ar }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $transfer->amount }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $transfer->status }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee; text-align: center;">
                <a href="{{ route('bank-transfers.show', $transfer->id) }}" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none;">عرض</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
