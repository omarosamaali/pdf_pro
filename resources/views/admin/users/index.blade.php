@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
<div class="content-header">
    <h2>إدارة المستخدمين</h2>
    <p>مرحباً بك في لوحة تحكم PDF Pro - إدارة شاملة لجميع المستخدمين</p>
</div>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h3 style="color: #333; margin: 0; font-size: 1.5rem;">جميع المستخدمين</h3>
    <a href="{{ route('users.create') }}" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; text-decoration: none; transition: background-color 0.3s ease;">
        + إضافة مستخدم جديد
    </a>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<table style="width: 100%; border-collapse: collapse;">
    <thead style="background-color: #f4f7fa; text-align: right;">
        <tr>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">الاسم</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">البريد الإلكتروني</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">الدور</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd;">نوعية العضوية</th>
            <th style="padding: 1rem; border-bottom: 1px solid #ddd; text-align: center;">الإجراءات</th>
        </tr>
    </thead>
    <tbody style="background: white;">
        @foreach ($users as $user)
        <tr>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $user->name }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $user->email }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">{{ $user->role }}</td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee;">
                @if($user->subscription)
                {{ $user->subscription->name }}
                @else
                لا يوجد اشتراك
                @endif
            </td>
            <td style="padding: 1rem; border-bottom: 1px solid #eee; text-align: center;">
                <a href="{{ route('users.edit', $user->id) }}" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; text-decoration: none;">تعديل</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function handleResize() {
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile');
            } else {
                document.body.classList.remove('mobile');
            }
        }
        window.addEventListener('resize', handleResize);
        handleResize();
        document.documentElement.style.scrollBehavior = 'smooth';
    });

</script>
@endsection
