@extends('layouts.student')

@section('title', 'Buat Permintaan Baru - Layanan Dokumen')

@php
    // Default / Mock data so the submission page works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

@section('content')
    <header>
        <h3 class="font-headline-lg text-[32px] text-on-surface font-bold mb-3">Buat Permintaan Baru</h3>
        <p class="font-body-md text-on-surface-variant max-w-3xl leading-relaxed">
            Silakan lengkapi formulir di bawah ini untuk mengajukan permintaan dokumen akademik. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.
        </p>
    </header>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
        <div class="lg:col-span-8 bg-pure-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="pt-1 px-8 pb-8">
                <form class="space-y-8" id="request-form">
                    @csrf
                    <div class="space-y-2">
                        <label class="block font-label-lg text-on-surface mb-1" for="jenis_surat">Jenis Surat</label>
                        <div class="relative">
                            <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 appearance-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md" id="jenis_surat">
                                <option disabled="" selected="" value="">Pilih jenis surat...</option>
                                <option value="persetujuan_ta_non_reguler">Surat Persetujuan Tugas Akhir Jalur Non-Reguler</option>
                                <option value="rekomendasi_magang">Surat Rekomendasi Magang</option>
                                <option value="rekomendasi_pendadaran">Surat Rekomendasi Pendaftaran Pendadaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-label-lg text-on-surface mb-1" for="keperluan">Keperluan</label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md resize-none" id="keperluan" placeholder="Contoh: Pengajuan Beasiswa PPA, Persyaratan Magang di PT. Telkom..." rows="3"></textarea>
                        <p class="text-[12px] text-on-surface-variant">Jelaskan secara singkat tujuan penggunaan dokumen ini.</p>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-label-lg text-on-surface mb-1">Lampiran Pendukung</label>
                            <p class="text-[12px] text-on-surface-variant mb-3">Unggah dokumen pendukung (KTM, Transkrip, atau Bukti Bayar) dalam format PDF (Maks. 2MB)</p>
                        </div>
                        
                        <!-- Hidden PDF Input (Multiple) -->
                        <input type="file" id="file-input" name="attachments[]" accept=".pdf,application/pdf" multiple class="hidden" />

                        <!-- Drag and Drop Zone -->
                        <div id="drop-zone" class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-surface-container-low/30 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">upload_file</span>
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-on-surface">Tarik dan lepas berkas di sini</p>
                                <p class="text-xs text-on-surface-variant mt-1">atau</p>
                            </div>
                            <button id="btn-select-file" class="px-6 py-2 bg-pure-white border border-outline-variant rounded-lg text-primary font-label-md hover:bg-primary hover:text-on-primary transition-all" type="button">Pilih Berkas</button>
                        </div>

                        <!-- Error Message Alert -->
                        <div id="file-error-msg" class="hidden p-3 bg-error-container/40 border border-error/30 rounded-lg text-error text-xs flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">error</span>
                            <span id="file-error-text">Hanya berkas format PDF yang diperbolehkan!</span>
                        </div>

                        <!-- File Item List Container (Dynamic Multi-File Rendering) -->
                        <div class="space-y-2" id="file-list-container"></div>
                    </div>
                    <div class="pt-6 border-t border-outline-variant">
                        <button class="w-full bg-primary text-on-primary font-label-lg py-4 px-6 rounded-xl hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/10 flex items-center justify-center gap-2" id="submit-request-btn" type="button">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'wght' 600;">send</span>
                            Ajukan Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-primary-container text-on-primary-container p-6 rounded-xl border border-primary/10">
                <h4 class="font-title-lg text-[18px] font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">info</span>
                    Informasi Penting
                </h4>
                <ul class="space-y-4 text-[13px] leading-relaxed">
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">timer</span>
                        <span class="">Proses pengerjaan dokumen membutuhkan waktu 1<strong>-2 hari kerja</strong>.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">download</span>
                        <span class="">Dokumen digital dapat diunduh langsung setelah status <strong>"Disetujui"</strong>.</span>
                    </li>
                </ul>
            </div>
            
            <div class="relative bg-secondary-container rounded-xl border border-secondary/20 overflow-hidden group">
                <div class="relative p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="font-title-lg text-[18px] font-bold text-on-secondary-container">Informasi Mahasiswa</h4>
                        <!-- <span class="px-2 py-1 bg-pure-white/50 rounded-full text-[10px] font-bold text-secondary uppercase tracking-wider border border-secondary/20">Identity Verified</span> -->
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pure-white flex items-center justify-center text-secondary shadow-sm">
                                <span class="material-symbols-outlined text-[24px]">school</span>
                            </div>
                            <div>
                                <p class="text-[12px] text-on-secondary-container/70 font-medium">Status Akademik</p>
                                <p class="font-bold text-on-secondary-container">Aktif Kuliah</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">Total SKS</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">112</p>
                            </div>
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">IPK</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">3.85</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-secondary/10">
                            <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Dosen Wali</p>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">person_4</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-on-secondary-container text-[14px]">Heri Setyawan, M.Kom.</p>
                                    <p class="text-[12px] text-on-secondary-container/70">NIDN: 123456789</p>
                                    <p class="text-[12px] text-on-secondary-container/70">heri.s@amikom.ac.id</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10 mt-4">
                                <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Ketua Program Studi</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">person_3</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">Dr. Andi Wijaya, M.T.</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: 061234567</p>
                                        <p class="text-[12px] text-on-secondary-container/70">andi.w@amikom.ac.id</p>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10 mt-4">
                                <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Dosen Pembimbing</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">person_2</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">Siti Aminah, S.Kom., M.Cs.</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: 069876543</p>
                                        <p class="text-[12px] text-on-secondary-container/70">siti.a@amikom.ac.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 hidden" id="confirmation-modal">
        <div class="absolute inset-0 bg-deep-black/60 backdrop-blur-sm animate-fade-in" id="modal-backdrop"></div>
        <div class="relative z-10 bg-pure-white w-full max-w-md rounded-xl shadow-xl overflow-hidden transform animate-scale-up border border-outline-variant my-auto mx-auto">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'wght' 500;">help</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-[20px] font-bold text-on-surface leading-tight">Konfirmasi Pengajuan</h3>
                            <p class="text-on-surface-variant text-[12px] font-medium tracking-wide uppercase mt-0.5">Permintaan Dokumen</p>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-body-md mb-8 leading-relaxed">
                        Apakah Anda yakin data yang dimasukkan sudah benar? Permintaan yang sudah dikirim <span class="font-bold text-on-surface">tidak dapat diubah kembali</span>.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button class="flex-1 order-2 sm:order-1 py-3.5 px-4 rounded-xl border border-outline-variant text-on-surface font-label-lg hover:bg-surface-container-low transition-all active:scale-[0.98]" id="close-modal-btn">
                            Batal
                        </button>
                        <button class="flex-1 order-1 sm:order-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2" id="confirm-submit-btn">
                            <span>Ya, Ajukan</span>
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('confirmation-modal');
    const openBtn = document.getElementById('submit-request-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const backdrop = document.getElementById('modal-backdrop');
    const confirmBtn = document.getElementById('confirm-submit-btn');

    const toggleModal = (show) => {
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

    openBtn.addEventListener('click', () => toggleModal(true));
    closeBtn.addEventListener('click', () => toggleModal(false));
    backdrop.addEventListener('click', () => toggleModal(false));
    
    confirmBtn.addEventListener('click', () => {
        confirmBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span><span>Memproses...</span>';
        setTimeout(() => {
            toggleModal(false);
            confirmBtn.innerHTML = '<span>Ya, Ajukan</span><span class="material-symbols-outlined text-[18px]">check_circle</span>';
            alert('Permintaan Anda telah berhasil dikirim!');
        }, 1500);
    });

    // Multi-File PDF Upload Validation & Drag-and-Drop
    const fileInput = document.getElementById('file-input');
    const dropZone = document.getElementById('drop-zone');
    const btnSelectFile = document.getElementById('btn-select-file');
    const errorMsg = document.getElementById('file-error-msg');
    const errorText = document.getElementById('file-error-text');
    const fileListContainer = document.getElementById('file-list-container');

    let selectedFiles = [];

    const showError = (message) => {
        errorText.innerText = message;
        errorMsg.classList.remove('hidden');
    };

    const hideError = () => {
        errorMsg.classList.add('hidden');
    };

    const formatSize = (bytes) => {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    };

    const renderFileList = () => {
        fileListContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const itemHtml = `
                <div class="flex items-center justify-between p-3 bg-surface-container-lowest border border-outline-variant rounded-lg animate-fade-in">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-10 h-10 rounded bg-error/10 flex items-center justify-center text-error shrink-0">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-medium text-on-surface truncate">${file.name}</p>
                            <p class="text-[10px] text-on-surface-variant">${formatSize(file.size)}</p>
                        </div>
                    </div>
                    <button class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-error transition-colors shrink-0" type="button" onclick="deleteSelectedFile(${index})">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </div>
            `;
            fileListContainer.insertAdjacentHTML('beforeend', itemHtml);
        });
    };

    window.deleteSelectedFile = (index) => {
        selectedFiles.splice(index, 1);
        renderFileList();
        if (selectedFiles.length === 0) {
            hideError();
        }
    };

    const processFiles = (files) => {
        if (!files || files.length === 0) return;
        let invalidFormatCount = 0;
        let oversizedCount = 0;

        Array.from(files).forEach(file => {
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            if (!isPdf) {
                invalidFormatCount++;
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                oversizedCount++;
                return;
            }
            // Avoid duplicate file addition
            const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
            if (!exists) {
                selectedFiles.push(file);
            }
        });

        if (invalidFormatCount > 0) {
            showError('Format berkas tidak valid! Hanya berkas format PDF yang diperbolehkan.');
        } else if (oversizedCount > 0) {
            showError('Terdapat berkas yang ukurannya melebihi batas maksimal 2MB!');
        } else {
            hideError();
        }

        renderFileList();
    };

    // Trigger file dialog
    if (btnSelectFile && fileInput) {
        btnSelectFile.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.click();
        });
        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                processFiles(e.target.files);
            }
        });

        // Drag and Drop Events
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('bg-primary/5', 'border-primary');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('bg-primary/5', 'border-primary');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                processFiles(files);
            }
        });
    }
</script>
@endpush
