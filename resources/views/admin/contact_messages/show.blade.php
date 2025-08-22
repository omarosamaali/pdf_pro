@extends('layouts.admin')

@section('title', 'تفاصيل رسالة التواصل')

@section('content')
<div class="content-header">
    <h2>تفاصيل رسالة التواصل</h2>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">المستخدم</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $contactMessage->user ? $contactMessage->user->name : 'غير معروف' }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">العنوان</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $contactMessage->subject }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">وصف المشكلة</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $contactMessage->description }}</p>
    </div>
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">تاريخ الإنشاء</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $contactMessage->created_at->format('Y-m-d H:i:s') }}</p>
    </div>
    @if ($contactMessage->reply)
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الرد</h4>
        <p style="margin: 0; color: #64748b; font-size: 1.1rem;">{{ $contactMessage->reply }}</p>
    </div>
    @endif

    <a href="{{ route('admin.contact-messages.create', $contactMessage->id) }}" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; text-decoration: none; margin-top: 1rem; display: inline-block;">رد على الرسالة</a>
    <a href="{{ route('admin.contact-messages.index') }}" style="background-color: #95a5a6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease; margin-top: 1rem; display: inline-block;">العودة للقائمة</a>
</div>
@endsection
