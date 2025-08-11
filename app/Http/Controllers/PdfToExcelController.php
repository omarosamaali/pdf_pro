<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Smalot\PdfParser\Parser;

class PdfToExcelController extends Controller
{
    public function convert(Request $request)
    {
        if (!$request->hasFile('pdfFile')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $pdfFile = $request->file('pdfFile');
        $tempPdfPath = $pdfFile->storeAs('temp_conversions', $pdfFile->hashName(), 'public');
        $fullPdfPath = Storage::disk('public')->path($tempPdfPath);

        try {
            // 1. Extract text from PDF using Smalot/pdfparser
            $parser = new Parser();
            $pdf = $parser->parseFile($fullPdfPath);
            $text = $pdf->getText();
            $lines = explode("\n", $text);

            // 2. Process text and create Excel file
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $row = 1;

            foreach ($lines as $line) {
                // Simple logic to split into columns and rows
                $cells = preg_split('/\s{2,}/', trim($line));
                if (count($cells) > 1) {
                    $col = 'A';
                    foreach ($cells as $cellValue) {
                        $sheet->setCellValue($col . $row, $cellValue);
                        $col++;
                    }
                    $row++;
                }
            }

            // 3. Save Excel file
            $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            $excelFileName = $originalFileName . '.xlsx';
            $excelDir = 'temp_conversions';
            $fullExcelPath = Storage::disk('public')->path($excelDir . '/' . $excelFileName);

            $writer = new Xlsx($spreadsheet);
            $writer->save($fullExcelPath);

            // 4. Increment operation count only on success
            if (Auth::check()) {
                Auth::user()->increment('daily_operations');
                Log::info("User " . Auth::user()->id . " operation count incremented to: " . Auth::user()->daily_operations);
            } else {
                session()->increment('daily_operations');
                Log::info("Guest operation count incremented to: " . session('daily_operations'));
            }

            // 5. Clean up and return file
            Storage::disk('public')->delete($tempPdfPath);
            return Response::download($fullExcelPath, $excelFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('PDF to Excel conversion failed', [
                'filename' => $pdfFile->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up files
            Storage::disk('public')->delete($tempPdfPath);
            return response()->json(['error' => 'Failed to convert the file: ' . $e->getMessage()], 500);
        }
    }
}
