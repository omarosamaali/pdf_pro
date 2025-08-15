@extends('layouts.app')

@section('title', 'Images to PDF')

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
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.images_to_pdf') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.convert_multiple_images') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_image_files_here_or') }}</p>
                <button class="open--btn bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    {{ __('messages.select_images') }}
                </button>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.supports_jpeg_png') }}</p>
            </div>
        </div>

        <div id="file-card" class="hidden mt-6" style="align-items: center; justify-content: center;">
            {{-- عرض البانر 7 فوق بطاقة الملف --}}
            <div id="banner-7-box" class="mt-6 hidden">
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
                    <h3 id="selected-file-count" class="text-lg font-semibold text-gray-800 mb-1"></h3>
                </div>

                {{-- Countdown to show the convert button --}}
                <div id="convert-btn-loading" class="w-full mb-3">
                    <div class="bg-gray-100 rounded-lg py-3 px-6 text-center">
                        <svg class="w-6 h-6 inline mr-2 animate-spin text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-gray-600 font-medium">{{ __('messages.preparing_file') }} (<span id="btn-countdown">3</span>)</span>
                    </div>
                </div>

                <button id="convert-btn" class="hidden w-full bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 mb-3" onclick="uploadAndConvert()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    {{ __('messages.convert_to_pdf') }}
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    {{ __('messages.select_different_images') }}
                </button>
            </div>

            {{-- عرض البانر 6 تحت بطاقة الملف --}}
            <div id="banner-6-box" class="mt-6 hidden">
                @php $conversionBanner6 = App\Models\Banner::where('name', 'banner_6')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner6 && $conversionBanner6->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner6->isVideo())
                    <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                        <source src="{{ $conversionBanner6->file_url }}" type="video/{{ $conversionBanner6->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner6->url }}" target="_blank">
                        <img src="{{ $conversionBanner6->file_url }}" alt="Banner 6" sclass="width-height" tyle="width: 100%; max-height: 300px; object-fit: cover;">
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
            </div>
        </div>

        {{-- عرض البانر 4 أثناء عملية التحويل --}}
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

        <input type="file" id="file-input" accept="image/jpeg,image/png" multiple style="display: none;" onchange="handleFileSelect(event)">
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    let selectedFiles = [];
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
        const files = event.target.files;
        if (files.length > 0) {
            selectedFiles = Array.from(files).filter(file => file.type === 'image/jpeg' || file.type === 'image/png');

            if (selectedFiles.length === 0) {
                Swal.fire({
                    icon: 'error'
                    , title: 'Invalid Files'
                    , text: 'Please select valid JPEG or PNG image files'
                    , confirmButtonColor: '#3085d6'
                    , confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }

            // Hide initial content
            document.getElementById('initial-content').style.display = 'none';

            // Show file card and banners
            document.getElementById('file-card').classList.remove('hidden');
            document.getElementById('file-card').classList.add('block');

            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('ad-box').classList.remove('hidden');

            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            // Display file information
            document.getElementById('selected-file-count').textContent = `Selected ${selectedFiles.length} images`;

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

        // Reset the selected files
        selectedFiles = [];
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
        if (selectedFiles.length === 0) return;

        // Hide file card and banners
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('ad-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        // Show progress section and ad banner
        document.getElementById('progress-section').classList.remove('hidden');
        document.getElementById('ad-box').classList.remove('hidden');

        const formData = new FormData();
        selectedFiles.forEach(file => {
            formData.append('images[]', file);
        });

        try {
            const response = await fetch('/convert-images_to_pdf', {
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

            const fileName = 'converted.pdf';
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
                , title: 'Conversion Successful'
                , text: 'Your images have been successfully converted to a PDF! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });

            setTimeout(() => {
                resetToInitialState();
            }, 1500);
        } catch (error) {
            console.error('Error during conversion:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Conversion Error'
                , text: `File conversion failed: ${error.message}. Please try again.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            setTimeout(() => {
                resetToInitialState();
            }, 1000);
        }
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
