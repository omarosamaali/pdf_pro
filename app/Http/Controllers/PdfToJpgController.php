<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Exception;

class PdfToJpgController extends Controller
{
    public function convert(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'pdfFile' => 'required|file|mimes:pdf|max:51200', // 50MB max
            ]);

            $pdfFile = $request->file('pdfFile');

            // Check if file upload was successful
            if (!$pdfFile || !$pdfFile->isValid()) {
                throw new Exception('Invalid file upload');
            }

            // Store the uploaded file
            $tempPdfPath = $pdfFile->storeAs('temp_conversions', $pdfFile->hashName());
            $fullPdfPath = Storage::path($tempPdfPath);

            // Verify file exists and is readable
            if (!file_exists($fullPdfPath) || !is_readable($fullPdfPath)) {
                throw new Exception('PDF file is not accessible');
            }

            // Check if required directories exist
            if (!Storage::exists('temp_conversions')) {
                Storage::makeDirectory('temp_conversions');
            }

            // Check available image processing libraries
            $hasImagick = extension_loaded('imagick');
            $hasGD = extension_loaded('gd');

            if (!$hasImagick && !$hasGD) {
                throw new Exception('Neither ImageMagick nor GD library is available. Please install php-imagick or ensure GD is enabled.');
            }

            Log::info('PDF conversion starting', [
                'filename' => $pdfFile->getClientOriginalName(),
                'imagick_available' => $hasImagick,
                'gd_available' => $hasGD
            ]);

            // Create a temporary directory for images
            $outputDir = 'temp_conversions/' . uniqid('jpg_');
            Storage::makeDirectory($outputDir);
            $fullOutputDir = Storage::path($outputDir);

            $imagePaths = [];
            $pageCount = 0;

            if ($hasImagick) {
                // Use ImageMagick (preferred method)
                $imagePaths = $this->convertWithImagick($fullPdfPath, $fullOutputDir, $pageCount);
            } else {
                // Fallback to GhostScript + GD (if available)
                $imagePaths = $this->convertWithGhostScript($fullPdfPath, $fullOutputDir, $pageCount);
            }

            if (empty($imagePaths)) {
                throw new Exception('No pages could be converted from the PDF');
            }

            // Create a ZIP file containing all images
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $zipFileName = $originalFileName . '_images.zip';
            $zipPath = Storage::path('temp_conversions/' . $zipFileName);

            $zip = new ZipArchive();
            $zipResult = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            if ($zipResult !== TRUE) {
                throw new Exception('Failed to create ZIP archive. Error code: ' . $zipResult);
            }

            foreach ($imagePaths as $index => $imagePath) {
                $pageNumber = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                $result = $zip->addFile($imagePath, "page_{$pageNumber}.jpg");
                if (!$result) {
                    throw new Exception("Failed to add page {$pageNumber} to ZIP");
                }
            }

            $zip->close();

            // Verify ZIP file was created and has content
            if (!file_exists($zipPath) || filesize($zipPath) == 0) {
                throw new Exception('ZIP file creation failed');
            }

            // Increment operation count only on success
            try {
                if (Auth::check()) {
                    Auth::user()->increment('daily_operations');
                    Log::info("User " . Auth::user()->id . " operation count incremented");
                } else {
                    $currentCount = session('daily_operations', 0);
                    session(['daily_operations' => $currentCount + 1]);
                    Log::info("Guest operation count incremented to: " . ($currentCount + 1));
                }
            } catch (\Exception $e) {
                Log::warning('Failed to increment operation count: ' . $e->getMessage());
            }

            // Clean up temporary files
            Storage::delete($tempPdfPath);
            Storage::deleteDirectory($outputDir);

            // Log success
            Log::info('PDF to JPG conversion successful', [
                'filename' => $pdfFile->getClientOriginalName(),
                'pages' => $pageCount,
                'zip_size' => filesize($zipPath)
            ]);

            // Return the ZIP file
            return Response::download($zipPath, $zipFileName, [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"'
            ])->deleteFileAfterSend(true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'file_info' => $request->hasFile('pdfFile') ? [
                    'name' => $request->file('pdfFile')->getClientOriginalName(),
                    'size' => $request->file('pdfFile')->getSize(),
                    'mime' => $request->file('pdfFile')->getMimeType()
                ] : 'No file'
            ]);

            return response()->json([
                'error' => 'File validation failed: ' . implode(' ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('PDF to JPG conversion failed', [
                'filename' => $request->hasFile('pdfFile') ? $request->file('pdfFile')->getClientOriginalName() : 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files if they exist
            if (isset($tempPdfPath) && Storage::exists($tempPdfPath)) {
                Storage::delete($tempPdfPath);
            }
            if (isset($outputDir) && Storage::exists($outputDir)) {
                Storage::deleteDirectory($outputDir);
            }
            if (isset($zipPath) && file_exists($zipPath)) {
                unlink($zipPath);
            }

            return response()->json([
                'error' => 'Conversion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function convertWithImagick($pdfPath, $outputDir, &$pageCount)
    {
        try {
            // Use Spatie package with ImageMagick
            $pdf = new \Spatie\PdfToImage\Pdf($pdfPath);
            $pageCount = $pdf->getNumberOfPages();

            $imagePaths = [];
            for ($page = 1; $page <= $pageCount; $page++) {
                $outputPath = $outputDir . '/page_' . str_pad($page, 3, '0', STR_PAD_LEFT) . '.jpg';

                $pdf->setPage($page)
                    ->setResolution(300)
                    ->setOutputFormat('jpg')
                    ->setCompressionQuality(85)
                    ->saveImage($outputPath);

                if (!file_exists($outputPath)) {
                    throw new Exception("Failed to create image for page {$page}");
                }

                $imagePaths[] = $outputPath;
            }

            return $imagePaths;
        } catch (\Exception $e) {
            throw new Exception('ImageMagick conversion failed: ' . $e->getMessage());
        }
    }

    private function convertWithGhostScript($pdfPath, $outputDir, &$pageCount)
    {
        // This method requires GhostScript to be installed
        // For Windows, download from: https://www.ghostscript.com/download/gsdnld.html

        try {
            // First, try to get page count using GhostScript
            $command = 'gswin64c -q -dNOPAUSE -dBATCH -sDEVICE=inkcov "' . $pdfPath . '" 2>&1';
            $output = shell_exec($command);

            if ($output === null) {
                throw new Exception('GhostScript is not available. Please install ImageMagick or GhostScript.');
            }

            // Count pages from output
            $lines = explode("\n", trim($output));
            $pageCount = count(array_filter($lines, function ($line) {
                return strpos($line, 'CMYK') !== false;
            }));

            if ($pageCount == 0) {
                $pageCount = 1; // Assume at least 1 page
            }

            // Convert PDF to images using GhostScript
            $imagePaths = [];
            $outputPattern = $outputDir . '/page_%03d.jpg';

            $command = sprintf(
                'gswin64c -dNOPAUSE -dBATCH -sDEVICE=jpeg -r300 -dUseCropBox -sOutputFile="%s" "%s" 2>&1',
                $outputPattern,
                $pdfPath
            );

            $result = shell_exec($command);

            // Check if images were created
            for ($page = 1; $page <= $pageCount; $page++) {
                $expectedPath = sprintf($outputDir . '/page_%03d.jpg', $page);
                if (file_exists($expectedPath)) {
                    $imagePaths[] = $expectedPath;
                }
            }

            if (empty($imagePaths)) {
                throw new Exception('No images were generated by GhostScript');
            }

            return $imagePaths;
        } catch (\Exception $e) {
            throw new Exception('GhostScript conversion failed: ' . $e->getMessage() . '. Please install ImageMagick instead.');
        }
    }
}
