@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">تحويل PDF إلى صور</h3>
        <form action="{{ route('pdf.convert-to-jpg') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_file" accept=".pdf" class="mb-4 w-full">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                تحويل إلى JPG
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">تحويل PDF إلى Word</h3>
        <form action="{{ route('pdf.convert-to-word') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_file" accept=".pdf" class="mb-4 w-full">
            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
                تحويل إلى Word
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">ضغط ملف PDF</h3>
        <form action="{{ route('pdf.compress') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_file" accept=".pdf" class="mb-4 w-full">
            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">
                ضغط الملف
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">دمج ملفات PDF</h3>
        <form action="{{ route('pdf.merge') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_files[]" multiple accept=".pdf" class="mb-4 w-full">
            <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700">
                دمج الملفات
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">إضافة علامة مائية</h3>
        <form action="{{ route('pdf.watermark') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="pdf_file" accept=".pdf" class="mb-2 w-full">
            <input type="text" name="watermark_text" placeholder="نص العلامة المائية" class="mb-4 w-full p-2 border rounded">
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                إضافة علامة مائية
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">اشتراكك الحالي</h3>
        @if(auth()->user()->subscription)
        <p class="text-green-600">{{ auth()->user()->subscription->plan->name_ar }}</p>
        <p class="text-sm text-gray-600">ينتهي في: {{ auth()->user()->subscription->expires_at->format('Y-m-d') }}</p>
        @else
        <p class="text-red-600">لا يوجد اشتراك نشط</p>
        <a href="{{ route('subscriptions.index') }}" class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg">
            شراء اشتراك
        </a>
        @endif
        <p class="mt-4 text-sm">العمليات المتبقية اليوم: {{ (auth()->user()->subscription?->plan->daily_operations_limit ?? 5) - auth()->user()->daily_operations }}</p>
    </div>
</div>

<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold mb-4">سجل العمليات الأخيرة</h3>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-right">اسم الملف</th>
                    <th class="px-4 py-2 text-right">نوع العملية</th>
                    <th class="px-4 py-2 text-right">الحالة</th>
                    <th class="px-4 py-2 text-right">التاريخ</th>
                    <th class="px-4 py-2 text-right">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach(auth()->user()->fileOperations()->latest()->limit(10)->get() as $operation)
                <tr>
                    <td class="px-4 py-2">{{ $operation->original_filename }}</td>
                    <td class="px-4 py-2">{{ $operation->operation_type }}</td>
                    <td class="px-4 py-2">
                        @if($operation->status == 'completed')
                        <span class="text-green-600">مكتملة</span>
                        @elseif($operation->status == 'processing')
                        <span class="text-yellow-600">قيد المعالجة</span>
                        @else
                        <span class="text-red-600">فشلت</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $operation->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">
                        @if($operation->status == 'completed' && $operation->output_path)
                        <a href="{{ route('download', $operation->id) }}" class="text-blue-600 hover:underline">تحميل</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
