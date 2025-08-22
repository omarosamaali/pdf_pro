@extends('layouts.admin')

@section('title', 'إضافة باقة جديدة')

@section('content')
<div class="content-header">
    <h2>إضافة باقة جديدة</h2>
    <p>املأ البيانات التالية لإنشاء باقة اشتراك جديدة.</p>
</div>
{{-- display errors --}}
@foreach ($errors->all() as $error)
<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ $error }}
</div>
@endforeach

<div class="form-container" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <form action="{{ route('subscriptions.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 1.5rem;">
            <label for="name_ar" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم الباقة (العربي)</label>
            <input type="text" id="name_ar" name="name_ar" class="form-control" value="{{ old('name_ar', $subscription->name_ar ?? '') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="name_en" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">اسم الباقة (الإنجليزي)</label>
            <input type="text" id="name_en" name="name_en" class="form-control" value="{{ old('name_en', $subscription->name_en ?? '') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>


        <div style="margin-bottom: 1.5rem;">
            <label for="features" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">الميزات</label>
            <div id="features-container">
            </div>
            <button type="button" id="add-feature" style="background-color: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; margin-top: 10px;">+ إضافة ميزة</button>
        </div>



        <div style="margin-bottom: 1.5rem;">
            <label for="price" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">السعر بالريال</label>

            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $subscription->price ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

<div style="margin-bottom: 1.5rem;" >
    <label for="daily_operations_limit" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">عدد العمليات اليومية</label>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <input type="number" id="daily_operations_limit" value="{{ old('daily_operations_limit', $subscription->daily_operations_limit ?? '') }}" name="daily_operations_limit" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" min="0" {{ old('unlimited_operations', $subscription->unlimited_operations ?? false) ? 'disabled' : '' }}>
        <div style="display: flex; align-items: center;">
            <input type="checkbox" id="unlimited_operations" name="unlimited_operations" value="1" 
            {{ old('unlimited_operations', $subscription->unlimited_operations ?? false) ? 'checked' : '' }} style="margin-left: 0.5rem;">
            <label for="unlimited_operations" style="width: 69px; color: #333;">غير محدود</label>
        </div>
    </div>
</div>

<script>
    document.getElementById('unlimited_operations').addEventListener('change', function() {
        const input = document.getElementById('daily_operations_limit');
        if (this.checked) {
            input.disabled = true;
            input.value = '';
        } else {
            input.disabled = false;
        }
    });

</script>

        <div style="margin-bottom: 1.5rem;">
            <label for="duration_in_days" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">مدة الاشتراك بالأيام</label>
            <input type="number" id="duration_in_days" value="{{ old('duration_in_days', $subscription->duration_in_days ?? '') }}" name="duration_in_days" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
        </div>

        <button type="submit" style="background-color: #27ae60; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">إنشاء الباقة</button>
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

        // إضافة حقل فارغ عند تحميل الصفحة لأول مرة
        addFeatureInput();
    });

</script>


@endsection
