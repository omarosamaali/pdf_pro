@extends('layouts.admin')

@section('title', 'عرض الباقة')

@section('content')
<div class="content-header">
    <h2>تفاصيل الباقة: {{ $subscription->name_ar }}</h2>
    <p>معلومات مفصلة عن الباقة.</p>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;"> اسم الباقة (العربي)</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $subscription->name_ar }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;"> اسم الباقة (الأنجليزي)</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $subscription->name_en }}</p>
    </div>


<div style="margin-bottom: 1.5rem;">
    <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الميزات (العربي)</h4>
    <ul style="list-style-type: disc; padding-right: 20px;">
        @php
        $features_ar = json_decode($subscription->features_ar);
        @endphp
        @if(is_array($features_ar))
        @foreach ($features_ar as $feature)
        <li>{{ $feature }}</li>
        @endforeach
        @endif
    </ul>
</div>

<div style="margin-bottom: 1.5rem;">
    <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الميزات (الإنجليزي)</h4>
    <ul style="list-style-type: disc; padding-right: 20px;">
        @php
        $features_en = json_decode($subscription->features_en);
        @endphp
        @if(is_array($features_en))
        @foreach ($features_en as $feature)
        <li>{{ $feature }}</li>
        @endforeach
        @endif
    </ul>
</div>


    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">السعر</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ number_format($subscription->price, 2) }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">عدد العمليات اليومية</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $subscription->daily_operations_limit ?? 'لا يوجد' }}</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">مدة الاشتراك</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $subscription->duration_in_days }} يوم</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
        <a href="{{ route('subscriptions.edit', $subscription->id) }}" style="background-color: #3498db; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease;">تعديل</a>
        <a href="{{ route('subscriptions.index') }}" style="background-color: #95a5a6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease;">العودة للقائمة</a>
    </div>
</div>
@endsection
