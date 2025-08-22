// resources/views/admin/site_settings/index.blade.php

@extends('layouts.admin')

@section('title', 'إدارة إعدادات الموقع')

@section('content')
<div class="content-header">
    <h2>إدارة إعدادات الموقع</h2>
    <p>مرحباً بك في لوحة تحكم الموقع - إدارة شاملة لجميع الإعدادات</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
    <h3 style="color: #333; margin: 0 0 1rem 0; font-size: 1.5rem;">تغيير أسماء الموقع</h3>
    <form action="{{ route('dashboard.site_settings.update') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="site_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">اسم الموقع الخارجي</label>
            <input type="text" name="site_name" id="site_name" value="{{ $siteSetting->site_name ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;" required>
            @error('site_name')
            <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="dashboard_name" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">اسم لوحة التحكم</label>
            <input type="text" name="dashboard_name" id="dashboard_name" value="{{ $siteSetting->dashboard_name ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;" required>
            @error('dashboard_name')
            <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection
