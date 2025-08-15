<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PdfWatermarkController extends Controller
{
    public function addWatermark(Request $request)
    {
        try {
            // التحقق من الملف
            $request->validate([
                'pdfFile' => 'required|file|mimes:pdf|max:10240',
            ]);

            $pdfFile = $request->file('pdfFile');
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);

            // حفظ الملف مؤقتاً
            $tempFileName = time() . '_watermarked_' . $pdfFile->getClientOriginalName();
            $tempPath = $pdfFile->storeAs('temp_watermarks', $tempFileName);
            $fullPath = Storage::path($tempPath);

            // زيادة عداد العمليات
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
            } else {
                session(['daily_operations' => session('daily_operations', 0) + 1]);
            }

            // إرجاع الملف للتحميل مباشرة
            return response()->download($fullPath, $originalFileName . '_watermarked.pdf')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error("Watermark error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}
