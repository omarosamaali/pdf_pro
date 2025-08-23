@extends('layouts.app')

@section('title', 'Compress PDF')

@section('content')

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
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
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.compress_pdf') }}</h1>

            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.compress_pdf_desc') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_drop_pdf_files') }}</p>
                <button class="open--btn bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    {{ __('messages.select_pdf_files') }}
                </button>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.supports_pdf_single') }}</p>
            </div>
        </div>

        <!-- File Card Section -->
        <div id="file-card" class="hidden mt-6">
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

            <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto border-2 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">{{ __('messages.selected_file') }}</h3>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg mb-4">
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                        </svg>
                        <div>
                            <p id="selected-file-name" class="font-medium text-gray-900"></p>
                            <div class="text-sm text-gray-500">
                                <span id="file-size"></span> • <span id="file-format"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center flex-wrap gap-4 mt-6">
                    <button id="compress-btn" class="bg-blue-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" onclick="uploadAndCompress()">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" />
                        </svg>
                        {{ __('messages.compress_pdf') }}
                    </button>
                    <button id="cancel-btn" class="bg-red-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-red-600 transition-colors" onclick="selectAnotherFile()">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>

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
                        <img src="{{ $conversionBanner6->file_url }}" alt="Banner 6" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
                    </a>
                    @endif
                </div>
                @else
                <p class="text-red-600">{{ __('messages.no_active_banner_found_6') }}</p>
                @endif
            </div>
        </div>

        <!-- Progress Section -->
        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.compressing_file') }}</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
            </div>
        </div>

        <!-- Success Section -->
        <div id="success-section" class="hidden mt-6">
            <div id="banner-6-box-success" class="mt-6 hidden">
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

            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('messages.compression_complete') }}</h3>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">{{ __('messages.original_size') }}:</span>
                            <span id="original-size" class="font-medium"></span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">{{ __('messages.compressed_size') }}:</span>
                            <span id="compressed-size" class="font-medium text-green-600"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">{{ __('messages.reduction') }}:</span>
                            <span id="reduction-percentage" class="font-medium text-green-600"></span>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4">
                        <button class="bg-green-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-green-600 transition-colors" onclick="downloadFile()">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" />
                            </svg>
                            {{ __('messages.download') }}
                        </button>
                        <button class="bg-gray-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-gray-600 transition-colors" onclick="selectAnotherFile()">
                            {{ __('messages.compress_another') }}
                        </button>
                    </div>
                </div>
            </div>

            <div id="banner-7-box-success" class="mt-6 hidden">
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
        </div>

        <div id="banner-4-box" class="hidden mt-6">
            @php $conversionBanner4 = App\Models\Banner::where('name', 'banner_4')->where('is_active', true)->first(); @endphp
            @if ($conversionBanner4 && $conversionBanner4->file_path)
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                @if ($conversionBanner4->isVideo())
                <video style="width: 100%; max-height: 300px; object-fit: cover;" class="width-height" controls>
                    <source src="{{ $conversionBanner4->file_url }}" type="video/{{ $conversionBanner4->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner4->url }}" target="_blank">
                    <img src="{{ $conversionBanner4->file_url }}" alt="Banner 4" class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;">
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
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');

    let selectedFile = null;
    let compressedFileBlob = null;
    let compressedFileName = '';

    // Event listener to hide banners on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
        document.getElementById('banner-6-box-success').classList.add('hidden');
        document.getElementById('banner-7-box-success').classList.add('hidden');
    });

    function openFilePicker() {
        fileInput.click();
    }

    // Handle drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
        dropZone.style.borderColor = '#3b82f6';
        dropZone.style.backgroundColor = '#eff6ff';
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

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
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

            document.getElementById('initial-content').style.display = 'none';
            document.getElementById('file-card').classList.remove('hidden');
            document.getElementById('success-section').classList.add('hidden');

            // Show banners 4, 5, 6, and 7 when file is selected
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            document.getElementById('selected-file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-format').textContent = 'PDF';
        }
    }

    function selectAnotherFile() {
        document.getElementById('initial-content').style.display = 'block';
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');
        document.getElementById('success-section').classList.add('hidden');

        // Hide all banners when resetting
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
        document.getElementById('banner-6-box-success').classList.add('hidden');
        document.getElementById('banner-7-box-success').classList.add('hidden');

        fileInput.value = '';
        selectedFile = null;
        compressedFileBlob = null;
        compressedFileName = '';
    }

    async function uploadAndCompress() {
        if (!selectedFile) return;

        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        // Hide all banners during processing
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
        document.getElementById('banner-6-box-success').classList.add('hidden');
        document.getElementById('banner-7-box-success').classList.add('hidden');

        const formData = new FormData();
        formData.append('pdfFile', selectedFile);

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

        try {
            const response = await fetch('/compress-pdf', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                clearInterval(interval);
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    throw new Error('Server error occurred. Please check server logs.');
                }
                const errorData = await response.json();
                if (response.status === 429) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Daily Limit Exceeded'
                        , text: errorData.error
                        , confirmButtonColor: '#3085d6'
                        , confirmButtonText: 'OK'
                    });
                    selectAnotherFile();
                    return;
                }
                throw new Error(errorData.error || 'Server compression failed');
            }

            // Store the compressed file
            const blob = await response.blob();
            compressedFileBlob = blob;

            clearInterval(interval);

            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-text').textContent = '100%';

            // Extract filename from headers
            const contentDisposition = response.headers.get('content-disposition');
            if (contentDisposition) {
                const fileNameMatch = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
                if (fileNameMatch && fileNameMatch[1]) {
                    compressedFileName = fileNameMatch[1].replace(/['"]/g, '');
                }
            }

            if (!compressedFileName && selectedFile) {
                const originalName = selectedFile.name;
                const nameWithoutExt = originalName.substring(0, originalName.lastIndexOf('.'));
                compressedFileName = `${nameWithoutExt}_compressed.pdf`;
            }

            // Show success section with file size comparison
            document.getElementById('progress-section').classList.add('hidden');
            document.getElementById('success-section').classList.remove('hidden');

            // Show banners 6 and 7 in the success section
            document.getElementById('banner-6-box-success').classList.remove('hidden');
            document.getElementById('banner-7-box-success').classList.remove('hidden');

            // Calculate and show size information
            const originalSize = selectedFile.size;
            const compressedSize = blob.size;
            const reduction = ((originalSize - compressedSize) / originalSize * 100).toFixed(1);

            document.getElementById('original-size').textContent = formatFileSize(originalSize);
            document.getElementById('compressed-size').textContent = formatFileSize(compressedSize);
            document.getElementById('reduction-percentage').textContent = reduction + '% smaller';

        } catch (error) {
            clearInterval(interval);
            console.error('Error during compression:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Compression Error'
                , text: `Failed to compress the file: ${error.message}. Please try again.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            document.getElementById('progress-section').classList.add('hidden');
            document.getElementById('file-card').classList.remove('hidden');

            // Re-show banners 4, 5, 6, and 7 on error
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');
        }
    }

    function downloadFile() {
        if (!compressedFileBlob) return;

        const url = window.URL.createObjectURL(compressedFileBlob);
        const a = document.createElement('a');
        a.href = url;
        a.download = compressedFileName;
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);

        Swal.fire({
            icon: 'success'
            , title: 'Download Started!'
            , text: 'Your compressed PDF is being downloaded.'
            , timer: 2000
            , showConfirmButton: false
        });
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
    #drop-zone.drag-over {
        border-color: #3b82f6 !important;
        background-color: #eff6ff !important;
    }

</style>
@endsection
