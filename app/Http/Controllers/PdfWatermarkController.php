<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use PDFLib\PDFDocument;

class PdfWatermarkController extends Controller
{
    public function addWatermark(Request $request): JsonResponse
    {
        try {
            // Validate the uploaded file and watermark settings
            $request->validate([
                'pdfFile' => 'required|file|mimes:pdf|max:10240', // Max 10MB
                'watermarkType' => 'required|in:text,image',
                'watermarkText' => 'required_if:watermarkType,text|string|max:255',
                'watermarkImage' => 'required_if:watermarkType,image|file|mimes:jpeg,jpg,png,gif|max:2048',
                'position' => 'required|in:top-left,top-center,top-right,middle-left,middle-center,middle-right,bottom-left,bottom-center,bottom-right',
                'fontSize' => 'nullable|integer|min:20|max:100',
                'opacity' => 'nullable|numeric|min:0.1|max:1',
                'textColor' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
                'imageSize' => 'nullable|integer|min:50|max:300',
                'imageOpacity' => 'nullable|numeric|min:0.1|max:1',
            ]);

            $pdfFile = $request->file('pdfFile');
            $watermarkType = $request->input('watermarkType');
            $position = $request->input('position', 'middle-center');
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);

            // Store the uploaded PDF temporarily
            $tempPdfPath = $pdfFile->storeAs('temp_watermarks', uniqid() . '_' . $pdfFile->hashName());
            $fullPdfPath = Storage::path($tempPdfPath);

            // Load PDF document
            $pdfBytes = file_get_contents($fullPdfPath);
            $pdfDoc = PDFDocument::load($pdfBytes);
            $pages = $pdfDoc->getPages();

            if ($watermarkType === 'text') {
                $text = $request->input('watermarkText', 'CONFIDENTIAL');
                $fontSize = (int) $request->input('fontSize', 50);
                $opacity = (float) $request->input('opacity', 0.3);
                $color = $this->hexToRgb($request->input('textColor', '#ff0000'));

                foreach ($pages as $page) {
                    $this->addTextWatermark($page, $pdfDoc, $text, $fontSize, $opacity, $color, $position);
                }
            } elseif ($watermarkType === 'image' && $request->hasFile('watermarkImage')) {
                $watermarkImage = $request->file('watermarkImage');
                $imagePath = $watermarkImage->storeAs('temp_watermarks', uniqid() . '_' . $watermarkImage->hashName());
                $fullImagePath = Storage::path($imagePath);
                $imageSize = (int) $request->input('imageSize', 150);
                $imageOpacity = (float) $request->input('imageOpacity', 0.3);

                $imageBytes = file_get_contents($fullImagePath);
                $image = $pdfDoc->embedPng($imageBytes);

                foreach ($pages as $page) {
                    $this->addImageWatermark($page, $image, $imageSize, $imageOpacity, $position);
                }

                Storage::delete($imagePath);
            }

            // Save the watermarked PDF
            $watermarkedPdfBytes = $pdfDoc->save();
            $outputFileName = $originalFileName . '_watermarked.pdf';
            $outputPath = 'temp_watermarks/' . uniqid() . '_' . $outputFileName;
            Storage::put($outputPath, $watermarkedPdfBytes);
            $fullOutputPath = Storage::path($outputPath);

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                \Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                \Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // Clean up temporary PDF file
            Storage::delete($tempPdfPath);

            return response()->download($fullOutputPath, $outputFileName)->deleteFileAfterSend(true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Watermark error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة العلامة المائية: ' . $e->getMessage()
            ], 500);
        }
    }

    private function addTextWatermark($page, $pdfDoc, $text, $fontSize, $opacity, $color, $position)
    {
        $width = $page->getWidth();
        $height = $page->getHeight();
        $x = 0;
        $y = 0;

        switch ($position) {
            case 'top-left':
                $x = 50;
                $y = $height - 50;
                break;
            case 'top-center':
                $x = $width / 2;
                $y = $height - 50;
                break;
            case 'top-right':
                $x = $width - 50;
                $y = $height - 50;
                break;
            case 'middle-left':
                $x = 50;
                $y = $height / 2;
                break;
            case 'middle-center':
                $x = $width / 2;
                $y = $height / 2;
                break;
            case 'middle-right':
                $x = $width - 50;
                $y = $height / 2;
                break;
            case 'bottom-left':
                $x = 50;
                $y = 50;
                break;
            case 'bottom-center':
                $x = $width / 2;
                $y = 50;
                break;
            case 'bottom-right':
                $x = $width - 50;
                $y = 50;
                break;
        }

        $page->drawText($text, [
            'x' => $x,
            'y' => $y,
            'size' => $fontSize,
            'color' => PDFLib\rgb($color['r'] / 255, $color['g'] / 255, $color['b'] / 255),
            'opacity' => $opacity,
            'rotate' => PDFLib\degrees(0),
        ]);
    }

    private function addImageWatermark($page, $image, $size, $opacity, $position)
    {
        $width = $page->getWidth();
        $height = $page->getHeight();
        $x = 0;
        $y = 0;

        switch ($position) {
            case 'top-left':
                $x = 20;
                $y = $height - $size - 20;
                break;
            case 'top-center':
                $x = ($width - $size) / 2;
                $y = $height - $size - 20;
                break;
            case 'top-right':
                $x = $width - $size - 20;
                $y = $height - $size - 20;
                break;
            case 'middle-left':
                $x = 20;
                $y = ($height - $size) / 2;
                break;
            case 'middle-center':
                $x = ($width - $size) / 2;
                $y = ($height - $size) / 2;
                break;
            case 'middle-right':
                $x = $width - $size - 20;
                $y = ($height - $size) / 2;
                break;
            case 'bottom-left':
                $x = 20;
                $y = 20;
                break;
            case 'bottom-center':
                $x = ($width - $size) / 2;
                $y = 20;
                break;
            case 'bottom-right':
                $x = $width - $size - 20;
                $y = 20;
                break;
        }

        $page->drawImage($image, [
            'x' => $x,
            'y' => $y,
            'width' => $size,
            'height' => $size,
            'opacity' => $opacity,
        ]);
    }

    private function hexToRgb($hex)
    {
        $result = preg_match('/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i', $hex, $matches);
        return $result ? [
            'r' => hexdec($matches[1]),
            'g' => hexdec($matches[2]),
            'b' => hexdec($matches[3]),
        ] : ['r' => 255, 'g' => 0, 'b' => 0];
    }
}
