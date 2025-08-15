@extends('layouts.app')

@section('title', 'PDF to Word')

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
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.pdf_to_word_conversion') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.convert_pdf_to_word_high_quality') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_pdf_file_here') }}</p>
                <button class="open--btn bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    {{ __('messages.select_pdf_file') }}
                </button>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.supports_pdf') }}</p>
            </div>
        </div>

        <div id="file-card" class="hidden mt-6" style="align-items: center; justify-content: center;">
            <div id="banner-7-box" class="mt-6">
                @php $conversionBanner7 = App\Models\Banner::where('name', 'banner_7')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner7 && $conversionBanner7->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner7->isVideo())
                    <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                        <source src="{{ $conversionBanner7->file_url }}" type="video/{{ $conversionBanner7->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner7->url }}" target="_blank">
                        <img src="{{ $conversionBanner7->file_url }}" alt="Banner 7" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
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

                <div id="pdf-info" class="text-center mb-4 hidden">
                </div>

                <div class="text-center mb-4">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-700">{{ __('messages.high_quality') }}</span>
                    </div>
                    <p id="conversion-note" class="text-xs text-gray-600">{{ __('messages.conversion_note') }}</p>
                </div>

                {{-- Countdown to show the convert button --}}
                <div id="convert-btn-loading" class="w-full mb-3">
                    <div class="bg-gray-100 rounded-lg py-3 px-6 text-center">
                        <svg class="w-6 h-6 inline mr-2 animate-spin text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span class="text-gray-600 font-medium">{{ __('messages.preparing_file') }} (<span id="btn-countdown">3</span>)</span>
                    </div>
                </div>

                <button id="convert-btn" class="hidden w-full bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 mb-3" onclick="uploadAndConvert()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    {{ __('messages.convert_to_word_button') }}
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    {{ __('messages.select_another_file') }}
                </button>
            </div>

            <div id="banner-6-box" class="mt-6">
                @php $conversionBanner6 = App\Models\Banner::where('name', 'banner_6')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner6 && $conversionBanner6->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner6->isVideo())
                    <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                        <source src="{{ $conversionBanner6->file_url }}" type="video/{{ $conversionBanner6->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner6->url }}" target="_blank">
                        <img src="{{ $conversionBanner6->file_url }}" alt="Banner 6" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                    </a>
                    @endif
                </div>
                @else
                <p class="text-red-600">{{ __('messages.no_active_banner_found_6') }}</p>
                @endif
            </div>
        </div>

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.converting') }}</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
                <p id="current-page" class="text-center text-xs text-gray-500 mt-1 hidden"></p>
            </div>
        </div>

        {{-- banner 4 is hidden on initial load and shown only on file selection --}}
        <div id="ad-box" class="hidden mt-6">
            @php
            $conversionBanner4 = App\Models\Banner::where('name', 'banner_4')->where('is_active', true)->first();
            @endphp
            @if ($conversionBanner4 && $conversionBanner4->file_path)
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                @if ($conversionBanner4->isVideo())
                <video id="ad-content" style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                    <source src="{{ $conversionBanner4->file_url }}" type="video/{{ $conversionBanner4->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner4->url }}" target="_blank">
                    <img id="ad-content" src="{{ $conversionBanner4->file_url }}" alt="Banner 4" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                </a>
                @endif
            </div>
            @else
            <p class="text-red-600">{{ __('messages.no_active_banner_found_4') }}</p>
            @endif
        </div>

        <input type="file" id="file-input" accept="application/pdf" style="display: none;" onchange="handleFileSelect(event)">
    </div>
</div>


<script>
    // Constants and state variables
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    let selectedFile = null;
    let buttonCountdownTimer = null;

    // Event listener to hide banners on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('convert-btn').classList.add('hidden');
        document.getElementById('convert-btn-loading').classList.remove('hidden');
    });

    function openFilePicker() {
        fileInput.value = '';
        fileInput.click();
    }

    // Handle drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect({
                target: {
                    files: files
                }
            });
        }
    });

    function handleFileSelect(event) {
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
                fileInput.value = '';
                return;
            }

            selectedFile = file;

            // Hide initial content
            document.getElementById('initial-content').style.display = 'none';

            // Show file card and banners
            document.getElementById('file-card').classList.remove('hidden');
            document.getElementById('file-card').classList.add('block');

            document.getElementById('ad-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            // Display file information
            document.getElementById('selected-file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-format').textContent = 'PDF';

            // Hide PDF-specific info
            document.getElementById('pdf-info').classList.add('hidden');

            // Start the button countdown
            startButtonCountdown();
        }
    }

    // New function to handle the countdown before showing the button
    function startButtonCountdown() {
        let countdown = 3;
        const countdownElement = document.getElementById('btn-countdown');
        document.getElementById('convert-btn-loading').classList.remove('hidden');
        document.getElementById('convert-btn').classList.add('hidden');

        buttonCountdownTimer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(buttonCountdownTimer);
                document.getElementById('convert-btn-loading').classList.add('hidden');
                document.getElementById('convert-btn').classList.remove('hidden');
            }
        }, 1000);
    }

    function selectAnotherFile() {
        resetToInitialState();
    }

    function resetToInitialState() {
        // Clear countdown timer if it's running
        if (buttonCountdownTimer) {
            clearInterval(buttonCountdownTimer);
            buttonCountdownTimer = null;
        }

        // Show initial content
        document.getElementById('initial-content').style.display = 'block';

        // Hide all other sections and banners
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');


        // Reset the selected file
        selectedFile = null;
        fileInput.value = '';

        // Reset progress bar
        document.getElementById('progress-bar').style.width = '0%';
        document.getElementById('progress-text').textContent = '0%';

        // Reset button state
        document.getElementById('convert-btn').classList.add('hidden');
        document.getElementById('convert-btn-loading').classList.remove('hidden');
        document.getElementById('btn-countdown').textContent = '3';
        dropZone.classList.remove('drag-over');
    }

    async function uploadAndConvert() {
        if (!selectedFile) return;

        // Hide file card and banners
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        document.getElementById('progress-section').classList.remove('hidden');

        const formData = new FormData();
        formData.append('pdfFile', selectedFile);

        try {
            const response = await fetch('/convert-pdf_to_word', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            , });

            if (!response.ok) {
                const errorData = await response.json();
                if (response.status === 429) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'The daily limit has been exceeded'
                        , text: errorData.error
                        , confirmButtonColor: '#3085d6'
                        , confirmButtonText: 'OK'
                    });
                    resetToInitialState();
                    return;
                }
                throw new Error(errorData.error || 'Server conversion failed');
            }

            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                if (progress >= 90) {
                    clearInterval(interval);
                    progress = 90;
                }
                document.getElementById('progress-bar').style.width = progress + '%';
                document.getElementById('progress-text').textContent = progress + '%';
            }, 300);

            const blob = await response.blob();
            clearInterval(interval);
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-text').textContent = '100%';

            const fileName = selectedFile.name.replace(/\.[^/.]+$/, '') + '.docx';
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success'
                , title: 'تم التحويل بنجاح'
                , text: 'تم تحويل ملفك إلى Word بنجاح! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'حسنًا'
            });

            setTimeout(() => {
                resetToInitialState();
            }, 1500);
        } catch (error) {
            console.error('Error during conversion:', error);
            Swal.fire({
                icon: 'error'
                , title: 'خطأ في التحويل'
                , text: `فشل تحويل الملف: ${error.message}. حاول مرة أخرى.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'حسنًا'
            });
            setTimeout(() => {
                resetToInitialState();
            }, 1000);
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

@endsection

