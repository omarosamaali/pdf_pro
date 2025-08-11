<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PdfToWordController;
use App\Http\Controllers\PdfToPowerPointController;
use App\Http\Controllers\PdfToExcelController;
use App\Http\Controllers\PdfRotateController;
use App\Http\Controllers\PdfCompressController;
use App\Http\Controllers\ImagesToPdfController;
use App\Http\Controllers\PdfToJpgController;
use App\Http\Controllers\PdfWatermarkController;

// صفحات العرض بدون middleware (GET requests)
Route::get('/watermark_pdf', function () {
    return view('actions.add_watermark');
})->name('add_watermark');

Route::get('/images_to_pdf', function () {
    return view('actions.images_to_pdf');
})->name('images_to_pdf');

Route::get('/compress_pdf', function () {
    return view('actions.pdf_compress');
})->name('compress_pdf');

Route::get('/merge_pdf', function () {
    return view('actions.merge_pdf');
})->name('merge_pdf');

Route::get('/rotate_pdf', function () {
    return view('actions.rotate_pdf');
})->name('rotate_pdf');

Route::get('/pdf_to_excel', function () {
    return view('actions.pdf_to_excel');
})->name('pdf_to_excel');

Route::get('/pdf_to_powerpoint', function () {
    return view('actions.pdf_to_powerpoint');
})->name('pdf_to_powerpoint');

Route::get('/pdf_to_word', function () {
    return view('actions.pdf_to_word');
})->name('pdf_to_word');

Route::get('pdf_to_jpg', function () {
    return view('actions.pdf_to_jpg');
})->name('pdf_to_jpg');
Route::middleware(['daily_limit'])->post('/convert-pdf_to_jpg', [PdfToJpgController::class, 'convert']);
// العمليات الفعلية مع middleware (POST requests)
Route::middleware(['daily_limit'])->group(function () {
    Route::post('/watermark-pdf', [PdfWatermarkController::class, 'addWatermark']);
    Route::post('/images-to-pdf', [ImagesToPdfController::class, 'convert']);
    Route::post('/compress-pdf', [PdfCompressController::class, 'compress']);
    Route::post('/rotate-pdf', [PdfRotateController::class, 'convert']);
    Route::post('/convert-pdf_to_excel', [PdfToExcelController::class, 'convert']);
    Route::post('/convert-pdf_to_powerpoint', [PdfToPowerPointController::class, 'convert']);
    Route::post('/convert-pdf_to_word', [PdfToWordController::class, 'convert']);
});
