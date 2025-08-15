@extends('layouts.app')

@section('title', 'PDF to JPG')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        {{-- banner 5 is hidden by default and only shown on initial page load if needed --}}
        <div id="banner-5-box" class="mt-6 hidden">
            @php $conversionBanner5 = App\Models\Banner::where('name', 'banner_5')->where('is_active', true)->first(); @endphp
            @if ($conversionBanner5 && $conversionBanner5->file_path)
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                @if ($conversionBanner5->isVideo())
                <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                    <source src="{{ $conversionBanner5->file_url }}" type="video/{{ $conversionBanner5->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner5->url }}" target="_blank">
                    <img src="{{ $conversionBanner5->file_url }}" alt="Banner 5" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                </a>
                @endif
            </div>
            @else
            <p class="text-red-600">{{ __('messages.no_active_banner_found_5') }}</p>
            @endif
        </div>

        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.pdf_to_jpg_conversion') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.convert_pdf_to_jpg_description') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_pdf_file_here') }}</p>
                <button class="open--btn bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    {{ __('messages.select_pdf_file') }}
                </button>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.supports_pdf_local_processing') }}</p>
            </div>
        </div>

        <div id="file-card" class="hidden mt-6" style="align-items: center; justify-content: center;">
            <div id="banner-5-box" class="mt-6">
                @php $conversionBanner5 = App\Models\Banner::where('name', 'banner_7')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner5 && $conversionBanner5->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner5->isVideo())
                    <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                        <source src="{{ $conversionBanner5->file_url }}" type="video/{{ $conversionBanner5->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner5->url }}" target="_blank">
                        <img src="{{ $conversionBanner5->file_url }}" alt="Banner 5" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                    </a>
                    @endif
                </div>
                @else
                <p class="text-red-600">{{ __('messages.no_active_banner_found_7') }}</p>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                <div class="flex items-center justify-center mb-4">
                    <div id="pdf-icon">
                        <svg class="w-16 h-16 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h3 id="selected-file-name" class="text-lg font-semibold text-gray-800 break-all mb-1"></h3>
                    <div class="flex justify-center gap-2 text-sm text-gray-600">
                        <span id="file-size"></span>
                        <span id="file-format" class="font-medium"></span>
                    </div>
                </div>

                <div id="pdf-info" class="text-center mb-4">
                    <div class="bg-blue-50 rounded-lg p-3 mb-3">
                        <p class="text-sm text-blue-800">
                            <strong>{{ __('messages.number_of_pages') }}</strong> <span id="pdf-pages">{{ __('messages.calculating') }}</span>
                        </p>
                        <p class="text-xs text-blue-600 mt-1">{{ __('messages.local_processing_note') }}</p>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-700">{{ __('messages.high_quality_300_dpi') }}</span>
                    </div>
                    <p id="conversion-note" class="text-xs text-gray-600">{{ __('messages.client_side_conversion') }}</p>
                </div>

                <div id="convert-btn-loading" class="w-full mb-3">
                    <div class="bg-gray-100 rounded-lg py-3 px-6 text-center">
                        <svg class="w-6 h-6 inline mr-2 animate-spin text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span class="text-gray-600 font-medium">{{ __('messages.preparing_file_ellipsis') }} (<span id="btn-countdown">3</span>)</span>
                    </div>
                </div>

                <button id="convert-btn" class="hidden w-full bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 mb-3" onclick="convertPDFToImages()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span id="convert-btn-text">{{ __('messages.convert_to_jpg_button') }}</span>
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    {{ __('messages.select_another_file') }}
                </button>
            </div>
            <div id="banner-5-box" class="mt-6">
                @php $conversionBanner5 = App\Models\Banner::where('name', 'banner_6')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner5 && $conversionBanner5->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner5->isVideo())
                    <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                        <source src="{{ $conversionBanner5->file_url }}" type="video/{{ $conversionBanner5->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner5->url }}" target="_blank">
                        <img src="{{ $conversionBanner5->file_url }}" alt="Banner 5" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                    </a>
                    @endif
                </div>
                @else
                <p class="text-red-600">{{ __('messages.no_active_banner_found_6') }}</p>
                @endif
            </div>
        </div>

        <div id="button-preparation-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-blue-200">
                <div class="text-center">
                    <svg class="w-16 h-16 text-blue-500 mx-auto mb-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    <h4 class="text-xl font-bold text-blue-700 mb-2">{{ __('messages.preparing_file_ellipsis') }} 🔄</h4>
                    <p class="text-gray-600 mb-4">{{ __('messages.please_wait') }}</p>

                    <div class="relative mx-auto w-20 h-20 mb-4">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 80 80">
                            <circle cx="40" cy="40" r="36" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                            <circle id="button-countdown-circle" cx="40" cy="40" r="36" stroke="#3b82f6" stroke-width="8" fill="none" stroke-dasharray="226.19" stroke-dashoffset="226.19" stroke-linecap="round"></circle>
                        </svg>
                        <div id="button-countdown-number" class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-blue-600">
                            3</div>
                    </div>

                    <p class="text-sm text-gray-500">{{ __('messages.conversion_will_start_in') }} <span id="button-countdown-text">3</span>
                        {{ __('messages.seconds_countdown') }}</p>
                </div>
            </div>
        </div>

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.converting') }}</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
                <p id="progress-detail" class="text-center text-xs text-gray-500 mt-1">{{ __('messages.processing_locally') }}</p>
            </div>
        </div>

        <div id="countdown-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-green-200">
                <div class="text-center">
                    <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="text-xl font-bold text-green-700 mb-2">{{ __('messages.conversion_completed') }}</h4>
                    <p class="text-gray-600 mb-4">{{ __('messages.preparing_download_file') }}</p>

                    <div class="relative mx-auto w-20 h-20 mb-4">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 80 80">
                            <circle cx="40" cy="40" r="36" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                            <circle id="countdown-circle" cx="40" cy="40" r="36" stroke="#10b981" stroke-width="8" fill="none" stroke-dasharray="226.19" stroke-dashoffset="226.19" stroke-linecap="round"></circle>
                        </svg>
                        <div id="countdown-number" class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-green-600">
                            3</div>
                    </div>

                    <p class="text-sm text-gray-500">{{ __('messages.download_link_preparation') }} <span id="countdown-text">3</span>
                        {{ __('messages.seconds_countdown') }}</p>
                </div>
            </div>
        </div>

        {{-- banner 4 is hidden on initial load and shown only on file selection --}}
        <div id="ad-box" class="hidden mt-6">
            @php
            $conversionBanner = App\Models\Banner::where('name', 'banner_4')->where('is_active', true)->first();
            @endphp
            @if ($conversionBanner && $conversionBanner->file_path)
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                @if ($conversionBanner->isVideo())
                <video id="ad-content" style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                    <source src="{{ $conversionBanner->file_url }}" type="video/{{ $conversionBanner->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner->url }}" target="_blank">
                    <img id="ad-content" src="{{ $conversionBanner->file_url }}" alt="Banner" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                </a>
                @endif
            </div>
            @else
            <p class="text-red-600">{{ __('messages.no_active_banner_found_4') }}</p>
            @endif
        </div>

        <div id="download-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                <a id="download-btn" href="#" class="w-full bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors inline-block text-center mb-3" onclick="downloadAndReset()">{{ __('messages.download_jpg') }}</a>
                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">{{ __('messages.select_another_file') }}</button>
            </div>
        </div>

        <input type="file" id="file-input" accept="application/pdf" style="display: none;" onchange="handleFileSelect(event)">
    </div>
</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
    // Configure PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');

    let selectedFile = null;
    let pdfDocument = null;
    let countdownTimer = null;
    let buttonPreparationTimer = null;

    // Ensure both banners are hidden on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
    });

    function openFilePicker() {
        document.getElementById('file-input').click();
    }

    // Handle drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
        dropZone.style.borderColor = '#3b82f6';
        dropZone.style.backgroundColor = '#dbeafe';
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        dropZone.style.borderColor = '';
        dropZone.style.backgroundColor = '';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        dropZone.style.borderColor = '';
        dropZone.style.backgroundColor = '';
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect({
                target: {
                    files: files
                }
            });
        }
    });

    async function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            // Check file type
            if (file.type !== 'application/pdf') {
                Swal.fire({
                    icon: 'error'
                    , title: 'Invalid File'
                    , text: 'Please select a valid PDF file'
                    , confirmButtonColor: '#3085d6'
                    , confirmButtonText: 'OK'
                });
                return;
            }

            selectedFile = file;

            // Hide initial content
            document.getElementById('initial-content').style.display = 'none';

            // Show file card and banner 4
            document.getElementById('file-card').classList.remove('hidden');
            document.getElementById('file-card').classList.add('block');

            document.getElementById('ad-box').classList.remove('hidden');
            document.getElementById('banner-5-box').style.display = 'block';


            // Hide banner 5 in case it was somehow visible

            // Display file information
            document.getElementById('selected-file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-format').textContent = 'PDF';

            // Load PDF and count pages
            await loadPDFInfo(file);
        }
    }

    async function loadPDFInfo(file) {
        try {
            const arrayBuffer = await file.arrayBuffer();
            pdfDocument = await pdfjsLib.getDocument(arrayBuffer).promise;
            document.getElementById('pdf-pages').textContent = pdfDocument.numPages + ' pages';

            // بدء عداد إظهار الزر (3 ثواني)
            startButtonCountdown();

        } catch (error) {
            console.error('Error loading PDF:', error);
            document.getElementById('pdf-pages').textContent = 'Error reading file';
            Swal.fire({
                icon: 'error'
                , title: 'Error'
                , text: 'Failed to read the PDF file'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            document.getElementById('ad-box').classList.add('hidden');
            document.getElementById('banner-5-box').style.display = 'none';

        }
    }

    // دالة عداد إظهار الزر
    function startButtonCountdown() {
        let countdown = 3;
        const countdownElement = document.getElementById('btn-countdown');

        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                // إخفاء حالة التحميل وإظهار الزر
                document.getElementById('convert-btn-loading').classList.add('hidden');
                document.getElementById('convert-btn').classList.remove('hidden');
                // document.getElementById('banner-5-box').style.display = 'none';

            }
        }, 1000);
    }

    function selectAnotherFile() {
        console.log('Resetting UI to initial state');
        // Clear countdown timers if exist
        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }
        if (buttonPreparationTimer) {
            clearInterval(buttonPreparationTimer);
            buttonPreparationTimer = null;
        }

        document.getElementById('initial-content').style.display = 'block';
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('button-preparation-section').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');
        document.getElementById('countdown-section').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('banner-5-box').style.display = 'none';

        document.getElementById('download-section').classList.add('hidden');
        document.getElementById('file-input').value = '';
        selectedFile = null;
        pdfDocument = null;

        // Hide both banners when resetting
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');

        // Reset button state
        document.getElementById('convert-btn-text').textContent = 'Convert to JPG';
        document.getElementById('convert-btn').disabled = false;
        document.getElementById('convert-btn').classList.remove('opacity-50', 'cursor-not-allowed');
        document.getElementById('convert-btn').classList.add('hidden');
        document.getElementById('convert-btn-loading').classList.remove('hidden');
        document.getElementById('btn-countdown').textContent = '3';
    }

    function downloadAndReset() {
        // Trigger download (handled by <a> tag)
        console.log('Download button clicked, resetting UI');
        selectAnotherFile();
    }

    function startCountdown(zipBlob, fileName) {
        let countdown = 3;
        const countdownElement = document.getElementById('countdown-number');
        const countdownText = document.getElementById('countdown-text');
        const countdownCircle = document.getElementById('countdown-circle');

        // Show countdown section
        document.getElementById('progress-section').classList.add('hidden');
        document.getElementById('countdown-section').classList.remove('hidden');

        // Calculate circle circumference for animation
        const circumference = 2 * Math.PI * 36; // r = 36

        countdownTimer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            countdownText.textContent = countdown;

            // Update circle animation
            const progress = (3 - countdown) / 3;
            const offset = circumference - (progress * circumference);
            countdownCircle.style.strokeDashoffset = offset;

            if (countdown <= 0) {
                clearInterval(countdownTimer);
                countdownTimer = null;

                // Show download section
                document.getElementById('countdown-section').classList.add('hidden');
                document.getElementById('download-section').classList.remove('hidden');

                // Set up download
                const url = URL.createObjectURL(zipBlob);
                document.getElementById('download-btn').href = url;
                document.getElementById('download-btn').download = fileName;

                Swal.fire({
                    icon: 'success'
                    , title: 'تم التحويل بنجاح!'
                    , text: 'تم تحويل ملف PDF إلى صور JPG! اضغط على تحميل للحصول على الملف المضغوط. ✅'
                    , confirmButtonColor: '#10b981'
                    , confirmButtonText: 'موافق'
                });
            }
        }, 1000);
    }

    // دالة عداد تأخير الزر
    function startButtonPreparation() {
        return new Promise((resolve) => {
            let countdown = 3;
            const countdownElement = document.getElementById('button-countdown-number');
            const countdownText = document.getElementById('button-countdown-text');
            const countdownCircle = document.getElementById('button-countdown-circle');

            // Calculate circle circumference for animation
            const circumference = 2 * Math.PI * 36; // r = 36

            buttonPreparationTimer = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                countdownText.textContent = countdown;

                // Update circle animation
                const progress = (3 - countdown) / 3;
                const offset = circumference - (progress * circumference);
                countdownCircle.style.strokeDashoffset = offset;

                if (countdown <= 0) {
                    clearInterval(buttonPreparationTimer);
                    buttonPreparationTimer = null;
                    resolve(); // إنهاء الـ Promise عند انتهاء العداد
                }
            }, 1000);
        });
    }

    async function convertPDFToImages() {
        if (!selectedFile || !pdfDocument) return;

        // إخفاء كارت الملف وإظهار شريط التقدم مباشرة
        console.log('Starting conversion process');
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        const zip = new JSZip();
        const totalPages = pdfDocument.numPages;

        try {
            for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                // Update progress
                const progress = Math.floor((pageNum - 1) / totalPages * 90);
                document.getElementById('progress-bar').style.width = progress + '%';
                document.getElementById('progress-text').textContent = progress + '%';
                document.getElementById('progress-detail').textContent =
                    `Processing page ${pageNum} of ${totalPages}...`;

                // Get the page
                const page = await pdfDocument.getPage(pageNum);

                // Set scale for high quality (300 DPI equivalent)
                const scale = 2.5;
                const viewport = page.getViewport({
                    scale
                });

                // Create canvas
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render page to canvas
                const renderContext = {
                    canvasContext: context
                    , viewport: viewport
                };

                await page.render(renderContext).promise;

                // Convert canvas to blob
                const blob = await new Promise(resolve => {
                    canvas.toBlob(resolve, 'image/jpeg', 0.85);
                });

                // Add to zip
                const pageNumber = String(pageNum).padStart(3, '0');
                zip.file(`page_${pageNumber}.jpg`, blob);
            }

            // Final progress
            document.getElementById('progress-bar').style.width = '95%';
            document.getElementById('progress-text').textContent = '95%';
            document.getElementById('progress-detail').textContent = 'Creating ZIP file...';

            // Generate ZIP
            console.log('Generating ZIP file');
            const zipBlob = await zip.generateAsync({
                type: 'blob'
            });

            // Final progress
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-text').textContent = '100%';
            document.getElementById('progress-detail').textContent = 'Conversion completed!';

            // Start countdown
            const fileName = selectedFile.name.replace(/\.[^/.]+$/, '') + '_images.zip';
            startCountdown(zipBlob, fileName);

        } catch (error) {
            console.error('Conversion error:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Conversion Error'
                , text: 'Failed to convert PDF. Please try again.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            document.getElementById('progress-section').classList.add('hidden');
            selectAnotherFile();
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

</script>

<style>
    .drag-over {
        border-color: #3b82f6 !important;
        background-color: #dbeafe !important;
    }

    #countdown-circle,
    #button-countdown-circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    #countdown-section .text-center>svg {
        animation: pulse 2s infinite;
    }

</style>

@endsection

<style>
    #button-countdown-circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

</style>
