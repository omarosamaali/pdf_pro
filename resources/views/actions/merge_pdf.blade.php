@extends('layouts.app')

@section('title', 'Merge PDF')

@section('content')

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
            <h1 class="text-[24px] w-full md:text-[42px] font-bold text-[#33333b] my-2">{{ __('messages.merge_pdf') }}</h1>
            <p class="max-w-5xl mx-auto text-[16px] md:text-[22px] text-gray-700 mb-4">
                {{ __('messages.combine_multiple_pdf') }}
            </p>

            <div id="drop-zone" class="rounded-xl p-8 mb-4 transition-all duration-300 cursor-pointer border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-600 mb-2">{{ __('messages.drag_drop_pdf_files') }}</p>
                <button class="open--btn bg-black text-white rounded-xl p-3 w-[330px] h-[80px] text-[22px] font-bold hover:bg-gray-800 transition-colors" onclick="openFilePicker()">
                    {{ __('messages.select_pdf_files') }}
                </button>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.supports_pdf_multiple') }}</p>
            </div>
        </div>

        <div id="file-list-container" class="hidden mt-6">
            {{-- banner 7 shows above the file list --}}
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
                <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">{{ __('messages.selected_files') }}</h3>

                <div id="file-list" class="flex flex-col gap-2 mb-4" ondragover="event.preventDefault()">
                </div>

                <div class="flex justify-center flex-wrap gap-4 mt-6">
                    <button id="add-more-files-btn" class="bg-gray-200 text-gray-700 rounded-lg py-3 px-6 font-medium hover:bg-gray-300 transition-colors" onclick="openFilePicker()">
                        {{ __('messages.add_more_files') }}
                    </button>
                    <button id="merge-btn" class="bg-yellow-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-yellow-600 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50" onclick="mergeAndDownload()">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM4 11a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM4 15a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z"></path>
                        </svg>
                        {{ __('messages.merge_pdf_button') }}
                    </button>
                    <button id="cancel-btn" class="bg-red-500 text-white rounded-lg py-3 px-6 font-bold hover:bg-red-600 transition-colors" onclick="selectAnotherFile()">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>

            {{-- banner 6 shows below the file list --}}
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
                <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ __('messages.merging_files') }}</h4>
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

        <input type="file" id="file-input" accept="application/pdf" style="display: none;" onchange="handleFileSelect(event)" multiple>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const fileListContainer = document.getElementById('file-list-container');
    const fileList = document.getElementById('file-list');

    let selectedFiles = []; // Array to hold selected files

    // Event listener to hide banners on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
    });

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
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    function handleFileSelect(event) {
        const files = Array.from(event.target.files);
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length > 0) {
            // Filter to only accept PDF files
            const pdfFiles = files.filter(file => file.type === 'application/pdf');

            if (pdfFiles.length === 0) {
                Swal.fire({
                    icon: 'error'
                    , title: 'Invalid Files'
                    , text: 'Please select valid PDF files.'
                    , confirmButtonColor: '#3085d6'
                    , confirmButtonText: 'OK'
                });
                return;
            }

            selectedFiles = [...selectedFiles, ...pdfFiles];
            displayFiles();
        }
    }

    function displayFiles() {
        document.getElementById('initial-content').style.display = 'none';
        fileListContainer.classList.remove('hidden');

        // Show all banners when files are selected
        document.getElementById('banner-4-box').classList.remove('hidden');
        document.getElementById('banner-5-box').classList.remove('hidden');
        document.getElementById('banner-6-box').classList.remove('hidden');
        document.getElementById('banner-7-box').classList.remove('hidden');

        fileList.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'p-4', 'bg-gray-50', 'border', 'rounded-lg', 'draggable-item');
            fileItem.setAttribute('draggable', 'true');
            fileItem.dataset.index = index;

            fileItem.innerHTML = `
                <div class="flex items-center space-x-4">
                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-left">
                        <p class="font-semibold text-gray-800 break-all">${file.name}</p>
                        <p class="text-sm text-gray-500">${formatFileSize(file.size)}</p>
                    </div>
                </div>
                <button onclick="removeFile(${index})" class="text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            fileList.appendChild(fileItem);
        });

        addDragAndDropEvents();
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        if (selectedFiles.length === 0) {
            selectAnotherFile();
        } else {
            displayFiles();
        }
    }

    function selectAnotherFile() {
        document.getElementById('initial-content').style.display = 'block';
        fileListContainer.classList.add('hidden');
        document.getElementById('progress-section').classList.add('hidden');

        // Hide all banners when resetting
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');

        fileInput.value = '';
        selectedFiles = [];
    }

    // NEW: Drag and Drop Reordering
    let draggedItem = null;

    function addDragAndDropEvents() {
        const items = document.querySelectorAll('.draggable-item');
        items.forEach(item => {
            item.addEventListener('dragstart', () => {
                draggedItem = item;
                setTimeout(() => item.classList.add('dragging'), 0);
            });
            item.addEventListener('dragend', () => {
                draggedItem.classList.remove('dragging');
                draggedItem = null;
            });
            item.addEventListener('dragover', (e) => {
                e.preventDefault();
                const afterElement = getDragAfterElement(fileList, e.clientY);
                const dragging = document.querySelector('.dragging');
                if (afterElement == null) {
                    fileList.appendChild(dragging);
                } else {
                    fileList.insertBefore(dragging, afterElement);
                }
            });
        });
    }

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable-item:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return {
                    offset: offset
                    , element: child
                };
            } else {
                return closest;
            }
        }, {
            offset: Number.NEGATIVE_INFINITY
        }).element;
    }

    // NEW: Main merging logic
    async function mergeAndDownload() {
        if (selectedFiles.length < 2) {
            Swal.fire({
                icon: 'warning'
                , title: 'Insufficient Files'
                , text: 'Please select at least two PDF files to merge.'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            return;
        }

        // Update file order based on the DOM
        const orderedFileNames = Array.from(fileList.children).map(item => item.querySelector('p').textContent);
        const newSelectedFiles = [];
        orderedFileNames.forEach(name => {
            const originalFile = selectedFiles.find(file => file.name === name);
            if (originalFile) {
                newSelectedFiles.push(originalFile);
            }
        });
        selectedFiles = newSelectedFiles;

        // Hide file list and banners, show progress bar
        fileListContainer.classList.add('hidden');
        document.getElementById('banner-4-box').classList.add('hidden');
        document.getElementById('banner-5-box').classList.add('hidden');
        document.getElementById('banner-6-box').classList.add('hidden');
        document.getElementById('banner-7-box').classList.add('hidden');
        document.getElementById('progress-section').classList.remove('hidden');

        let progress = 0;
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');

        try {
            const mergedPdf = await PDFLib.PDFDocument.create();

            for (const [index, file] of selectedFiles.entries()) {
                const fileBytes = await file.arrayBuffer();
                const pdf = await PDFLib.PDFDocument.load(fileBytes);
                const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
                copiedPages.forEach(page => mergedPdf.addPage(page));

                // Update progress
                progress = Math.round(((index + 1) / selectedFiles.length) * 100);
                progressBar.style.width = progress + '%';
                progressText.textContent = `${progress}%`;
            }

            const mergedPdfBytes = await mergedPdf.save();
            const mergedFileBlob = new Blob([mergedPdfBytes], {
                type: 'application/pdf'
            });

            const fileName = `Merged_PDF_${Date.now()}.pdf`;
            const url = window.URL.createObjectURL(mergedFileBlob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success'
                , title: 'Merge Complete'
                , text: 'Your PDF files have been merged successfully! ✅'
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });

            setTimeout(() => {
                selectAnotherFile();
            }, 1000);

        } catch (error) {
            console.error('Error during merging:', error);
            Swal.fire({
                icon: 'error'
                , title: 'Merging Error'
                , text: `Failed to merge the files: ${error.message}. Please try again.`
                , confirmButtonColor: '#3085d6'
                , confirmButtonText: 'OK'
            });
            document.getElementById('progress-section').classList.add('hidden');
            fileListContainer.classList.remove('hidden');
            // Show banners again on error
            document.getElementById('banner-4-box').classList.remove('hidden');
            document.getElementById('banner-5-box').classList.remove('hidden');
            document.getElementById('banner-6-box').classList.remove('hidden');
            document.getElementById('banner-7-box').classList.remove('hidden');
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
