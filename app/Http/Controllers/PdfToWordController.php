<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;

class PdfToWordController extends Controller
{
    public function convert(Request $request)
    {
        if (!$request->hasFile('pdfFile')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        try {
            $pdfFile = $request->file('pdfFile');
            $tempPdfPath = $pdfFile->storeAs('temp_conversions', $pdfFile->hashName());
            $fullPdfPath = Storage::path($tempPdfPath);

            // Placeholder for PDF text extraction
            $text = "This is a placeholder text. Please add a new library to extract text from the PDF file.";

            // Create and save Word document
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $section->addText($text);

            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $docxFileName = $originalFileName . '.docx';
            $fullDocxPath = Storage::path('temp_conversions/' . $docxFileName);

            $phpWord->save($fullDocxPath);

            // Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                \Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                \Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // Clean up and return file
            Storage::delete($tempPdfPath);
            return response()->download($fullDocxPath, $docxFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error("Conversion error: " . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء التحويل: ' . $e->getMessage()], 500);
        }
    }
}
