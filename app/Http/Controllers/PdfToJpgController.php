<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToImage\Pdf;
use ZipArchive;

class PdfToJpgController extends Controller
{
    public function convert(Request $request)
    {
        // Validate the request
        $request->validate([
            'pdfFile' => 'required|file|mimes:pdf|max:51200', // 50MB max
        ]);

        $pdfFile = $request->file('pdfFile');
        $tempPdfPath = $pdfFile->storeAs('temp_conversions', $pdfFile->hashName());
        $fullPdfPath = Storage::path($tempPdfPath);

        try {
            // Initialize PDF to image converter
            $pdf = new Pdf($fullPdfPath);
            $pageCount = $pdf->getNumberOfPages();

            // Create a temporary directory for images
            $outputDir = 'temp_conversions/' . uniqid('jpg_');
            Storage::makeDirectory($outputDir);
            $fullOutputDir = Storage::path($outputDir);

            // Convert each page to JPG
            $imagePaths = [];
            for ($page = 1; $page <= $pageCount; $page++) {
                $outputPath = $fullOutputDir . '/page_' . $page . '.jpg';
                $pdf->setPage($page)
                    ->setResolution(300) // High quality
                    ->setOutputFormat('jpg')
                    ->saveImage($outputPath);
                $imagePaths[] = $outputPath;
            }

            // Create a ZIP file containing all images
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $zipFileName = $originalFileName . '_images.zip';
            $zipPath = Storage::path('temp_conversions/' . $zipFileName);

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
                foreach ($imagePaths as $index => $imagePath) {
                    $zip->addFile($imagePath, 'page_' . ($index + 1) . '.jpg');
                }
                $zip->close();
            } else {
                throw new Exception('Failed to create ZIP archive');
            }

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // Clean up temporary files
            Storage::delete($tempPdfPath);
            Storage::deleteDirectory($outputDir);

            // Return the ZIP file
            return Response::download($zipPath, $zipFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('PDF to JPG conversion failed', [
                'filename' => $pdfFile->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files
            Storage::delete($tempPdfPath);
            if (isset($outputDir) && Storage::exists($outputDir)) {
                Storage::deleteDirectory($outputDir);
            }

            return response()->json([
                'error' => 'Failed to convert the file: ' . $e->getMessage()
            ], 500);
        }
    }
}
