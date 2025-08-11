@extends('layouts.admin')

@section('title', 'تعديل الباقة')

@section('content')
<div class="content-header">
    <h2>تعديل الباقة: {{ $subscription->name_ar }}</h2>
    <p>قم بتحديث بيانات الباقة ثم احفظ التغييرات.</p>
</div>

<div class="form-container" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label for="name_ar" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم الباقة (العربي)</label>
            <input type="text" id="name_ar" name="name_ar" class="form-control" value="{{ old('name_ar', $subscription->name_ar ?? '') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="name_en" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم الباقة (الإنجليزي)</label>
            <input type="text" id="name_en" name="name_en" class="form-control" value="{{ old('name_en', $subscription->name_en ?? '') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div id="features-container">
            <div style="margin-bottom: 1.5rem;">
                <label for="features" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">الميزات</label>
                <div id="features-container">
                    @php
                    $features_ar = json_decode($subscription->features_ar ?? '[]');
                    $features_en = json_decode($subscription->features_en ?? '[]');
                    @endphp

                    @for ($i = 0; $i < count($features_ar); $i++) <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">الميزة (العربي)</label>
                            <input type="text" name="features_ar[]" class="form-control" value="{{ $features_ar[$i] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" placeholder="اكتب الميزة هنا بالعربي">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">الميزة (الإنجليزي)</label>
                            <input type="text" name="features_en[]" class="form-control" value="{{ $features_en[$i] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" placeholder="اكتب الميزة هنا بالإنجليزي">
                        </div>
                        <button type="button" class="remove-feature" style="background-color: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">حذف هذه الميزة</button>
                </div>
                @endfor
            </div>
        </div>
    </div>
    <button type="button" id="add-feature" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; margin-top: 10px;">+ إضافة ميزة</button>


<div style="margin-bottom: 1.5rem; margin-top: 1.5rem;">
    <label for="price" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">السعر</label>
    <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $subscription->price) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
</div>

<div style="margin-bottom: 1.5rem;">
    <label for="daily_operations_limit" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">عدد العمليات اليومية</label>
    <input type="number" id="daily_operations_limit" name="daily_operations_limit" value="{{ old('daily_operations_limit', $subscription->daily_operations_limit) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
</div>

<div style="margin-bottom: 1.5rem;">
    <label for="duration_in_days" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">مدة الاشتراك بالأيام</label>
    <input type="number" id="duration_in_days" name="duration_in_days" value="{{ old('duration_in_days', $subscription->duration_in_days) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
</div>

<button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">تحديث البيانات</button>
</form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const featuresContainer = document.getElementById('features-container');
        const addFeatureBtn = document.getElementById('add-feature');

        function addFeatureInput() {
            const featureDiv = document.createElement('div');
            featureDiv.style.marginBottom = '15px';
            featureDiv.style.padding = '10px';
            featureDiv.style.border = '1px solid #ccc';
            featureDiv.style.borderRadius = '8px';
            featureDiv.innerHTML = `
                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">الميزة (العربي)</label>
                    <input type="text" name="features_ar[]" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" placeholder="اكتب الميزة هنا بالعربي">
                </div>
                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">الميزة (الإنجليزي)</label>
                    <input type="text" name="features_en[]" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" placeholder="اكتب الميزة هنا بالإنجليزي">
                </div>
                <button type="button" class="remove-feature" style="background-color: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">حذف هذه الميزة</button>
            `;
            featuresContainer.appendChild(featureDiv);
        }

        addFeatureBtn.addEventListener('click', addFeatureInput);

        featuresContainer.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-feature')) {
                e.target.parentElement.remove();
            }
        });

        // إذا لم يكن هناك أي حقول موجودة، أضف حقل فارغ
        if (featuresContainer.children.length === 0) {
            addFeatureInput();
        }
    });

</script>

@endsection
