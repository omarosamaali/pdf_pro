<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PdfCompressController extends Controller
{
    public function compress(Request $request)
    {
        // Validate the request
        $request->validate([
            'pdfFile' => 'required|file|mimes:pdf|max:51200' // 50MB max
        ]);

        $pdfFile = $request->file('pdfFile');
        $originalSize = $pdfFile->getSize();

        Log::info('Starting PDF compression', [
            'filename' => $pdfFile->getClientOriginalName(),
            'original_size' => $originalSize
        ]);

        // Store the uploaded file temporarily
        $tempPath = $pdfFile->storeAs('temp_compressions', $pdfFile->hashName());
        $fullTempPath = Storage::path($tempPath);

        try {
            // Try different compression methods
            $compressedFilePath = $this->compressPdf($fullTempPath, $pdfFile->getClientOriginalName());

            if (!$compressedFilePath || !file_exists($compressedFilePath)) {
                throw new \Exception('Compression failed - no output file created');
            }

            $compressedSize = filesize($compressedFilePath);

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            Log::info('PDF compression completed', [
                'original_size' => $originalSize,
                'compressed_size' => $compressedSize,
                'reduction' => round((($originalSize - $compressedSize) / $originalSize) * 100, 2) . '%'
            ]);

            // Clean up the original uploaded file
            Storage::delete($tempPath);

            $compressedFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME) . '_compressed.pdf';

            // Return the compressed file
            return Response::download($compressedFilePath, $compressedFileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $compressedFileName . '"'
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('PDF compression failed', [
                'filename' => $pdfFile->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files
            if (Storage::exists($tempPath)) {
                Storage::delete($tempPath);
            }

            return response()->json([
                'error' => 'Compression failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function compressPdf($inputPath, $originalName)
    {
        $compressedFileName = pathinfo($originalName, PATHINFO_FILENAME) . '_compressed.pdf';
        $outputPath = Storage::path('temp_compressions/' . $compressedFileName);

        // Method 1: Try Ghostscript compression (best results)
        if ($this->compressWithGhostscript($inputPath, $outputPath)) {
            return $outputPath;
        }

        // Method 2: Try FPDI with optimization
        if ($this->compressWithFPDI($inputPath, $outputPath)) {
            return $outputPath;
        }

        // Method 3: Use system command if available
        if ($this->compressWithSystemCommand($inputPath, $outputPath)) {
            return $outputPath;
        }

        // If all methods fail, return the original file (no compression)
        Log::warning('All compression methods failed, returning original file');
        return copy($inputPath, $outputPath) ? $outputPath : false;
    }

    private function compressWithGhostscript($inputPath, $outputPath)
    {
        try {
            // Common Ghostscript paths
            $gsPaths = [
                'gs',           // Linux/Mac
                'gswin64c',     // Windows 64-bit
                'gswin32c',     // Windows 32-bit
                '/usr/bin/gs',  // Linux alternative
                '/usr/local/bin/gs' // Mac alternative
            ];

            $gsCommand = null;
            foreach ($gsPaths as $path) {
                $output = [];
                $returnCode = null;
                exec("$path --version 2>&1", $output, $returnCode);
                if ($returnCode === 0) {
                    $gsCommand = $path;
                    break;
                }
            }

            if (!$gsCommand) {
                Log::info('Ghostscript not found on system');
                return false;
            }

            // Different quality settings to try
            $qualitySettings = [
                '/screen',    // Lowest quality, highest compression
                '/ebook',     // Medium quality
                '/printer',   // High quality
                '/prepress'   // Highest quality
            ];

            foreach ($qualitySettings as $quality) {
                $command = sprintf(
                    '%s -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=%s -dNOPAUSE -dQUIET -dBATCH -dDetectDuplicateImages -dCompressFonts=true -r150 -sOutputFile=%s %s 2>&1',
                    $gsCommand,
                    $quality,
                    escapeshellarg($outputPath),
                    escapeshellarg($inputPath)
                );

                $output = [];
                $returnCode = null;
                exec($command, $output, $returnCode);

                if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
                    $originalSize = filesize($inputPath);
                    $compressedSize = filesize($outputPath);

                    // Only use if we achieved some compression
                    if ($compressedSize < $originalSize) {
                        Log::info("Ghostscript compression successful with $quality setting", [
                            'original_size' => $originalSize,
                            'compressed_size' => $compressedSize,
                            'reduction' => round((($originalSize - $compressedSize) / $originalSize) * 100, 2) . '%'
                        ]);
                        return true;
                    } else {
                        // Delete the file if it's not smaller
                        unlink($outputPath);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Ghostscript compression error: ' . $e->getMessage());
        }

        return false;
    }

    private function compressWithFPDI($inputPath, $outputPath)
    {
        try {
            if (!class_exists('\setasign\Fpdi\Fpdi')) {
                Log::info('FPDI class not found');
                return false;
            }

            $pdf = new \setasign\Fpdi\Fpdi();

            // Set compression
            $pdf->SetCompression(true);

            // Import pages
            $pageCount = $pdf->setSourceFile($inputPath);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Reduce image quality for compression
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height'], true);
            }

            $pdf->Output('F', $outputPath);

            if (file_exists($outputPath) && filesize($outputPath) > 0) {
                $originalSize = filesize($inputPath);
                $compressedSize = filesize($outputPath);

                Log::info('FPDI compression completed', [
                    'original_size' => $originalSize,
                    'compressed_size' => $compressedSize
                ]);

                return true;
            }
        } catch (\Exception $e) {
            Log::error('FPDI compression error: ' . $e->getMessage());
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }
        }

        return false;
    }

    private function compressWithSystemCommand($inputPath, $outputPath)
    {
        try {
            // Try cpdf if available
            $command = "cpdf -compress $inputPath -o $outputPath 2>&1";
            $output = [];
            $returnCode = null;
            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
                Log::info('System command compression successful');
                return true;
            }
        } catch (\Exception $e) {
            Log::error('System command compression error: ' . $e->getMessage());
        }

        return false;
    }
}
