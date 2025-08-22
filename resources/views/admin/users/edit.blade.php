@extends('layouts.admin')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="content-header">
    <h2>تعديل المستخدم: {{ $user->name }}</h2>
    <p>قم بتحديث بيانات المستخدم ثم احفظ التغييرات.</p>
</div>

<div class="form-container" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">الاسم</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="role" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">الدور</label>
            <select id="role" name="role" class="form-control" style="text-align: center; width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدير</option>
            </select>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label for="subscription_id" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">نوعية العضوية</label>
            <select id="subscription_id" name="subscription_id" class="form-control" style="text-align: center; width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                <option value="">لا يوجد اشتراك</option>
                @foreach ($subscriptions as $subscription)
                <option value="{{ $subscription->id }}" {{ old('subscription_id', $user->subscription_id) == $subscription->id ? 'selected' : '' }}>{{ $subscription->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">تحديث البيانات</button>
    </form>
</div>
@endsection
