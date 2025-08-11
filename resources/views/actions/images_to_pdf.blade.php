@extends('layouts.app')

@section('title', 'Images to PDF')

@section('content')

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">Images to PDF</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                Convert multiple images (JPEG, PNG) to a single PDF document.
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">Drag image files here or</p>
                <button class="bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    Select Images
                </button>
                <p class="text-sm text-gray-500 mt-2">Supports: JPEG, PNG</p>
            </div>
        </div>

        <div id="file-card" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-gray-200">
                <div class="flex items-center justify-center mb-4">
                    <h3 id="selected-file-count" class="text-lg font-semibold text-gray-800 mb-1"></h3>
                </div>

                <button id="convert-btn" class="w-full bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 mb-3" onclick="uploadAndConvert()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Convert to PDF
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    Select Different Images
                </button>
            </div>
        </div>

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">Converting...</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
            </div>
        </div>

        <input type="file" id="file-input" accept="image/jpeg,image/png" multiple style="display: none;" onchange="handleFileSelect(event)">
    </div>
</div>

 
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');

    let selectedFiles = [];

    function openFilePicker() {
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
                return;
            }

            document.getElementById('initial-content').style.display = 'none';
            document.getElementById('file-card').classList.remove('hidden');

            document.getElementById('selected-file-count').textContent = `Selected ${selectedFiles.length} images`;
        }
    }

    function selectAnotherFile() {
        document.getElementById('initial-content').style.display = 'block';
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');
        fileInput.value = '';
        selectedFiles = [];
    }

async function uploadAndConvert() {
if (selectedFiles.length === 0) return;

document.getElementById('file-card').classList.add('hidden');
document.getElementById('progress-section').classList.remove('hidden');

const formData = new FormData();
selectedFiles.forEach(file => {
formData.append('imageFiles[]', file);
});

try {
const response = await fetch('/images-to-pdf', {
method: 'POST',
body: formData,
headers: {
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}
});

if (!response.ok) {
const errorData = await response.json();
if (response.status === 429) {
Swal.fire({
icon: 'error',
title: 'Daily Limit Exceeded',
text: errorData.error,
confirmButtonColor: '#3085d6',
confirmButtonText: 'OK'
});
selectAnotherFile();
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

const contentDisposition = response.headers.get('content-disposition');
let fileName = 'converted_images.pdf';
if (contentDisposition) {
const fileNameMatch = contentDisposition.match(/filename="(.+)"/);
if (fileNameMatch && fileNameMatch[1]) {
fileName = fileNameMatch[1];
}
}

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
title: 'Conversion Complete',
text: 'Your images have been converted to PDF successfully! ✅',
confirmButtonColor: '#3085d6',
confirmButtonText: 'OK'
});

setTimeout(() => {
selectAnotherFile();
}, 1000);
} catch (error) {
console.error('Error during conversion:', error);
Swal.fire({
icon: 'error',
title: 'Conversion Error',
text: `Failed to convert files: ${error.message}. Please try again.`,
confirmButtonColor: '#3085d6',
confirmButtonText: 'OK'
});
document.getElementById('progress-section').classList.add('hidden');
document.getElementById('initial-content').style.display = 'block';
}
}

</script>

@endsection
