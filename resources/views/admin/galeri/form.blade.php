@extends('layouts.admin-main')

@section('title', 'Tambah Galeri')

@section('admin-main')
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100/50 pt-0 pb-8">
        <div class="w-full">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Tambah Galeri Baru</h1>
                    <p class="mt-1 text-sm text-slate-600">Unggah beberapa gambar untuk galeri kamar</p>
                </div>
                <a href="{{ route('galeri.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form id="galeri-form" enctype="multipart/form-data" class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                @csrf

                <div class="border-b border-slate-200 bg-gradient-to-r from-cyan-50 to-blue-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-600 text-white shadow-lg">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Upload Gambar</h2>
                            <p class="text-sm text-slate-600">Pilih beberapa gambar untuk ditambahkan ke galeri</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Gambar Galeri <span class="text-rose-500">*</span>
                        </label>
                        <div id="drop-zone"
                            class="group relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/50 transition-all hover:border-cyan-400 hover:bg-cyan-50/50">
                            <input type="file" name="gambar[]" accept="image/*" id="gambar-input" multiple class="hidden">

                            <div id="upload-area" class="flex flex-col items-center justify-center px-6 py-12 text-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/30">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                </div>
                                <button type="button" onclick="document.getElementById('gambar-input').click()"
                                    class="mb-3 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                                    <i class="fa-solid fa-image"></i>
                                    Pilih Gambar
                                </button>
                                <p class="text-sm font-medium text-slate-700">atau seret dan lepas file di sini</p>
                                <p class="mt-2 text-xs text-slate-500">PNG, JPG, WEBP hingga 2MB per gambar</p>
                                <p class="mt-1 text-xs text-slate-400">Dapat memilih multiple gambar</p>
                            </div>

                            <div id="preview-container" class="hidden p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="image-grid">
                                    <!-- Preview images will be added here -->
                                </div>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500" id="file-count">Belum ada gambar yang dipilih</p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 border-t border-slate-200 bg-slate-50 px-8 py-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-600">
                        <i class="fa-solid fa-circle-info text-cyan-600"></i>
                        Pastikan gambar sudah sesuai sebelum mengupload
                    </p>
                    <div class="flex gap-3">
                        <button type="button" onclick="resetForm()"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </button>
                        <button type="submit" id="submit-btn" disabled
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-cyan-500/30 transition-all hover:shadow-xl hover:shadow-cyan-500/40 disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
                            <i class="fa-solid fa-check"></i>
                            Upload Gambar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedFiles = [];
        let previewCount = 0;

        const gambarInput = document.getElementById('gambar-input');
        const uploadArea = document.getElementById('upload-area');
        const previewContainer = document.getElementById('preview-container');
        const imageGrid = document.getElementById('image-grid');
        const fileCount = document.getElementById('file-count');
        const submitBtn = document.getElementById('submit-btn');
        const dropZone = document.getElementById('drop-zone');

        // Handle file selection
        gambarInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        // Drag and drop functionality
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-cyan-500', 'bg-cyan-100/50');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-cyan-500', 'bg-cyan-100/50');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-cyan-500', 'bg-cyan-100/50');
            handleFiles(e.dataTransfer.files);
        });

        function handleFiles(files) {
            const validFiles = Array.from(files).filter(file =>
                file.type.startsWith('image/') && file.size <= 2 * 1024 * 1024
            );

            if (validFiles.length === 0) {
                alert('Harap pilih file gambar yang valid (maksimal 2MB per file)');
                return;
            }

            // Add new files to selectedFiles array
            validFiles.forEach(file => {
                selectedFiles.push(file);
            });

            updatePreview();
            updateFileCount();
            updateSubmitButton();
        }

        function updatePreview() {
            // Clear existing previews
            imageGrid.innerHTML = '';

            // Create preview for each file
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewId = `preview-${previewCount++}`;

                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group bg-white rounded-lg border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-all';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-48 object-cover">
                        <div class="p-3">
                            <p class="text-sm font-medium text-slate-700 truncate">${file.name}</p>
                            <p class="text-xs text-slate-500">${formatFileSize(file.size)}</p>
                        </div>
                        <button type="button" onclick="removeImage(${index})" 
                            class="absolute top-2 right-2 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-slate-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:text-rose-600 opacity-0 group-hover:opacity-100">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    `;

                    imageGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });

            // Show/hide preview container
            if (selectedFiles.length > 0) {
                previewContainer.classList.remove('hidden');
                uploadArea.classList.add('hidden');
            } else {
                previewContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
            }
        }

        function removeImage(index) {
            // Remove file from selectedFiles array
            selectedFiles.splice(index, 1);

            // Update preview and file count
            updatePreview();
            updateFileCount();
            updateSubmitButton();

            // If no files left, show upload area
            if (selectedFiles.length === 0) {
                previewContainer.classList.add('hidden');
                uploadArea.classList.remove('hidden');
            }
        }

        function updateFileCount() {
            const count = selectedFiles.length;
            if (count === 0) {
                fileCount.textContent = 'Belum ada gambar yang dipilih';
            } else if (count === 1) {
                fileCount.textContent = '1 gambar dipilih';
            } else {
                fileCount.textContent = `${count} gambar dipilih`;
            }
        }

        function updateSubmitButton() {
            submitBtn.disabled = selectedFiles.length === 0;
        }

        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function resetForm() {
            selectedFiles = [];
            gambarInput.value = '';
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            updateFileCount();
            updateSubmitButton();
        }

        document.getElementById('galeri-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Pastikan tidak submit biasa

            if (selectedFiles.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Harap pilih minimal satu gambar',
                    timer: 3000,
                    position: "top-end",
                    toast: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-xl'
                    }
                });
                return;
            }

            const formData = new FormData();
            selectedFiles.forEach(file => {
                formData.append('gambar[]', file);
            });
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengunggah...';

            fetch("{{ route('galeri.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // opsional, tapi bagus untuk kejelasan
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err?.message || 'Terjadi kesalahan validasi.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        throw new Error('Respons tidak valid dari server.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengupload gambar. Silakan coba lagi.',
                        timer: 3000,
                        position: "top-end",
                        toast: true,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-xl'
                        }
                    });
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });
    </script>
@endsection
