@extends('layouts.app')

@section('title', 'Rotate PDF')

@section('content')
{{-- Move the CSRF meta tag inside the head section of your layout or to the top of the content section --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        {{-- banner 5 is hidden by default and only shown after file selection --}}
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
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.pdf_rotation') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.rotate_pdf_pages_description') }}
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

        <div id="file-card" class="hidden mt-6">
            {{-- banner 7 shows above the file card --}}
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

            <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto border-2 border-gray-200">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.pdf_preview') }}</h3>
                    <div id="pdf-preview" class="border-2 border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center" style="height: 400px;">
                        <div class="text-center">
                            <svg id="initial-svg" class="w-16 h-16 text-red-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                            <canvas id="pdf-canvas" style="max-width: 100%; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h3 id="selected-file-name" class="text-lg font-semibold text-gray-800 break-all mb-1"></h3>
                    <div class="flex justify-center gap-2 text-sm text-gray-600">
                        <span id="file-size"></span>
                        <span id="file-format" class="font-medium"></span>
                    </div>
                </div>

                <div class="flex gap-4 justify-center mb-6">
                    <button id="rotate-left-btn" class="flex items-center justify-center bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" onclick="rotatePDF('left')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.334 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                        </svg>
                        {{ __('messages.rotate_left') }}
                    </button>

                    <button id="rotate-right-btn" class="flex items-center justify-center bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" onclick="rotatePDF('right')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path>
                        </svg>
                        {{ __('messages.rotate_right') }}
                    </button>
                </div>

                <button id="download-btn" class="w-full bg-yellow-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-yellow-600 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 mt-4" onclick="uploadAndRotate()">
                    {{ __('messages.download_rotated_pdf') }}
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors mt-4" onclick="selectAnotherFile()">
                    {{ __('messages.select_another_file') }}
                </button>
            </div>

            {{-- banner 6 shows below the file card --}}
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

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.rotating_pdf') }}</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
            </div>
        </div>

        {{-- banner 4 is hidden on initial load and shown only on file selection --}}
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const downloadBtn = document.getElementById('download-btn');
    const rotateLeftBtn = document.getElementById('rotate-left-btn');
    const rotateRightBtn = document.getElementById('rotate-right-btn');
    const pdfCanvas = document.getElementById('pdf-canvas');
    const initialSvg = document.getElementById('initial-svg');

    let selectedFile = null;
    let pdfDoc = null;
    let currentRotation = 0;

    // Event listener to hide banners on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
    });

    function openFilePicker() {
        document.getElementById('file-input').click();
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

    async function handleFileSelect(event) {
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
            currentRotation = 0;
            downloadBtn.classList.add('hidden');

            document.getElementById('initial-content').style.display = 'none';
            document.getElementById('file-card').classList.remove('hidden');

            // Show all banners when file is selected
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            document.getElementById('selected-file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-format').textContent = 'PDF';

            await loadPdfPreview(file);
        }
    }

    async function loadPdfPreview(file) {
        try {
            const arrayBuffer = await file.arrayBuffer();
            const loadingTask = pdfjsLib.getDocument(arrayBuffer);
            pdfDoc = await loadingTask.promise;

            renderPage();
        } catch (error) {
            console.error('Error loading PDF preview:', error);
            Swal.fire({
                icon: 'warning'
                , title: 'Preview Error'
                , text: 'Could not load PDF preview, but rotation will still work.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
        }
    }

    async function renderPage() {
        if (!pdfDoc) return;

        initialSvg.style.display = 'none';
        pdfCanvas.style.display = 'block';

        const page = await pdfDoc.getPage(1);
        const context = pdfCanvas.getContext('2d');

        const viewport = page.getViewport({
            scale: 1.5
            , rotation: currentRotation
        });

        pdfCanvas.height = viewport.height;
        pdfCanvas.width = viewport.width;

        const renderContext = {
            canvasContext: context
            , viewport: viewport
        };

        await page.render(renderContext).promise;
    }

    function selectAnotherFile() {
        document.getElementById('initial-content').style.display = 'block';
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');

        // Hide all banners when resetting
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        document.getElementById('file-input').value = '';
        selectedFile = null;
        pdfDoc = null;
        currentRotation = 0;
        downloadBtn.classList.add('hidden');
        initialSvg.style.display = 'block';
        pdfCanvas.style.display = 'none';
    }

    async function rotatePDF(direction) {
        if (!selectedFile) return;

        if (direction === 'left') {
            currentRotation -= 90;
        } else {
            currentRotation += 90;
        }

        currentRotation = (currentRotation % 360 + 360) % 360;

        await renderPage();

        downloadBtn.classList.remove('hidden');
    }

    async function uploadAndRotate() {
        if (!selectedFile) {
            Swal.fire({
                icon: 'warning'
                , title: 'No File Selected'
                , text: 'Please select a PDF file before attempting to rotate.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            return;
        }

        if (currentRotation === 0) {
            Swal.fire({
                icon: 'warning'
                , title: 'No Rotation Applied'
                , text: 'Please rotate the PDF before downloading.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            return;
        }


        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        // Hide all banners during processing
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        const formData = new FormData();
        formData.append('pdfFile', selectedFile);
        formData.append('rotation', currentRotation);

        try {
            const response = await fetch('/rotate-pdf', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                // For all other errors, including 500, show a generic message
                const errorText = await response.text();
                console.error("Server Error Response:", errorText);

                if (response.status === 429) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'The daily limit has been exceeded'
                        , text: 'You have exceeded your daily operation limit. Please try again tomorrow.'
                        , confirmButtonColor: '#3085d6'
                        , confirmButtonText: 'OK'
                    });
                } else if (response.status === 422) {
                    // Try to parse JSON for validation errors
                    try {
                        const errorData = JSON.parse(errorText);
                        Swal.fire({
                            icon: 'error'
                            , title: 'Validation Error'
                            , text: errorData.error || 'Invalid file format or size. Please try again.'
                            , confirmButtonColor: '#3085d6'
                            , confirmButtonText: 'OK'
                        });
                    } catch (e) {
                        Swal.fire({
                            icon: 'error'
                            , title: 'Rotation Error'
                            , text: 'An unexpected error occurred on the server. Please try again later.'
                            , confirmButtonColor: '#3085d6'
                            , confirmButtonText: 'OK'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Rotation Error'
                        , text: 'An error occurred on the server. Please try again later.'
                        , confirmButtonColor: '#3085d6'
                        , confirmButtonText: 'OK'
                    });
                }
                selectAnotherFile();
                return;
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

            const fileName = selectedFile.name.replace(/\.[^/.]+$/, '') + '_rotated.pdf';
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
                , title: 'Rotation Complete'
                , text: 'Your PDF has been rotated and downloaded successfully! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });

            setTimeout(() => {
                selectAnotherFile();
            }, 1500);
        } catch (error) {
            console.error('Error during rotation:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Rotation Error'
                , text: `Failed to rotate the file. Please check your network connection and try again.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });

            // Show banners again on error
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            setTimeout(() => {
                selectAnotherFile();
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

    // Set PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

</script>

@endsection
