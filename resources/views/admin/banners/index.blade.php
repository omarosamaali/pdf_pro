@extends('layouts.admin')

@section('title', 'إدارة البانرات')

@section('content')
<div class="content-header">
    <h2>إدارة البانرات</h2>
    <p>مرحباً بك في لوحة تحكم PDF Pro - إدارة شاملة للبانرات</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    <ul style="margin: 0; padding-right: 20px;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- قسم إدارة البانرات -->
<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;">
    <h3 style="color: #333; margin: 0 0 1.5rem 0; font-size: 1.5rem;">إدارة البانرات</h3>
    <p style="color: #666; margin-bottom: 2rem;">يمكنك رفع صور، فيديوهات، أو بانرات متحركة (GIF) - الحد الأقصى للملف 10 ميجابايت</p>

    <form action="{{ route('banners.save') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach($banners as $index => $banner)
        <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; background-color: #fafafa;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="color: #2c3e50; margin: 0; font-size: 1.2rem;">
                    @if($banner->name === 'banner_1')
                    البانر الأول
                    @elseif($banner->name === 'banner_2')
                    البانر الثاني
                    @elseif($banner->name === 'banner_3')
                    البانر الثالث
                    @elseif($banner->name === 'banner_4')
                    بانر صفحة التحويل في الأعلي
                    @elseif($banner->name === 'banner_5')
                    بانر صفحة التحويل اليمين
                    @elseif($banner->name === 'banner_6')
                    بانر صفحة التحويل اليسار
                    @elseif($banner->name === 'banner_7')
                    بانر صفحة التحويل الأسفل
                    @else
                    بانر غير معروف
                    @endif
                </h4>

                <!-- Toggle Status -->
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <span style="font-size: 0.9rem; color: {{ $banner->is_active ? '#27ae60' : '#e74c3c' }};">
                        {{ $banner->is_active ? 'مفعل' : 'معطل' }}
                    </span>
                    <a href="{{ route('banners.toggle', $banner->id) }}" style="background-color: {{ $banner->is_active ? '#e74c3c' : '#27ae60' }}; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.8rem;">
                        {{ $banner->is_active ? 'تعطيل' : 'تفعيل' }}
                    </a>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">اختر ملف البانر (صورة أو فيديو أو GIF)</label>
                    <input type="file" name="{{ $banner->name }}" accept="image/*,video/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">

                    @if($banner->file_path)
                    <div style="margin-top: 0.5rem; position: relative;">
                        @if($banner->isVideo())
                        <video style="max-width: 100%; height: 80px; object-fit: cover; border-radius: 5px;" controls>
                            <source src="{{ $banner->file_url }}" type="video/{{ $banner->file_type }}">
                        </video>
                        <p style="font-size: 0.85rem; color: #666; margin-top: 0.25rem;">فيديو حالي</p>
                        @else
                        <img src="{{ $banner->file_url }}" alt="البانر" style="max-width: 100%; height: 80px; object-fit: cover; border-radius: 5px;">
                        <p style="font-size: 0.85rem; color: #666; margin-top: 0.25rem;">
                            {{ $banner->isAnimated() ? 'بانر متحرك حالي' : 'صورة حالية' }}
                        </p>
                        @endif

                        <!-- Delete File Button -->
                        <a href="{{ route('banners.deleteFile', $banner->id) }}" onclick="return confirm('هل أنت متأكد من حذف هذا الملف؟')" style="position: absolute; top: 5px; right: 5px; background-color: #e74c3c; color: white; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px;">
                            ×
                        </a>
                    </div>
                    @endif
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">رابط البانر (اختياري)</label>
                    <input type="url" name="{{ $banner->name }}_url" value="{{ $banner->url }}" placeholder="https://example.com" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">
                    <p style="font-size: 0.8rem; color: #666; margin-top: 0.25rem;">الرابط الذي سيتم التوجه إليه عند الضغط على البانر</p>
                </div>
            </div>

            <!-- File Info -->
            @if($banner->file_path)
            <div style="margin-top: 1rem; padding: 0.75rem; background-color: #f8f9fa; border-radius: 5px; font-size: 0.85rem; color: #666;">
                <strong>معلومات الملف:</strong><br>
                نوع الملف: {{ strtoupper($banner->file_type) }} |
                الحالة: {{ $banner->is_active ? 'مفعل' : 'معطل' }} |
                آخر تحديث: {{ $banner->updated_at->format('Y-m-d H:i') }}
            </div>
            @endif
        </div>
        @endforeach

        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" style="background-color: #e67e22; color: white; border: none; padding: 1rem 3rem; border-radius: 8px; cursor: pointer; font-size: 1.1rem; transition: background-color 0.3s ease; font-weight: 600;">
                حفظ جميع البانرات
            </button>
        </div>
    </form>
</div>

<!-- معاينة البانرات -->
<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h3 style="color: #333; margin: 0 0 1.5rem 0; font-size: 1.5rem;">معاينة البانرات المفعلة</h3>

    <div class="banners-preview" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
        @foreach($banners->where('is_active', true) as $banner)
        @if($banner->file_path)
        <div style="flex: 1; min-width: 250px; max-width: 320px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
            @if($banner->isVideo())
            <video style="width: 100%; height: 120px; object-fit: cover;" controls>
                <source src="{{ $banner->file_url }}" type="video/{{ $banner->file_type }}">
            </video>
            @else
            <img src="{{ $banner->file_url }}" alt="البانر" style="width: 100%; height: 120px; object-fit: cover;">
            @endif
        </div>
        @endif
        @endforeach
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: grid"] {
            display: block !important;
        }

        div[style*="display: grid"]>div {
            margin-bottom: 1rem;
        }

        .banners-preview {
            flex-direction: column !important;
        }

        div[style*="display: flex"] {
            flex-direction: column !important;
            align-items: stretch !important;
        }
    }

    button[type="submit"]:hover {
        background-color: #d35400 !important;
    }

    a[style*="background-color"]:hover {
        opacity: 0.9;
    }

</style>

@endsection
