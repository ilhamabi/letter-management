@extends('layouts.student')

@section('title', 'Buat Permintaan Baru - Layanan Dokumen')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $prodi = $user?->student?->study_program ?? 'D3 Teknik Informatika';
    $profilePhoto = null;

    $createLetterOptions = [];
    if (isset($letterTypes)) {
        foreach ($letterTypes as $type) {
            $createLetterOptions[] = [
                'value' => (string) $type->id,
                'label' => $type->name,
                'badge' => $type->allow_group_submission ? 'Kelompok' : 'Individu',
                'badgeClass' => $type->allow_group_submission 
                    ? 'bg-indigo-50 text-indigo-700 border-indigo-200' 
                    : 'bg-gray-50 text-gray-600 border-gray-200',
                'allowGroup' => $type->allow_group_submission ? 'true' : 'false'
            ];
        }
    }
@endphp

@section('content')
    <header class="mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-on-surface mb-2">Buat Permintaan Baru</h2>
        <p class="text-sm md:text-base text-on-surface-variant max-w-3xl leading-relaxed">
            Silakan lengkapi formulir di bawah ini untuk mengajukan permintaan dokumen akademik. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.
        </p>
    </header>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
        <div class="lg:col-span-8 bg-pure-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="pt-1 px-8 pb-8">
                <form class="space-y-8" id="request-form" action="{{ route('student.submissions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="letter_type_id">Jenis Surat</label>
                        <x-select-input 
                            name="letter_type_id" 
                            id="letter_type_id" 
                            placeholder="Pilih jenis surat..."
                            :options="$createLetterOptions" 
                            onchange="if(typeof toggleGroupMembersSection === 'function') toggleGroupMembersSection();"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="purpose">Keperluan</label>
                        <textarea name="purpose" id="purpose" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface text-sm resize-none" placeholder="Contoh: Pengajuan Beasiswa PPA, Persyaratan Magang di PT. Telkom..." rows="3" required>{{ old('purpose') }}</textarea>
                        <p class="text-xs text-on-surface-variant">Jelaskan secara singkat tujuan penggunaan dokumen ini.</p>
                    </div>

                    <!-- Optional Group Members Input (Hidden by default, shown if type allows group submission) -->
                    <div id="group-members-wrapper" class="hidden space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface">Anggota Kelompok (Opsional)</label>
                            <button type="button" id="btn-add-member" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1 cursor-pointer">
                                <x-icon name="add" class="w-4 h-4" />
                                <span>Tambah Anggota</span>
                            </button>
                        </div>
                        <p class="text-xs text-on-surface-variant">Masukkan NIM anggota jika pengajuan surat ini ditujukan untuk kelompok/tim.</p>
                        <div id="group-members-container" class="space-y-2"></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1">Lampiran Pendukung</label>
                            <p class="text-xs text-on-surface-variant mb-3">Unggah dokumen pendukung (KTM, Transkrip, atau Bukti Bayar) dalam format PDF (Maks. 2MB)</p>
                        </div>
                        
                        <!-- Hidden PDF Input (Multiple) -->
                        <input type="file" id="file-input" name="attachments[]" accept=".pdf,application/pdf" multiple class="hidden" />

                        <!-- Drag and Drop Zone -->
                        <div id="drop-zone" class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-surface-container-low/30 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <x-icon name="upload_file" class="w-7 h-7" />
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-on-surface text-sm">Tarik dan lepas berkas di sini</p>
                                <p class="text-xs text-on-surface-variant mt-1">atau</p>
                            </div>
                            <button id="btn-select-file" class="px-5 py-2 bg-pure-white border border-outline-variant rounded-lg text-primary text-sm font-semibold hover:bg-primary hover:text-on-primary transition-all" type="button">Pilih Berkas</button>
                        </div>

                        <!-- Error Message Alert -->
                        <div id="file-error-msg" class="hidden p-3 bg-error-container/40 border border-error/30 rounded-lg text-error text-xs flex items-center gap-2">
                            <x-icon name="error" class="w-4 h-4 shrink-0" />
                            <span id="file-error-text">Hanya berkas format PDF yang diperbolehkan!</span>
                        </div>

                        <!-- File Item List Container (Dynamic Multi-File Rendering) -->
                        <div class="space-y-2" id="file-list-container"></div>
                    </div>
                    <div class="pt-6 border-t border-outline-variant">
                        <button class="w-full bg-primary text-on-primary text-base font-semibold py-3.5 px-6 rounded-xl hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/10 flex items-center justify-center gap-2 cursor-pointer" id="submit-request-btn" type="button">
                            <x-icon name="send" class="w-5 h-5" />
                            Ajukan Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-primary-container text-on-primary-container p-6 rounded-xl border border-primary/10">
                <h4 class="font-title-lg text-[18px] font-bold mb-4 flex items-center gap-2">
                    <x-icon name="info" class="w-6 h-6" />
                    Informasi Penting
                </h4>
                <ul class="space-y-4 text-[13px] leading-relaxed">
                    <li class="flex gap-3">
                        <x-icon name="timer" class="w-4 h-4 shrink-0 text-primary-container-on mt-0.5" />
                        <span class="">Proses pengerjaan dokumen membutuhkan waktu 1<strong>-2 hari kerja</strong>.</span>
                    </li>
                    <li class="flex gap-3">
                        <x-icon name="download" class="w-4 h-4 shrink-0 text-primary-container-on mt-0.5" />
                        <span class="">Dokumen digital dapat diunduh langsung setelah status <strong>"Disetujui"</strong>.</span>
                    </li>
                </ul>
            </div>
            
            <div class="relative bg-secondary-container rounded-xl border border-secondary/20 overflow-hidden group">
                <div class="relative p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="font-title-lg text-[18px] font-bold text-on-secondary-container">Informasi Mahasiswa</h4>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pure-white flex items-center justify-center text-secondary shadow-sm">
                                <x-icon name="school" class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-[12px] text-on-secondary-container/70 font-medium">Status Akademik</p>
                                <p class="font-bold text-on-secondary-container">{{ $student?->academic_status ?? 'Aktif Kuliah' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">Total SKS</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">{{ $student?->total_credits ?? '0' }}</p>
                            </div>
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">IPK</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">{{ number_format($student?->gpa ?? 0, 2) }}</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-secondary/10">
                            <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Dosen Wali</p>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <x-icon name="person" class="w-5 h-5" />
                                </div>
                                <div>
                                    <p class="font-semibold text-on-secondary-container text-[14px]">{{ $academicAdvisor?->user?->name ?? 'Belum Ditentukan' }}</p>
                                    <p class="text-[12px] text-on-secondary-container/70">NIDN: {{ $academicAdvisor?->national_lecturer_number ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10 mt-4">
                                <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Ketua Program Studi</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <x-icon name="person" class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">{{ $kaprodi?->user?->name ?? 'Belum Ditentukan' }}</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: {{ $kaprodi?->national_lecturer_number ?? '—' }}</p>
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
    <x-modal id="confirmation-modal" :showHeader="false" maxWidth="max-w-md" zIndex="z-[100]" padding="p-8">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary shrink-0">
                <x-icon name="help" class="w-7 h-7" />
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
            <button class="flex-1 order-2 sm:order-1 py-3.5 px-4 rounded-xl border border-outline-variant text-on-surface font-label-lg hover:bg-surface-container-low transition-all active:scale-[0.98]" id="close-modal-btn" onclick="closeModal('confirmation-modal')">
                Batal
            </button>
            <button class="flex-1 order-1 sm:order-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2" id="confirm-submit-btn">
                <span>Ya, Ajukan</span>
                <x-icon name="check_circle" class="w-4 h-4" />
            </button>
        </div>
    </x-modal>
@endsection

@push('scripts')
<script>
    const openBtn = document.getElementById('submit-request-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const confirmBtn = document.getElementById('confirm-submit-btn');

    if (openBtn) openBtn.addEventListener('click', () => openModal('confirmation-modal'));
    if (closeBtn) closeBtn.addEventListener('click', () => closeModal('confirmation-modal'));
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            confirmBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg><span>Memproses...</span>';
            const form = document.getElementById('request-form');
            if (form) form.submit();
        });
    }

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
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"/><path d="M9 13v6"/></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-medium text-on-surface truncate">${file.name}</p>
                            <p class="text-[10px] text-on-surface-variant">${formatSize(file.size)}</p>
                        </div>
                    </div>
                    <button class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-error transition-colors shrink-0" type="button" onclick="deleteSelectedFile(${index})">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
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

    // Dynamic Group Members Input Handler & Show/Hide Listener
    const letterTypeSelect = document.getElementById('letter_type_id');
    const groupMembersWrapper = document.getElementById('group-members-wrapper');
    const btnAddMember = document.getElementById('btn-add-member');
    const groupMembersContainer = document.getElementById('group-members-container');

    function toggleGroupMembersSection() {
        if (!letterTypeSelect || !groupMembersWrapper) return;
        const val = letterTypeSelect.value;
        const letterOptions = @json($createLetterOptions);
        const selectedOpt = letterOptions.find(o => String(o.value) === String(val));
        const allowGroup = selectedOpt && selectedOpt.allowGroup === 'true';

        if (allowGroup) {
            groupMembersWrapper.classList.remove('hidden');
        } else {
            groupMembersWrapper.classList.add('hidden');
            if (groupMembersContainer) groupMembersContainer.innerHTML = '';
        }
    }

    if (letterTypeSelect) {
        letterTypeSelect.addEventListener('change', toggleGroupMembersSection);
        toggleGroupMembersSection();
    }

    if (btnAddMember && groupMembersContainer) {
        btnAddMember.addEventListener('click', () => {
            const memberCount = groupMembersContainer.children.length + 1;
            const inputHtml = `
                <div class="flex items-center gap-2 animate-fade-in">
                    <input type="text" name="group_members[]" placeholder="Masukkan NIM Anggota ${memberCount} (contoh: 21.11.1234)" class="flex-1 bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <button type="button" onclick="this.parentElement.remove()" class="p-2.5 text-on-surface-variant hover:text-error hover:bg-surface-container rounded-lg transition-colors cursor-pointer">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            `;
            groupMembersContainer.insertAdjacentHTML('beforeend', inputHtml);
        });
    }
</script>
@endpush
