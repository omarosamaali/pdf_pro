{{-- resources/views/admin/page_contents/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'إدارة محتوى الصفحات')

@section('content')
<div class="content-header">
    <h2>إدارة محتوى الصفحات</h2>
    <p>قم بتحديث سياسة الخصوصية والشروط والأحكام الخاصة بموقعك.</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
    <form action="{{ route('admin.page_contents.update') }}" method="POST">
        @csrf

        {{-- قسم سياسة الخصوصية --}}
        <div style="margin-bottom: 2rem;">
            <h3 style="color: #333; margin: 0 0 1rem 0; font-size: 1.5rem;">سياسة الخصوصية</h3>
            <div style="margin-bottom: 1rem;">
                <label for="privacy_policy_ar" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">المحتوى بالعربية</label>
                <textarea name="privacy_policy_ar" id="privacy_policy_ar" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">{{ $content->privacy_policy_ar ?? '' }}</textarea>
                @error('privacy_policy_ar')
                <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="privacy_policy_en" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">المحتوى بالإنجليزية</label>
                <textarea name="privacy_policy_en" id="privacy_policy_en" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">{{ $content->privacy_policy_en ?? '' }}</textarea>
                @error('privacy_policy_en')
                <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr style="border-top: 1px solid #eee; margin-bottom: 2rem;">

        {{-- قسم الشروط والأحكام --}}
        <div style="margin-bottom: 2rem;">
            <h3 style="color: #333; margin: 0 0 1rem 0; font-size: 1.5rem;">الشروط والأحكام</h3>
            <div style="margin-bottom: 1rem;">
                <label for="terms_ar" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">المحتوى بالعربية</label>
                <textarea name="terms_ar" id="terms_ar" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">{{ $content->terms_ar ?? '' }}</textarea>
                @error('terms_ar')
                <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="terms_en" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">المحتوى بالإنجليزية</label>
                <textarea name="terms_en" id="terms_en" rows="10" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">{{ $content->terms_en ?? '' }}</textarea>
                @error('terms_en')
                <div style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>
@endsection
