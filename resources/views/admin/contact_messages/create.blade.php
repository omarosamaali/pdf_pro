@extends('layouts.admin')

@section('title', 'رد على رسالة التواصل')

@section('content')
<div class="content-header">
    <h2>رد على رسالة التواصل</h2>
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

    <form action="{{ route('admin.contact-messages.reply', $contactMessage->id) }}" method="POST" style="margin-top: 2rem;">
        @csrf
        <div style="margin-bottom: 1.5rem;">
            <h4 style="font-weight: bold; margin-bottom: 0.5rem; color: #333;">الرد</h4>
            <textarea name="reply" rows="5" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>
        <button type="submit" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer;">إرسال الرد</button>
    </form>

    <a href="{{ route('admin.contact-messages.index') }}" style="background-color: #95a5a6; color: white; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 10px; transition: background-color 0.3s ease; margin-top: 1rem; display: inline-block;">العودة للقائمة</a>
</div>
@endsection
