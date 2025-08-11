@extends('layouts.app')

@section('title', 'Compress PDF')

@section('content')

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">Compress PDF</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                Reduce the size of your PDF files while maintaining quality.
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

                <button id="compress-btn" class="w-full bg-blue-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 mb-3" onclick="uploadAndCompress()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Compress PDF
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    Select Another File
                </button>
            </div>
        </div>

        <div id="progress-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">Compressing...</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-center text-sm text-gray-600 mt-2">0%</p>
            </div>
        </div>

        <!-- Success Section with Download Button -->
        <div id="success-section" class="hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto border-2 border-green-200">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <div class="text-center mb-4">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Compression Complete!</h3>
                    <div class="text-sm text-gray-600 mb-4">
                        <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                            <span>Original Size:</span>
                            <span id="original-size" class="font-semibold"></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-3 rounded-lg mt-2">
                            <span>Compressed Size:</span>
                            <span id="compressed-size" class="font-semibold text-green-700"></span>
                        </div>
                        <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg mt-2">
                            <span>Size Reduction:</span>
                            <span id="reduction-percentage" class="font-semibold text-blue-700"></span>
                        </div>
                    </div>
                </div>

                <button id="download-btn" class="w-full bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 mb-3" onclick="downloadFile()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Compressed PDF
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    Compress Another File
                </button>
            </div>
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
        fileInput.value = '';
        selectedFile = null;
        compressedFileBlob = null;
        compressedFileName = '';
    }

    async function uploadAndCompress() {
        if (!selectedFile) return;

        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

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
            document.getElementById('initial-content').style.display = 'block';
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
