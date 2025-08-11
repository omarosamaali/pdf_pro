<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;

class PdfToPowerPointController extends Controller
{
    public function convert(Request $request)
    {
        if (!$request->hasFile('pdfFile')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $pdfFile = $request->file('pdfFile');
        $tempPdfPath = $pdfFile->storeAs('temp_conversions', $pdfFile->hashName());
        $fullPdfPath = Storage::path($tempPdfPath);

        try {
            // 1. Extract text from PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($fullPdfPath);
            $pages = $pdf->getPages();

            $objPHPPresentation = new PhpPresentation();

            foreach ($pages as $pageNumber => $page) {
                $text = $page->getText();
                if ($pageNumber > 0) {
                    $objPHPPresentation->createSlide();
                }
                $currentSlide = $objPHPPresentation->getActiveSlide();

                // 2. Add text to a new slide
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(600)
                    ->setWidth(900)
                    ->setOffsetX(30)
                    ->setOffsetY(30);

                $textRun = $shape->createTextRun($text);
                $textRun->getFont()->setSize(12)->setBold(false)->setName('Arial');
            }

            // 3. Save PowerPoint file
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $pptxFileName = $originalFileName . '.pptx';
            $fullPptxPath = Storage::path('temp_conversions/' . $pptxFileName);

            $oWriter = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
            $oWriter->save($fullPptxPath);

            // 4. Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // 5. Clean up and return file
            Storage::delete($tempPdfPath);
            return Response::download($fullPptxPath, $pptxFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('PDF to PowerPoint conversion failed', [
                'filename' => $pdfFile->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files
            Storage::delete($tempPdfPath);
            return response()->json(['error' => 'Failed to convert the file: ' . $e->getMessage()], 500);
        }
    }
}
