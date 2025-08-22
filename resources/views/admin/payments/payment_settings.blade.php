@extends('layouts.admin')

@section('title', 'إعدادات الدفع')

@section('content')
<div class="content-header">
    <h2>إعدادات الدفع Paypal</h2>
    <p>قم بإدخال وتحديث تفاصيل طرق الدفع المختلفة.</p>
</div>

@if (session('success'))
<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: right;">
    {{ session('success') }}
</div>
@endif

<div class="form-container" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37); border: 1px solid rgba(255, 255, 255, 0.2);">
    <h3 style="color: #333; margin: 0 0 1rem 0; font-size: 1.5rem;">إعدادات PayPal</h3>
    <form action="{{ route('admin.payments.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label for="paypal_mode" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">وضع التشغيل</label>
            <select id="paypal_mode" name="paypal_mode" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;" required>
                <option value="sandbox" {{ old('paypal_mode', $paymentSetting->paypal_mode ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (تجريبي)</option>
                <option value="live" {{ old('paypal_mode', $paymentSetting->paypal_mode ?? '') == 'live' ? 'selected' : '' }}>Live (فعلي)</option>
            </select>
            @error('paypal_mode') <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span> @enderror
        </div>

        <!-- Sandbox Settings -->
        <div id="sandbox-settings" style="border: 2px solid #f39c12; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; background-color: #fff8e1;">
            <h4 style="color: #f39c12; margin-bottom: 1rem;">إعدادات Sandbox (التجريبي)</h4>

            <div style="margin-bottom: 1.5rem;">
                <label for="paypal_sandbox_client_id" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">Sandbox Client ID</label>
                <input type="text" id="paypal_sandbox_client_id" name="paypal_sandbox_client_id" value="{{ old('paypal_sandbox_client_id', $paymentSetting->paypal_sandbox_client_id ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('paypal_sandbox_client_id') <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="paypal_sandbox_client_secret" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">Sandbox Client Secret</label>
                <input type="text" id="paypal_sandbox_client_secret" name="paypal_sandbox_client_secret" value="{{ old('paypal_sandbox_client_secret', $paymentSetting->paypal_sandbox_client_secret ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('paypal_sandbox_client_secret') <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Live Settings -->
        <div id="live-settings" style="border: 2px solid #27ae60; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; background-color: #f0f9f4;">
            <h4 style="color: #27ae60; margin-bottom: 1rem;">إعدادات Live (الفعلي)</h4>

            <div style="margin-bottom: 1.5rem;">
                <label for="paypal_live_client_id" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">Live Client ID</label>
                <input type="text" id="paypal_live_client_id" name="paypal_live_client_id" value="{{ old('paypal_live_client_id', $paymentSetting->paypal_live_client_id ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('paypal_live_client_id') <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="paypal_live_client_secret" style="display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333;">Live Client Secret</label>
                <input type="text" id="paypal_live_client_secret" name="paypal_live_client_secret" value="{{ old('paypal_live_client_secret', $paymentSetting->paypal_live_client_secret ?? '') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('paypal_live_client_secret') <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" style="background-color: #3498db; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease;">حفظ إعدادات PayPal</button>
    </form>
</div>

<script>
    // إظهار/إخفاء الحقول حسب الوضع المختار
    document.getElementById('paypal_mode').addEventListener('change', function() {
        const sandboxSettings = document.getElementById('sandbox-settings');
        const liveSettings = document.getElementById('live-settings');

        if (this.value === 'sandbox') {
            sandboxSettings.style.display = 'block';
            liveSettings.style.display = 'none';
        } else {
            sandboxSettings.style.display = 'none';
            liveSettings.style.display = 'block';
        }
    });

    // تطبيق الحالة الحالية عند تحميل الصفحة
    window.addEventListener('load', function() {
        const currentMode = document.getElementById('paypal_mode').value;
        const sandboxSettings = document.getElementById('sandbox-settings');
        const liveSettings = document.getElementById('live-settings');

        if (currentMode === 'sandbox') {
            sandboxSettings.style.display = 'block';
            liveSettings.style.display = 'none';
        } else {
            sandboxSettings.style.display = 'none';
            liveSettings.style.display = 'block';
        }
    });

</script>
@endsection
