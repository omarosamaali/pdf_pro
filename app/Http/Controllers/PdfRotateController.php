<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PdfRotateController extends Controller
{
    public function convert(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $request->validate([
                'pdfFile' => 'required|file|mimes:pdf|max:51200', // 50MB max
                'rotation' => 'required|integer'
            ]);

            $pdfFile = $request->file('pdfFile');
            $rotation = (int) $request->input('rotation');

            // تطبيع الدوران إلى نطاق 0-360
            $rotation = ($rotation % 360 + 360) % 360;

            Log::info('بدء تدوير PDF', [
                'filename' => $pdfFile->getClientOriginalName(),
                'size' => $pdfFile->getSize(),
                'rotation' => $rotation
            ]);

            // إذا لم يكن هناك حاجة للدوران، أرجع الملف الأصلي
            if ($rotation === 0) {
                $this->incrementOperationCount();

                $originalName = $pdfFile->getClientOriginalName();
                $downloadFileName = pathinfo($originalName, PATHINFO_FILENAME) . '_rotated.pdf';

                return response()->download(
                    $pdfFile->path(),
                    $downloadFileName,
                    ['Content-Type' => 'application/pdf']
                );
            }

            // إنشاء مجلد مؤقت
            $tempDir = storage_path('app/temp_rotations');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // حفظ الملف مؤقتاً
            $tempFileName = uniqid() . '_' . time() . '.pdf';
            $tempPath = 'temp_rotations/' . $tempFileName;
            $pdfFile->storeAs('temp_rotations', $tempFileName);
            $fullTempPath = Storage::path($tempPath);

            // تدوير PDF باستخدام طريقة بسيطة
            $outputPath = $this->simpleRotatePdf($fullTempPath, $rotation);

            if (!$outputPath) {
                throw new \Exception('فشل في تدوير الملف');
            }

            return $this->downloadAndCleanup($outputPath, $pdfFile->getClientOriginalName(), $fullTempPath);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'نوع ملف غير صحيح أو حجم كبير. يرجى رفع ملف PDF صحيح (أقصى حد 50 ميجابايت)',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('فشل تدوير PDF', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'error' => 'حدث خطأ في الخادم. يرجى المحاولة مرة أخرى.'
            ], 500);
        }
    }

    /**
     * طريقة بسيطة لتدوير PDF
     */
    private function simpleRotatePdf($inputPath, $rotation)
    {
        try {
            // قراءة محتوى PDF
            $pdfContent = file_get_contents($inputPath);

            if (!$pdfContent) {
                return false;
            }

            // تحويل الدوران إلى تنسيق PDF
            $rotationValue = 0;
            switch ($rotation) {
                case 90:
                    $rotationValue = 90;
                    break;
                case 180:
                    $rotationValue = 180;
                    break;
                case 270:
                    $rotationValue = 270;
                    break;
                default:
                    return $inputPath; // لا حاجة للدوران
            }

            // إضافة معلومات الدوران إلى PDF
            $rotatedContent = $this->addRotationToPdf($pdfContent, $rotationValue);

            if (!$rotatedContent) {
                return false;
            }

            // حفظ الملف المدور
            $outputPath = storage_path('app/temp_rotations/' . uniqid() . '_rotated.pdf');
            file_put_contents($outputPath, $rotatedContent);

            Log::info('تم تدوير PDF بنجاح');
            return $outputPath;
        } catch (\Exception $e) {
            Log::error('فشل الطريقة البسيطة لتدوير PDF', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * إضافة معلومات الدوران إلى PDF
     */
    private function addRotationToPdf($pdfContent, $rotation)
    {
        try {
            // البحث عن صفحات PDF وإضافة معلومات الدوران
            $pattern = '/\/Type\s*\/Page\s/';

            $callback = function ($matches) use ($rotation) {
                return $matches[0] . "/Rotate $rotation ";
            };

            $rotatedContent = preg_replace_callback($pattern, $callback, $pdfContent);

            if ($rotatedContent === null) {
                return false;
            }

            return $rotatedContent;
        } catch (\Exception $e) {
            Log::error('فشل في إضافة معلومات الدوران', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * تنزيل وتنظيف الملفات المؤقتة
     */
    private function downloadAndCleanup($outputPath, $originalName, $inputPath)
    {
        // زيادة عداد العمليات
        $this->incrementOperationCount();

        // تنظيف الملف المؤقت
        if (file_exists($inputPath)) {
            unlink($inputPath);
        }

        // إنشاء اسم ملف التنزيل
        $downloadFileName = pathinfo($originalName, PATHINFO_FILENAME) . '_rotated.pdf';

        Log::info('تم إكمال تدوير PDF بنجاح', [
            'original_name' => $originalName,
            'download_name' => $downloadFileName,
            'output_size' => filesize($outputPath)
        ]);

        return Response::download($outputPath, $downloadFileName, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $downloadFileName . '"'
        ])->deleteFileAfterSend(true);
    }

    /**
     * زيادة عداد العمليات اليومية
     */
    private function incrementOperationCount()
    {
        if (Auth::check()) {
            Auth::user()->increment('daily_operations');
            Log::info('تم زيادة العمليات اليومية للمستخدم', [
                'user_id' => Auth::id(),
                'new_count' => Auth::user()->daily_operations
            ]);
        } else {
            $currentCount = session('daily_operations', 0);
            $newCount = $currentCount + 1;
            session(['daily_operations' => $newCount]);
            Log::info('تم زيادة العمليات اليومية للجلسة', [
                'session_id' => session()->getId(),
                'new_count' => $newCount
            ]);
        }
    }
}
