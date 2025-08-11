@extends('layouts.admin')

@section('title', 'إدارة الباقات')

@section('content')
<div class="content-header">
    <h2>إدارة الباقات</h2>
    <p>مرحباً بك في لوحة تحكم PDF Pro - إدارة شاملة لجميع الباقات</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
    <h3 style="color: #333; margin: 0 0 1rem 0; font-size: 1.5rem;">تحديد عدد المحاولات المجانية اليومية</h3>
    <form action="{{ route('dashboard.settings.save') }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end;">

        @csrf
        <div style="flex-grow: 1;">
            <label for="daily_free_limit" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">عدد العمليات اليومية المجانية للمستخدم العادي والزائر</label>
            <input type="number" name="daily_free_limit" id="daily_free_limit" value="{{ $dailyFreeLimit->value ?? 3 }}" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;" required>
        </div>
        <div>
            <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="color: #333; margin: 0; font-size: 1.5rem;">جميع الباقات</h3>
    <a href="{{ route('subscriptions.create') }}" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; text-decoration: none; transition: background-color 0.3s ease;">
        + إضافة باقة جديدة
    </a>
</div>

<table style="width: 100%; border-collapse: collapse;">
    <thead style="background-color: #f4f7fa; text-align: right;">
        <tr>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">الاسم (العربي) </th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">السعر</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">العمليات اليومية</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">المدة (يوم)</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd; text-align: center;">الإجراءات</th>
        </tr>
    </thead>
    <tbody style="background: white;">
        @foreach ($subscriptions as $subscription)
        <tr>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $subscription->name_ar }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ number_format($subscription->price, 2) }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $subscription->daily_operations_limit ?? 'لا يوجد' }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $subscription->duration_in_days }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee; text-align: center;">
                <a href="{{ route('subscriptions.show', $subscription->id) }}" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none;">عرض</a>
                <a href="{{ route('subscriptions.edit', $subscription->id) }}" style="background-color: #f39c12; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none;">تعديل</a>
                <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه الباقة؟')">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
