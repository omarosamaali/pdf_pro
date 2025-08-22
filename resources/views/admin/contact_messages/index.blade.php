@extends('layouts.admin')

@section('title', 'إدارة رسائل التواصل')

@section('content')
<div class="content-header">
    <h2>إدارة رسائل التواصل</h2>
    <p>قائمة بجميع رسائل التواصل المرسلة</p>
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
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">العنوان</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">وصف المشكلة</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd; text-align: center;">الإجراءات</th>
        </tr>
    </thead>
    <tbody style="background: white;">
        @foreach ($contactMessages as $message)
        <tr>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $message->user ? $message->user->name : 'غير معروف' }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $message->subject }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ Str::limit($message->description, 50) }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee; text-align: center;">
                <a href="{{ route('admin.contact-messages.show', $message->id) }}" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none;">عرض</a>
                <a href="{{ route('admin.contact-messages.create', $message->id) }}" style="background-color: #27ae60; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none; margin-right: 0.5rem;">رد</a>
                <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer;">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
