@extends('layouts.app')

@section('title', 'PDF to PowerPoint')

@section('content')

<div class="px-4 py-0 text-center bg-gray-100">
    <div class="mx-auto max-w-7xl py-5">
        <div id="initial-content">
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">PDF to PowerPoint Conversion</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                Convert any PDF to PowerPoint (.pptx) with high quality
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

                <div id="pdf-info" class="text-center mb-4 hidden">
                </div>

                <div class="text-center mb-4">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-700">High Quality</span>
                    </div>
                    <p id="conversion-note" class="text-xs text-gray-600">The file will be converted to a PowerPoint document (.pptx)</p>
                </div>

                <button id="convert-btn" class="w-full bg-green-600 text-white rounded-lg py-3 px-6 font-semibold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 mb-3" onclick="uploadAndConvert()">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Convert to PowerPoint
                </button>

                <button class="w-full bg-gray-200 text-gray-700 rounded-lg py-2 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="selectAnotherFile()">
                    Select Another File
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

        <input type="file" id="file-input" accept="application/pdf" style="display: none;" onchange="handleFileSelect(event)">
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');

    let selectedFile = null;

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
                return;
            }

            selectedFile = file;

            // Hide initial content
            document.getElementById('initial-content').style.display = 'none';

            // Show file card
            document.getElementById('file-card').classList.remove('hidden');

            // Display file information
            document.getElementById('selected-file-name').textContent = file.name;
            document.getElementById('file-size').textContent = formatFileSize(file.size);
            document.getElementById('file-format').textContent = 'PDF';

            // Hide PDF-specific info
            document.getElementById('pdf-info').classList.add('hidden');
        }
    }

    function selectAnotherFile() {
        document.getElementById('initial-content').style.display = 'block';
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');
        document.getElementById('file-input').value = '';
        selectedFile = null;
    }

    async function uploadAndConvert() {
        if (!selectedFile) return;

        // Hide file card and show progress bar
        document.getElementById('file-card').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        const formData = new FormData();
        formData.append('pdfFile', selectedFile);

        try {
            // Send file to the server
            const response = await fetch('/convert-pdf_to_powerpoint', {
                method: 'POST'
                , body: formData
                , headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                if (response.status === 429) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'The daily limit has been exceeded'
                        , text: errorData.error || 'You have exceeded your daily operation limit.'
                        , confirmButtonColor: '#3085d6'
                        , confirmButtonText: 'OK'
                    });
                    selectAnotherFile();
                    return;
                }
                throw new Error(errorData.error || 'Server conversion failed');
            }

            // Fake progress for UI
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

            // Download the converted file
            const blob = await response.blob();
            clearInterval(interval);

            // Final progress update
            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('progress-text').textContent = '100%';

            const fileName = selectedFile.name.replace(/\.[^/.]+$/, '') + '.pptx';
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
                , title: 'Conversion Complete'
                , text: 'Your file has been converted to PowerPoint successfully! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });

            setTimeout(() => {
                selectAnotherFile();
            }, 1500);
        } catch (error) {
            console.error('Error during conversion:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Conversion Error'
                , text: `Failed to convert the file: ${error.message}. Please try again.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
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

</script>

@endsection
