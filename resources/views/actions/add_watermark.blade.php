

@extends('layouts.app')

@section('title', 'Add Watermark to PDF')

@section('content')

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">PDF Watermark</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                Add text or image watermark to your PDF with custom positioning
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">Drag the PDF file here or</p>
                <button class="bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    Select PDF file
                </button>
                <p class="text-sm text-gray-500 mt-2">Supports: PDF</p>
            </div>
        </div>

        <div id="file-card" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto border-2 border-gray-200">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- PDF Preview Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">PDF Preview</h3>
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

                    <!-- Watermark Controls Section -->
                    <div class="space-y-4">
                        <div class="text-center mb-4">
                            <h3 id="selected-file-name" class="text-lg font-semibold text-gray-800 break-all mb-1"></h3>
                            <div class="flex justify-center gap-2 text-sm text-gray-600">
                                <span id="file-size"></span>
                                <span id="file-format" class="font-medium"></span>
                            </div>
                        </div>

                        <!-- Watermark Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Watermark Type</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="watermarkType" value="text" checked class="mr-2" onchange="toggleWatermarkType()">
                                    <span>Text</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="watermarkType" value="image" class="mr-2" onchange="toggleWatermarkType()">
                                    <span>Image</span>
                                </label>
                            </div>
                        </div>

                        <!-- Text Watermark Controls -->
                        <div id="text-controls" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Watermark Text</label>
                                <input type="text" id="watermark-text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter watermark text" value="CONFIDENTIAL" onchange="updatePreview()">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Font Size</label>
                                    <input type="range" id="font-size" min="20" max="100" value="50" class="w-full" oninput="updatePreview()">
                                    <span id="font-size-value" class="text-sm text-gray-600">50px</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Opacity</label>
                                    <input type="range" id="opacity" min="0.1" max="1" step="0.1" value="0.3" class="w-full" oninput="updatePreview()">
                                    <span id="opacity-value" class="text-sm text-gray-600">30%</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Text Color</label>
                                <input type="color" id="text-color" value="#ff0000" class="w-full h-10 border border-gray-300 rounded-lg" onchange="updatePreview()">
                            </div>
                        </div>

                        <!-- Image Watermark Controls -->
                        <div id="image-controls" class="hidden space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Watermark Image</label>
                                <input type="file" id="watermark-image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" onchange="handleImageSelect(event)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                    <input type="range" id="image-size" min="50" max="300" value="150" class="w-full" oninput="updatePreview()">
                                    <span id="image-size-value" class="text-sm text-gray-600">150px</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Opacity</label>
                                    <input type="range" id="image-opacity" min="0.1" max="1" step="0.1" value="0.3" class="w-full" oninput="updatePreview()">
                                    <span id="image-opacity-value" class="text-sm text-gray-600">30%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Position Controls -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
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

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button id="preview-btn" class="w-full bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" onclick="previewWatermark()">
                                Preview Watermark
                            </button>

                            <button id="download-btn" class="w-full bg-green-600 text-white rounded-lg py-3 px-6 font-bold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 hidden" onclick="downloadWatermarkedFile()">
                                Download PDF with Watermark
                            </button>

                            <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                                Select Another File
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">Processing Watermark...</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
            </div>
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
            // transform: rotate(-45deg);
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

        // الحصول على أبعاد الكانفس الفعلية
        const canvasRect = canvas.getBoundingClientRect();
        const parentRect = canvas.parentElement.getBoundingClientRect();

        // تعيين موضع العلامة المائية نسبة للكانفس
        watermarkElement.style.position = 'absolute';
        watermarkElement.style.left = `${canvasRect.left - parentRect.left}px`;
        watermarkElement.style.top = `${canvasRect.top - parentRect.top}px`;
        watermarkElement.style.width = `${canvasRect.width}px`;
        watermarkElement.style.height = `${canvasRect.height}px`;

        // إعادة تعيين التحويلات
        watermarkElement.style.transform = '';

        const child = watermarkElement.firstChild;
        if (!child) return;

        // تحديد موضع العنصر الفرعي داخل العلامة المائية
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

        // إضافة الدوران للنص
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
icon: 'warning',
title: 'لا يوجد معاينة',
text: 'يرجى معاينة العلامة المائية أولاً.',
confirmButtonColor: '#3085d6',
confirmButtonText: 'حسنًا'
});
return;
}

document.getElementById('file-card').classList.add('hidden');
document.getElementById('progress-section').classList.remove('hidden');

let progress = 0;
const interval = setInterval(() => {
progress += 10;
if (progress >= 95) {
clearInterval(interval);
progress = 95;
}
document.getElementById('progress-bar').style.width = progress + '%';
document.getElementById('progress-text').textContent = progress + '%';
}, 150);

try {
const formData = new FormData();
formData.append('pdfFile', selectedFile);
formData.append('watermarkType', document.querySelector('input[name="watermarkType"]:checked').value);
formData.append('position', currentPosition);

if (formData.get('watermarkType') === 'text') {
formData.append('watermarkText', document.getElementById('watermark-text').value);
formData.append('fontSize', document.getElementById('font-size').value);
formData.append('opacity', document.getElementById('opacity').value);
formData.append('textColor', document.getElementById('text-color').value);
} else {
const watermarkImageInput = document.getElementById('watermark-image');
if (watermarkImageInput.files[0]) {
formData.append('watermarkImage', watermarkImageInput.files[0]);
}
formData.append('imageSize', document.getElementById('image-size').value);
formData.append('imageOpacity', document.getElementById('image-opacity').value);
}

const response = await fetch('/watermark-pdf', {
method: 'POST',
body: formData,
headers: {
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
},
});

if (!response.ok) {
const errorData = await response.json();
clearInterval(interval);
if (response.status === 429) {
Swal.fire({
icon: 'error',
title: 'تم تجاوز الحد اليومي',
text: errorData.message,
confirmButtonColor: '#3085d6',
confirmButtonText: 'حسنًا'
});
selectAnotherFile();
return;
}
throw new Error(errorData.message || 'Server processing failed');
}

clearInterval(interval);
document.getElementById('progress-bar').style.width = '100%';
document.getElementById('progress-text').textContent = '100%';

const blob = await response.blob();
const fileName = selectedFile.name.replace(/\.[^/.]+$/, '') + '_watermarked.pdf';
const url = window.URL.createObjectURL(blob);
const a = document.createElement('a');
a.href = url;
a.download = fileName;
document.body.appendChild(a);
a.click();
a.remove();
window.URL.revokeObjectURL(url);

Swal.fire({
icon: 'success',
title: 'تم التحميل بنجاح',
text: 'تم إضافة العلامة المائية وتحميل الملف بنجاح! ✅',
confirmButtonColor: '#3085d6',
confirmButtonText: 'حسنًا'
});

setTimeout(() => {
selectAnotherFile();
}, 1000);
} catch (error) {
clearInterval(interval);
console.error('Error during download:', error);
Swal.fire({
icon: 'error',
title: 'خطأ في التحميل',
text: `فشل تحميل الملف: ${error.message}. حاول مرة أخرى.`,
confirmButtonColor: '#3085d6',
confirmButtonText: 'حسنًا'
});
document.getElementById('progress-section').classList.add('hidden');
document.getElementById('file-card').classList.remove('hidden');
}
}

    async function addTextWatermark(page, pdfDoc) {
        const text = document.getElementById('watermark-text').value;
        const fontSize = parseInt(document.getElementById('font-size').value);
        const opacity = parseFloat(document.getElementById('opacity').value);
        const color = document.getElementById('text-color').value;

        // Convert hex to RGB
        const rgb = hexToRgb(color);

        const {
            width
            , height
        } = page.getSize();
        let x, y;

        // Calculate position
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

        // Convert base64 to image
        const imageBytes = await fetch(watermarkImage).then(res => res.arrayBuffer());
        const image = await pdfDoc.embedPng(imageBytes);

        const {
            width
            , height
        } = page.getSize();
        let x, y;

        // Calculate position
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
        document.getElementById('file-input').value = '';
        selectedFile = null;
        pdfDoc = null;
        hasWatermarkPreview = false;
        watermarkImage = null;
        downloadBtn.classList.add('hidden');
        initialSvg.style.display = 'block';
        pdfCanvas.style.display = 'none';
        watermarkPreview.style.display = 'none';

        // Reset form values
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

        // تحديث القيم المعروضة
        updatePreview();
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // تحديث مسار PDF.js worker عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
        }
    });

    // Set PDF.js worker - تحديث مسار العامل
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
    }

</script>

@endsection
