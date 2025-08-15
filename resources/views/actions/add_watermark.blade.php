@extends('layouts.app')

@section('title', 'Add Watermark to PDF')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        {{-- banner 5 is hidden by default and only shown after file selection --}}
        <div id="banner-5-box" class="mt-6 hidden">
            @php $conversionBanner5 = App\Models\Banner::where('name', 'banner_5')->where('is_active', true)->first(); @endphp
            @if ($conversionBanner5 && $conversionBanner5->file_path)
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                @if ($conversionBanner5->isVideo())
                <video class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;" controls>
                    <source src="{{ $conversionBanner5->file_url }}" type="video/{{ $conversionBanner5->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner5->url }}" target="_blank">
                    <img class="width-height" src="{{ $conversionBanner5->file_url }}" alt="Banner 5" style="width: 100%; max-height: 300px; object-fit: cover;">
                </a>
                @endif
            </div>
            @else
            <p class="text-red-600">{{ __('messages.no_active_banner_found_5') }}</p>
            @endif
        </div>

        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.pdf_watermark') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.add_text_or_image_watermark') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_pdf_here_or') }}</p>
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
                    <video class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;" controls>
                        <source src="{{ $conversionBanner7->file_url }}" type="video/{{ $conversionBanner7->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner7->url }}" target="_blank">
                        <img class="width-height" src="{{ $conversionBanner7->file_url }}" alt="Banner 7" style="width: 100%; max-height: 300px; object-fit: cover;">
                    </a>
                    @endif
                </div>
                @else
                <p class="text-red-600">{{ __('messages.no_active_banner_found_7') }}</p>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto border-2 border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.pdf_preview') }}</h3>
                        <div id="pdf-preview" class="border-2 border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center relative overflow-hidden" style="height: 500px;">
                            <div class="text-center relative w-full h-full">
                                <svg id="initial-svg" class="w-16 h-16 text-red-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                <canvas id="pdf-canvas" style="max-width: 100%; max-height: 450px; position: relative; display: none;"></canvas>
                                <div id="watermark-preview" class="absolute pointer-events-none z-10" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="text-center mb-4">
                            <h3 id="selected-file-name" class="text-lg font-semibold text-gray-800 break-all mb-1"></h3>
                            <div class="flex justify-center gap-2 text-sm text-gray-600">
                                <span id="file-size"></span>
                                <span id="file-format" class="font-medium"></span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.watermark_type') }}</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="watermarkType" value="text" checked class="mr-2" onchange="toggleWatermarkType()">
                                    <span>{{ __('messages.text') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="watermarkType" value="image" class="mr-2" onchange="toggleWatermarkType()">
                                    <span>{{ __('messages.image') }}</span>
                                </label>
                            </div>
                        </div>

                        <div id="text-controls" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.watermark_text') }}</label>
                                <input type="text" id="watermark-text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="{{ __('messages.enter_watermark_text') }}" value="CONFIDENTIAL" onchange="updatePreview()">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.font_size') }}</label>
                                    <input type="range" id="font-size" min="20" max="100" value="50" class="w-full" oninput="updatePreview()">
                                    <span id="font-size-value" class="text-sm text-gray-600">50px</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.opacity') }}</label>
                                    <input type="range" id="opacity" min="0.1" max="1" step="0.1" value="0.3" class="w-full" oninput="updatePreview()">
                                    <span id="opacity-value" class="text-sm text-gray-600">30%</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.text_color') }}</label>
                                <input type="color" id="text-color" value="#ff0000" class="w-full h-10 border border-gray-300 rounded-lg" onchange="updatePreview()">
                            </div>
                        </div>

                        <div id="image-controls" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.watermark_image') }}</label>
                                <input type="file" id="watermark-image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" onchange="handleImageSelect(event)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.image_size') }}</label>
                                    <input type="range" id="image-size" min="50" max="300" value="150" class="w-full" oninput="updatePreview()">
                                    <span id="image-size-value" class="text-sm text-gray-600">150px</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.opacity') }}</label>
                                    <input type="range" id="image-opacity" min="0.1" max="1" step="0.1" value="0.3" class="w-full" oninput="updatePreview()">
                                    <span id="image-opacity-value" class="text-sm text-gray-600">30%</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.position') }}</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('top-left')" data-position="top-left">↖</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('top-center')" data-position="top-center">↑</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('top-right')" data-position="top-right">↗</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('middle-left')" data-position="middle-left">←</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100 bg-blue-100" onclick="setPosition('middle-center')" data-position="middle-center">●</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('middle-right')" data-position="middle-right">→</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('bottom-left')" data-position="bottom-left">↙</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('bottom-center')" data-position="bottom-center">↓</button>
                                <button class="p-2 border border-gray-300 rounded hover:bg-gray-100" onclick="setPosition('bottom-right')" data-position="bottom-right">↘</button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button id="preview-btn" class="w-full bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" onclick="previewWatermark()">
                                {{ __('messages.preview_watermark') }}
                            </button>

                            <button id="download-btn" class="w-full bg-green-600 text-white rounded-lg py-3 px-6 font-bold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 hidden" onclick="downloadWatermarkedFile()">
                                {{ __('messages.download_pdf_with_watermark') }}
                            </button>

                            <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                                {{ __('messages.select_another_file') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- banner 6 shows below the file card --}}
            <div id="banner-6-box" class="mt-6 hidden">
                @php $conversionBanner6 = App\Models\Banner::where('name', 'banner_6')->where('is_active', true)->first(); @endphp
                @if ($conversionBanner6 && $conversionBanner6->file_path)
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                    @if ($conversionBanner6->isVideo())
                    <video class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;" controls>
                        <source src="{{ $conversionBanner6->file_url }}" type="video/{{ $conversionBanner6->file_type }}">
                    </video>
                    @else
                    <a href="{{ $conversionBanner6->url }}" target="_blank">
                        <img class="width-height" src="{{ $conversionBanner6->file_url }}" alt="Banner 6" style="width: 100%; max-height: 300px; object-fit: cover;">
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
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.processing_watermark') }}</h4>
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
                <video class="width-height" style="width: 100%; max-height: 300px; object-fit: cover;" controls>
                    <source src="{{ $conversionBanner4->file_url }}" type="video/{{ $conversionBanner4->file_type }}">
                </video>
                @else
                <a href="{{ $conversionBanner4->url }}" target="_blank">
                    <img class="width-height" src="{{ $conversionBanner4->file_url }}" alt="Banner 4" style="width: 100%; max-height: 300px; object-fit: cover;">
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const downloadBtn = document.getElementById('download-btn');
    const previewBtn = document.getElementById('preview-btn');
    const pdfCanvas = document.getElementById('pdf-canvas');
    const initialSvg = document.getElementById('initial-svg');
    const watermarkPreview = document.getElementById('watermark-preview');

    let selectedFile = null;
    let pdfDoc = null;
    let currentPosition = 'middle-center';
    let watermarkImage = null;
    let hasWatermarkPreview = false;

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

    function setPosition(position) {
        currentPosition = position;

        // Update button styles
        document.querySelectorAll('[data-position]').forEach(btn => {
            btn.classList.remove('bg-blue-100');
        });
        document.querySelector(`[data-position="${position}"]`).classList.add('bg-blue-100');

        updatePreview();
    }

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
            hasWatermarkPreview = false;
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
            await renderPage();
        } catch (error) {
            console.error('Error loading PDF preview:', error);
            Swal.fire({
                icon: 'warning'
                , title: 'Preview Error'
                , text: 'Could not load PDF preview, but watermark will still work.'
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
            scale: 1.2
        });

        pdfCanvas.height = viewport.height;
        pdfCanvas.width = viewport.width;

        const renderContext = {
            canvasContext: context
            , viewport: viewport
        };

        await page.render(renderContext).promise;
        updatePreview();
    }

    function toggleWatermarkType() {
        const textControls = document.getElementById('text-controls');
        const imageControls = document.getElementById('image-controls');
        const textRadio = document.querySelector('input[name="watermarkType"][value="text"]');

        if (textRadio.checked) {
            textControls.classList.remove('hidden');
            imageControls.classList.add('hidden');
        } else {
            textControls.classList.add('hidden');
            imageControls.classList.remove('hidden');
        }
        updatePreview();
    }

    function handleImageSelect(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                watermarkImage = e.target.result;
                updatePreview();
            };
            reader.readAsDataURL(file);
        }
    }

    function updatePreview() {
        if (!pdfCanvas || pdfCanvas.style.display === 'none') return;

        const textRadio = document.querySelector('input[name="watermarkType"][value="text"]');

        if (textRadio.checked) {
            updateTextPreview();
        } else {
            updateImagePreview();
        }

        // Update slider values
        document.getElementById('font-size-value').textContent = document.getElementById('font-size').value + 'px';
        document.getElementById('opacity-value').textContent = Math.round(document.getElementById('opacity').value * 100) + '%';
        document.getElementById('image-size-value').textContent = document.getElementById('image-size').value + 'px';
        document.getElementById('image-opacity-value').textContent = Math.round(document.getElementById('image-opacity').value * 100) + '%';
    }

    function updateTextPreview() {
        const canvas = pdfCanvas;
        const previewDiv = watermarkPreview;

        if (!canvas || canvas.style.display === 'none') return;

        previewDiv.innerHTML = '';
        previewDiv.style.display = 'block';

        const text = document.getElementById('watermark-text').value;
        const fontSize = document.getElementById('font-size').value;
        const opacity = document.getElementById('opacity').value;
        const color = document.getElementById('text-color').value;

        const textElement = document.createElement('div');
        textElement.textContent = text;
        textElement.style.cssText = `
            font-size: ${Math.max(12, fontSize * 0.3)}px;
            color: ${color};
            opacity: ${opacity};
            font-weight: bold;
            text-align: center;
            pointer-events: none;
            white-space: nowrap;
            transform-origin: center center;
        `;

        previewDiv.appendChild(textElement);
        positionWatermark(previewDiv, canvas);
    }

    function updateImagePreview() {
        if (!watermarkImage) return;

        const canvas = pdfCanvas;
        const previewDiv = watermarkPreview;

        if (!canvas || canvas.style.display === 'none') return;

        previewDiv.innerHTML = '';
        previewDiv.style.display = 'block';

        const size = document.getElementById('image-size').value;
        const opacity = document.getElementById('image-opacity').value;

        const imageElement = document.createElement('img');
        imageElement.src = watermarkImage;
        imageElement.style.cssText = `
            width: ${Math.max(20, size * 0.3)}px;
            height: auto;
            opacity: ${opacity};
            pointer-events: none;
        `;

        previewDiv.appendChild(imageElement);
        positionWatermark(previewDiv, canvas);
    }

    function positionWatermark(watermarkElement, canvas) {
        if (!canvas || !watermarkElement) return;

        const canvasRect = canvas.getBoundingClientRect();
        const parentRect = canvas.parentElement.getBoundingClientRect();

        watermarkElement.style.position = 'absolute';
        watermarkElement.style.left = `${canvasRect.left - parentRect.left}px`;
        watermarkElement.style.top = `${canvasRect.top - parentRect.top}px`;
        watermarkElement.style.width = `${canvasRect.width}px`;
        watermarkElement.style.height = `${canvasRect.height}px`;

        watermarkElement.style.transform = '';

        const child = watermarkElement.firstChild;
        if (!child) return;

        child.style.position = 'absolute';

        let leftPercent, topPercent;

        switch (currentPosition) {
            case 'top-left':
                leftPercent = '15%';
                topPercent = '15%';
                break;
            case 'top-center':
                leftPercent = '50%';
                topPercent = '15%';
                child.style.transform += ' translateX(-50%)';
                break;
            case 'top-right':
                leftPercent = '85%';
                topPercent = '15%';
                child.style.transform += ' translateX(-100%)';
                break;
            case 'middle-left':
                leftPercent = '15%';
                topPercent = '50%';
                child.style.transform += ' translateY(-50%)';
                break;
            case 'middle-center':
                leftPercent = '50%';
                topPercent = '50%';
                child.style.transform += ' translate(-50%, -50%)';
                break;
            case 'middle-right':
                leftPercent = '85%';
                topPercent = '50%';
                child.style.transform += ' translate(-100%, -50%)';
                break;
            case 'bottom-left':
                leftPercent = '15%';
                topPercent = '85%';
                child.style.transform += ' translateY(-100%)';
                break;
            case 'bottom-center':
                leftPercent = '50%';
                topPercent = '85%';
                child.style.transform += ' translate(-50%, -100%)';
                break;
            case 'bottom-right':
                leftPercent = '85%';
                topPercent = '85%';
                child.style.transform += ' translate(-100%, -100%)';
                break;
        }

        child.style.left = leftPercent;
        child.style.top = topPercent;

        if (child.tagName === 'DIV') {
            child.style.transform += ' rotate(0deg)';
        }
    }

    function previewWatermark() {
        if (!selectedFile) return;

        hasWatermarkPreview = true;
        downloadBtn.classList.remove('hidden');

        Swal.fire({
            icon: 'success'
            , title: 'Preview Ready!'
            , text: 'Watermark preview applied. You can now download the PDF.'
            , confirmButtonColor: '#3085d6'
            , confirmButtonText: 'OK'
        });
    }

    async function downloadWatermarkedFile() {
        if (!selectedFile || !hasWatermarkPreview) {
            Swal.fire({
                icon: 'warning'
                , title: 'لا يوجد معاينة'
                , text: 'يرجى معاينة العلامة المائية أولاً.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'حسنًا'
            });
            return;
        }

        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        // إخفاء البانرات أثناء المعالجة
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        let progress = 0;
        const interval = setInterval(() => {
            progress += 5;
            if (progress >= 90) {
                clearInterval(interval);
                progress = 90;
            }
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('progress-text').textContent = progress + '%';
        }, 100);

        try {
            // قراءة الملف الأصلي
            const pdfBytes = await selectedFile.arrayBuffer();

            // تحميل PDF باستخدام PDF-lib
            const pdfDoc = await PDFLib.PDFDocument.load(pdfBytes);
            const pages = pdfDoc.getPages();

            const watermarkType = document.querySelector('input[name="watermarkType"]:checked').value;

            if (watermarkType === 'text') {
                // إضافة النص كعلامة مائية
                const text = document.getElementById('watermark-text').value || 'CONFIDENTIAL';
                const fontSize = parseInt(document.getElementById('font-size').value) || 50;
                const opacity = parseFloat(document.getElementById('opacity').value) || 0.3;
                const color = document.getElementById('text-color').value || '#ff0000';
                const rgb = hexToRgb(color);

                pages.forEach(page => {
                    const {
                        width
                        , height
                    } = page.getSize();
                    const {
                        x
                        , y
                    } = getPosition(currentPosition, width, height, fontSize);

                    page.drawText(text, {
                        x: x
                        , y: y
                        , size: fontSize
                        , color: PDFLib.rgb(rgb.r / 255, rgb.g / 255, rgb.b / 255)
                        , opacity: opacity
                    , });
                });
            } else if (watermarkType === 'image' && watermarkImage) {
                // إضافة الصورة كعلامة مائية
                const imageSize = parseInt(document.getElementById('image-size').value) || 150;
                const imageOpacity = parseFloat(document.getElementById('image-opacity').value) || 0.3;

                // تحويل الصورة إلى bytes
                const imageBytes = await fetch(watermarkImage).then(res => res.arrayBuffer());
                let image;

                // تحديد نوع الصورة وتضمينها
                if (watermarkImage.includes('data:image/png')) {
                    image = await pdfDoc.embedPng(imageBytes);
                } else {
                    image = await pdfDoc.embedJpg(imageBytes);
                }

                pages.forEach(page => {
                    const {
                        width
                        , height
                    } = page.getSize();
                    const {
                        x
                        , y
                    } = getImagePosition(currentPosition, width, height, imageSize);

                    page.drawImage(image, {
                        x: x
                        , y: y
                        , width: imageSize
                        , height: imageSize
                        , opacity: imageOpacity
                    , });
                });
            }

            // حفظ PDF المحدث
            const modifiedPdfBytes = await pdfDoc.save();

            clearInterval(interval);
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-text').textContent = '100%';

            // تحميل الملف
            const blob = new Blob([modifiedPdfBytes], {
                type: 'application/pdf'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = selectedFile.name.replace('.pdf', '_watermarked.pdf');
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);

            // تحديث عداد العمليات على الخادم
            await updateOperationCount();

            Swal.fire({
                icon: 'success'
                , title: 'تم التحميل بنجاح'
                , text: 'تم إضافة العلامة المائية وتحميل الملف بنجاح! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'حسنًا'
            });

            setTimeout(() => {
                selectAnotherFile();
            }, 2000);

        } catch (error) {
            clearInterval(interval);
            console.error('Error during watermark processing:', error);

            Swal.fire({
                icon: 'error'
                , title: 'خطأ في المعالجة'
                , text: 'حدث خطأ أثناء إضافة العلامة المائية: ' + error.message
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'حسنًا'
            });

            // إظهار البانرات مرة أخرى
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');

            document.getElementById('progress-section').classList.add('hidden');
            document.getElementById('file-card').classList.remove('hidden');
        }
    }

    // دالة لحساب موضع النص
    function getPosition(position, width, height, fontSize) {
        const margin = 50;
        let x, y;

        switch (position) {
            case 'top-left':
                x = margin;
                y = height - margin - fontSize;
                break;
            case 'top-center':
                x = width / 2;
                y = height - margin - fontSize;
                break;
            case 'top-right':
                x = width - margin;
                y = height - margin - fontSize;
                break;
            case 'middle-left':
                x = margin;
                y = height / 2;
                break;
            case 'middle-center':
                x = width / 2;
                y = height / 2;
                break;
            case 'middle-right':
                x = width - margin;
                y = height / 2;
                break;
            case 'bottom-left':
                x = margin;
                y = margin;
                break;
            case 'bottom-center':
                x = width / 2;
                y = margin;
                break;
            case 'bottom-right':
                x = width - margin;
                y = margin;
                break;
            default:
                x = width / 2;
                y = height / 2;
        }

        return {
            x
            , y
        };
    }

    // دالة لحساب موضع الصورة
    function getImagePosition(position, width, height, imageSize) {
        const margin = 20;
        let x, y;

        switch (position) {
            case 'top-left':
                x = margin;
                y = height - imageSize - margin;
                break;
            case 'top-center':
                x = (width - imageSize) / 2;
                y = height - imageSize - margin;
                break;
            case 'top-right':
                x = width - imageSize - margin;
                y = height - imageSize - margin;
                break;
            case 'middle-left':
                x = margin;
                y = (height - imageSize) / 2;
                break;
            case 'middle-center':
                x = (width - imageSize) / 2;
                y = (height - imageSize) / 2;
                break;
            case 'middle-right':
                x = width - imageSize - margin;
                y = (height - imageSize) / 2;
                break;
            case 'bottom-left':
                x = margin;
                y = margin;
                break;
            case 'bottom-center':
                x = (width - imageSize) / 2;
                y = margin;
                break;
            case 'bottom-right':
                x = width - imageSize - margin;
                y = margin;
                break;
            default:
                x = (width - imageSize) / 2;
                y = (height - imageSize) / 2;
        }

        return {
            x
            , y
        };
    }

    // دالة لتحديث عداد العمليات على الخادم
    async function updateOperationCount() {
        try {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            await fetch('/update-operation-count', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.log('Could not update operation count:', error);
        }
    }


    async function addTextWatermark(page, pdfDoc) {
        const text = document.getElementById('watermark-text').value;
        const fontSize = parseInt(document.getElementById('font-size').value);
        const opacity = parseFloat(document.getElementById('opacity').value);
        const color = document.getElementById('text-color').value;

        const rgb = hexToRgb(color);

        const {
            width
            , height
        } = page.getSize();
        let x, y;

        switch (currentPosition) {
            case 'top-left':
                x = 50;
                y = height - 50;
                break;
            case 'top-center':
                x = width / 2;
                y = height - 50;
                break;
            case 'top-right':
                x = width - 50;
                y = height - 50;
                break;
            case 'middle-left':
                x = 50;
                y = height / 2;
                break;
            case 'middle-center':
                x = width / 2;
                y = height / 2;
                break;
            case 'middle-right':
                x = width - 50;
                y = height / 2;
                break;
            case 'bottom-left':
                x = 50;
                y = 50;
                break;
            case 'bottom-center':
                x = width / 2;
                y = 50;
                break;
            case 'bottom-right':
                x = width - 50;
                y = 50;
                break;
        }

        page.drawText(text, {
            x: x
            , y: y
            , size: fontSize
            , color: PDFLib.rgb(rgb.r / 255, rgb.g / 255, rgb.b / 255)
            , opacity: opacity
            , rotate: PDFLib.degrees(0)
        });
    }

    async function addImageWatermark(page, pdfDoc) {
        if (!watermarkImage) return;

        const size = parseInt(document.getElementById('image-size').value);
        const opacity = parseFloat(document.getElementById('image-opacity').value);

        const imageBytes = await fetch(watermarkImage).then(res => res.arrayBuffer());
        const image = await pdfDoc.embedPng(imageBytes);

        const {
            width
            , height
        } = page.getSize();
        let x, y;

        switch (currentPosition) {
            case 'top-left':
                x = 20;
                y = height - size - 20;
                break;
            case 'top-center':
                x = (width - size) / 2;
                y = height - size - 20;
                break;
            case 'top-right':
                x = width - size - 20;
                y = height - size - 20;
                break;
            case 'middle-left':
                x = 20;
                y = (height - size) / 2;
                break;
            case 'middle-center':
                x = (width - size) / 2;
                y = (height - size) / 2;
                break;
            case 'middle-right':
                x = width - size - 20;
                y = (height - size) / 2;
                break;
            case 'bottom-left':
                x = 20;
                y = 20;
                break;
            case 'bottom-center':
                x = (width - size) / 2;
                y = 20;
                break;
            case 'bottom-right':
                x = width - size - 20;
                y = 20;
                break;
        }

        page.drawImage(image, {
            x: x
            , y: y
            , width: size
            , height: size
            , opacity: opacity
        });
    }

    function hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16)
            , g: parseInt(result[2], 16)
            , b: parseInt(result[3], 16)
        } : null;
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
        hasWatermarkPreview = false;
        watermarkImage = null;
        downloadBtn.classList.add('hidden');
        initialSvg.style.display = 'block';
        pdfCanvas.style.display = 'none';
        watermarkPreview.style.display = 'none';

        document.getElementById('watermark-text').value = 'CONFIDENTIAL';
        document.getElementById('font-size').value = 50;
        document.getElementById('opacity').value = 0.3;
        document.getElementById('text-color').value = '#ff0000';
        document.getElementById('image-size').value = 150;
        document.getElementById('image-opacity').value = 0.3;
        document.getElementById('watermark-image').value = '';
        document.querySelector('input[name="watermarkType"][value="text"]').checked = true;
        toggleWatermarkType();
        setPosition('middle-center');

        updatePreview();
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Set PDF.js worker
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
        }
    });

    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
    }

</script>

@endsection
