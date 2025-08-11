<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use TCPDF;

class ImagesToPdfController extends Controller
{
    public function convert(Request $request)
    {
        // Validate uploaded files
        if (!$request->hasFile('imageFiles')) {
            return response()->json(['error' => 'No files uploaded'], 400);
        }

        $imageFiles = $request->file('imageFiles');

        try {
            // Ensure the temporary directory for PDFs exists
            $pdfTempDir = 'temp_pdfs';
            if (!Storage::exists($pdfTempDir)) {
                Storage::makeDirectory($pdfTempDir);
            }

            // Create new PDF document using TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator('Images to PDF Converter');
            $pdf->SetTitle('Converted Images');

            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set margins
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);

            foreach ($imageFiles as $imageFile) {
                // Validate file type
                if (!in_array($imageFile->getMimeType(), ['image/jpeg', 'image/png'])) {
                    throw new \Exception("Invalid file type for: " . $imageFile->getClientOriginalName());
                }

                $tempPath = $imageFile->storeAs('temp_images', $imageFile->hashName());
                $fullTempPath = Storage::path($tempPath);

                $imageSize = getimagesize($fullTempPath);
                if (!$imageSize) {
                    throw new \Exception("Invalid image file: " . $imageFile->getClientOriginalName());
                }

                $width = $imageSize[0];
                $height = $imageSize[1];

                // Determine orientation and page size
                if ($width > $height) {
                    // Landscape
                    $pdf->AddPage('L', 'A4');
                    $pageWidth = 297; // A4 landscape width in mm
                    $pageHeight = 210; // A4 landscape height in mm
                } else {
                    // Portrait
                    $pdf->AddPage('P', 'A4');
                    $pageWidth = 210; // A4 portrait width in mm
                    $pageHeight = 297; // A4 portrait height in mm
                }

                // Calculate image dimensions to fit the page while maintaining aspect ratio
                $imgRatio = $width / $height;
                $pageRatio = $pageWidth / $pageHeight;

                if ($imgRatio > $pageRatio) {
                    // Image is wider relative to page
                    $newWidth = $pageWidth;
                    $newHeight = $pageWidth / $imgRatio;
                } else {
                    // Image is taller relative to page
                    $newHeight = $pageHeight;
                    $newWidth = $pageHeight * $imgRatio;
                }

                // Center the image on the page
                $x = ($pageWidth - $newWidth) / 2;
                $y = ($pageHeight - $newHeight) / 2;

                // Add image to PDF
                $pdf->Image($fullTempPath, $x, $y, $newWidth, $newHeight, '', '', '', false, 300, '', false, false, 0);

                // Clean up temporary image file
                Storage::delete($tempPath);
            }

            // Save PDF to temporary file
            $pdfFileName = 'converted_images_' . time() . '.pdf';
            $pdfFilePath = Storage::path('temp_pdfs/' . $pdfFileName);
            $pdf->Output($pdfFilePath, 'F');

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                \Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                \Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // Return PDF for download and delete after sending
            return Response::download($pdfFilePath, 'converted_images.pdf')
                ->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error("Conversion error: " . $e->getMessage());
            return response()->json(['error' => 'Conversion failed: ' . $e->getMessage()], 500);
        }
    }
}
