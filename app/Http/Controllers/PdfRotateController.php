<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class PdfRotateController extends Controller
{
    public function convert(Request $request)
    {
        // Validate the request
        $request->validate([
            'pdfFile' => 'required|file|mimes:pdf|max:51200', // 50MB max
            'rotation' => 'required|integer|in:-90,90,180,270,-270,-180' // Valid rotation angles
        ]);

        $pdfFile = $request->file('pdfFile');
        $rotation = (int) $request->input('rotation');

        Log::info('Starting PDF rotation', [
            'filename' => $pdfFile->getClientOriginalName(),
            'rotation' => $rotation
        ]);

        // Store the uploaded file temporarily
        $tempPath = $pdfFile->storeAs('temp_rotations', $pdfFile->hashName());
        $fullTempPath = Storage::path($tempPath);

        try {
            // Initialize FPDI
            $pdf = new Fpdi();

            // Import pages from the source PDF
            $pageCount = $pdf->setSourceFile($fullTempPath);

            // Process each page
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Adjust orientation based on rotation
                $orientation = ($rotation % 180 === 0) ? ($size['width'] > $size['height'] ? 'L' : 'P') : ($size['width'] > $size['height'] ? 'P' : 'L');
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);

                // Apply rotation
                $pdf->Rotate($rotation);
                $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);
                $pdf->Rotate(0); // Reset rotation for the next page
            }

            // Save the rotated PDF
            $fileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME) . '_rotated.pdf';
            $outputPath = 'temp_rotations/' . uniqid() . '_' . $fileName;
            $fullOutputPath = Storage::path($outputPath);
            $pdf->Output($fullOutputPath, 'F');

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // Clean up temporary file
            Storage::delete($tempPath);

            // Return the rotated file
            return Response::download($fullOutputPath, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('PDF rotation failed', [
                'filename' => $pdfFile->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files
            if (Storage::exists($tempPath)) {
                Storage::delete($tempPath);
            }

            return response()->json([
                'error' => 'Rotation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
