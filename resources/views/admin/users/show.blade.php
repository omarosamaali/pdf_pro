@extends('layouts.admin')

@section('title', 'عرض المستخدم')

@section('content')

<div class="content-header">
    <h2>تفاصيل المستخدم: {{ $user->name }}</h2>
    <p>معلومات مفصلة عن المستخدم وخصائصه.</p>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الاسم</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $user->name }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">البريد الإلكتروني</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $user->email }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الدور</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $user->role }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">العمليات اليومية المتاحة</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $user->daily_operations }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الاشتراك</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">
            @if($user->subscription_id)
            {{ $user->subscription->name }}
            @else
            لا يوجد
            @endif
        </p>
    </div>

    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
        <a href="{{ route('users.edit', $user->id) }}" style="background-color: #3498db; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease;">تعديل</a>
        <a href="{{ route('users.index') }}" style="background-color: #95a5a6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease;">العودة للقائمة</a>
    </div>
</div>

@endsection
