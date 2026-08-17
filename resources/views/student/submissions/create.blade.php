@extends('layouts.student')

@section('title', 'Buat Permintaan Baru - Layanan Dokumen')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $prodi = $student?->study_program ?? 'D3 Teknik Informatika';
    $profilePhoto = null;
    $letterTypesApproversJson = json_encode($letterTypesWithApprovers ?? []);

    $createLetterOptions = [];
    if (isset($letterTypes)) {
        foreach ($letterTypes as $type) {
            $bodyContent = strtolower($type->activeTemplate?->body_content ?? '');
            $hasCompanyFields = str_contains($bodyContent, 'company_name') 
                || str_contains($bodyContent, 'company_address') 
                || str_contains($bodyContent, 'start_date') 
                || str_contains($bodyContent, 'end_date');

            $hasThesisFields = str_contains($bodyContent, 'thesis_title');

            $createLetterOptions[] = [
                'value' => (string) $type->id,
                'label' => $type->name,
                'code' => $type->code,
                'badge' => $type->allow_group_submission ? 'Kelompok' : 'Individu',
                'badgeClass' => $type->allow_group_submission 
                    ? 'bg-indigo-50 text-indigo-700 border-indigo-200' 
                    : 'bg-gray-50 text-gray-600 border-gray-200',
                'allowGroup' => $type->allow_group_submission ? 'true' : 'false',
                'hasCompanyFields' => $hasCompanyFields ? 'true' : 'false',
                'hasThesisFields' => $hasThesisFields ? 'true' : 'false',
                'minGpa' => (float) ($type->minimum_gpa ?? 0),
                'minCredits' => (int) ($type->minimum_credits ?? 0),
                'requiresAttachment' => $type->requires_attachment ? 'true' : 'false',
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
                <form class="space-y-6" id="request-form" action="{{ route('student.submissions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3 text-red-700 animate-fade-in shadow-xs">
                            <x-icon name="error" class="w-5 h-5 text-red-600 shrink-0 mt-0.5" />
                            <div class="text-sm">
                                <p class="font-bold text-red-800 mb-1">Pengajuan Belum Dapat Dikirim!</p>
                                <p class="text-xs text-red-600 mb-2">Mohon lengkapi atau perbaiki kolom berikut:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs font-medium">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Client-side error alert container (for JS validation) -->
                    <div id="js-validation-alert" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3 text-red-700 animate-fade-in shadow-xs">
                        <x-icon name="error" class="w-5 h-5 text-red-600 shrink-0 mt-0.5" />
                        <div class="text-sm">
                            <p class="font-bold text-red-800 mb-1">Mohon Lengkapi Formulir Pengajuan!</p>
                            <ul id="js-validation-list" class="list-disc list-inside space-y-1 text-xs font-medium"></ul>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="letter_type_id">
                            Jenis Surat <span class="text-red-500">*</span>
                        </label>
                        <x-select-input 
                            name="letter_type_id" 
                            id="letter_type_id" 
                            placeholder="Pilih jenis surat..."
                            :options="$createLetterOptions" 
                            onchange="if(typeof toggleGroupMembersSection === 'function') toggleGroupMembersSection();"
                        />
                        <p id="error-letter_type_id" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                            <x-icon name="error" class="w-3.5 h-3.5" />
                            <span id="error-letter_type_id-text">Jenis Surat wajib dipilih.</span>
                        </p>
                        @error('letter_type_id')
                            <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                <x-icon name="error" class="w-3.5 h-3.5" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="purpose">
                            Keperluan / Alasan Pengajuan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="purpose" id="purpose" class="w-full bg-surface-container-lowest border @error('purpose') border-red-500 @else border-outline-variant @enderror rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface text-sm resize-none" placeholder="Contoh: Pengajuan Beasiswa PPA, Persyaratan Magang di PT. Telkom, Pendaftaran Pendadaran..." rows="3">{{ old('purpose') }}</textarea>
                        <p class="text-xs text-on-surface-variant">Jelaskan secara singkat tujuan penggunaan dokumen ini.</p>
                        <p id="error-purpose" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                            <x-icon name="error" class="w-3.5 h-3.5" />
                            <span id="error-purpose-text">Keperluan / Alasan Pengajuan wajib diisi.</span>
                        </p>
                        @error('purpose')
                            <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                <x-icon name="error" class="w-3.5 h-3.5" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Dynamic Group Name Input -->
                    <div id="group-name-wrapper" class="hidden space-y-2 pt-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="group_name">Nama Kelompok / Tim</label>
                        <input type="text" name="group_name" id="group_name" value="{{ old('group_name') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Contoh: Tim Stronger Production">
                    </div>

                    <!-- Dynamic Thesis Title Input -->
                    <div id="thesis-fields-wrapper" class="hidden space-y-2 pt-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="thesis_title">
                            Judul Tugas Akhir / Proyek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="thesis_title" id="thesis_title" value="{{ old('thesis_title') }}" class="w-full bg-surface-container-lowest border @error('thesis_title') border-red-500 @else border-outline-variant @enderror focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl px-4 py-3 text-sm text-on-surface" placeholder="Contoh: Rancang Bangun Aplikasi Manajemen Produksi di STRONGER MANUFACTURE">
                        <p id="error-thesis_title" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                            <x-icon name="error" class="w-3.5 h-3.5" />
                            <span id="error-thesis_title-text">Judul Tugas Akhir / Proyek wajib diisi.</span>
                        </p>
                        @error('thesis_title')
                            <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                <x-icon name="error" class="w-3.5 h-3.5" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Dynamic Internship / Institution Information Inputs -->
                    <div id="company-fields-wrapper" class="hidden space-y-4 pt-2 border-t border-outline-variant/60">
                        <div class="flex items-center gap-2 text-primary font-bold text-sm">
                            <x-icon name="business" class="w-5 h-5" />
                            <span>Informasi Perusahaan / Instansi Tujuan Magang</span>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="company_name">
                                Nama Perusahaan / Instansi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="w-full bg-surface-container-lowest border @error('company_name') border-red-500 @else border-outline-variant @enderror focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl px-4 py-3 text-sm text-on-surface" placeholder="Contoh: PT Telkom Indonesia (Persero) Tbk">
                            <p id="error-company_name" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                <x-icon name="error" class="w-3.5 h-3.5" />
                                <span id="error-company_name-text">Nama Perusahaan / Instansi wajib diisi.</span>
                            </p>
                            @error('company_name')
                                <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                    <x-icon name="error" class="w-3.5 h-3.5" />
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="company_address">
                                Alamat Instansi / Perusahaan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="company_address" id="company_address" rows="2" class="w-full bg-surface-container-lowest border @error('company_address') border-red-500 @else border-outline-variant @enderror focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl px-4 py-3 text-sm text-on-surface resize-none" placeholder="Contoh: Jl. Jend. Sudirman No. 52, Jakarta">{{ old('company_address') }}</textarea>
                            <p id="error-company_address" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                <x-icon name="error" class="w-3.5 h-3.5" />
                                <span id="error-company_address-text">Alamat Instansi / Perusahaan wajib diisi.</span>
                            </p>
                            @error('company_address')
                                <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                    <x-icon name="error" class="w-3.5 h-3.5" />
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Start Date Picker -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="start_date_display">
                                    Tanggal Mulai Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative cursor-pointer" onclick="try{document.getElementById('start_date_input').showPicker()}catch(e){}">
                                    <input id="start_date_display" type="text" placeholder="Pilih tanggal mulai..." readonly class="w-full bg-surface-container-lowest border @error('start_date') border-red-500 @else border-outline-variant @enderror focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl pl-4 pr-10 py-3 text-sm text-on-surface transition-all cursor-pointer">
                                    <input id="start_date_input" name="start_date" type="date" value="{{ old('start_date') }}" onchange="updateCreateDateDisplays()" class="sr-only">
                                    <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                                </div>
                                <p id="error-start_date" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                    <x-icon name="error" class="w-3.5 h-3.5" />
                                    <span id="error-start_date-text">Tanggal Mulai Kegiatan wajib diisi.</span>
                                </p>
                                @error('start_date')
                                    <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                        <x-icon name="error" class="w-3.5 h-3.5" />
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- End Date Picker -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-1" for="end_date_display">
                                    Tanggal Selesai Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative cursor-pointer" onclick="try{document.getElementById('end_date_input').showPicker()}catch(e){}">
                                    <input id="end_date_display" type="text" placeholder="Pilih tanggal selesai..." readonly class="w-full bg-surface-container-lowest border @error('end_date') border-red-500 @else border-outline-variant @enderror focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl pl-4 pr-10 py-3 text-sm text-on-surface transition-all cursor-pointer">
                                    <input id="end_date_input" name="end_date" type="date" value="{{ old('end_date') }}" onchange="updateCreateDateDisplays()" class="sr-only">
                                    <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                                </div>
                                <p id="error-end_date" class="hidden text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                    <x-icon name="error" class="w-3.5 h-3.5" />
                                    <span id="error-end_date-text">Tanggal Selesai Kegiatan wajib diisi.</span>
                                </p>
                                @error('end_date')
                                    <p class="text-xs text-red-600 font-semibold mt-1 flex items-center gap-1">
                                        <x-icon name="error" class="w-3.5 h-3.5" />
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>
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

                    <div class="space-y-4 pt-2">
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

                        @error('attachments')
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-xs flex items-center gap-2 font-medium">
                                <x-icon name="error" class="w-4 h-4 text-red-600 shrink-0" />
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

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
                            <p class="text-xs text-on-secondary-container/80 font-bold uppercase tracking-wider mb-2">Dosen Yang Akan Mereview</p>
                            
                            <div id="lecturers-list-container" class="space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-pure-white/20 rounded-lg border border-secondary/10">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary/50 shrink-0">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                    </div>
                                    <p class="text-xs text-on-secondary-container/70 italic">Silakan pilih jenis surat terlebih dahulu untuk melihat dosen yang akan mereview pengajuan Anda.</p>
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

    const studentGpa = {{ (float) ($student->gpa ?? 0) }};
    const studentCredits = {{ (int) ($student->total_credits ?? 0) }};

    function validateCreateForm() {
        let isValid = true;
        const errors = [];

        // Reset previous inline errors
        document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        document.getElementById('js-validation-alert')?.classList.add('hidden');

        const letterTypeIdInput = document.getElementById('letter_type_id');
        const purposeInput = document.getElementById('purpose');
        const thesisTitleInput = document.getElementById('thesis_title');
        const companyNameInput = document.getElementById('company_name');
        const companyAddressInput = document.getElementById('company_address');
        const startDateInput = document.getElementById('start_date_input');
        const endDateInput = document.getElementById('end_date_input');

        const companyWrapper = document.getElementById('company-fields-wrapper');
        const thesisWrapper = document.getElementById('thesis-fields-wrapper');

        const val = letterTypeIdInput ? letterTypeIdInput.value : '';
        const letterOptions = @json($createLetterOptions);
        const selectedOpt = letterOptions.find(o => String(o.value) === String(val));

        // 1. Validate Jenis Surat Selection
        if (!letterTypeIdInput || !val.trim()) {
            isValid = false;
            errors.push('Jenis Surat wajib dipilih');
            document.getElementById('error-letter_type_id')?.classList.remove('hidden');
        } else if (selectedOpt) {
            // Validate Minimum SKS & GPA Academic Requirements
            const minGpa = parseFloat(selectedOpt.minGpa || 0);
            const minCredits = parseInt(selectedOpt.minCredits || 0, 10);
            const reqAttachment = selectedOpt.requiresAttachment === 'true';

            if (minGpa > 0 && studentGpa < minGpa) {
                isValid = false;
                errors.push(`IPK Anda (${studentGpa.toFixed(2)}) belum memenuhi syarat minimal IPK (${minGpa.toFixed(2)})`);
                document.getElementById('error-letter_type_id')?.classList.remove('hidden');
            }

            if (minCredits > 0 && studentCredits < minCredits) {
                isValid = false;
                errors.push(`Total SKS Anda (${studentCredits} SKS) belum memenuhi syarat minimal SKS (${minCredits} SKS)`);
                document.getElementById('error-letter_type_id')?.classList.remove('hidden');
            }

            if (reqAttachment && selectedFiles.length === 0) {
                isValid = false;
                errors.push('Jenis surat ini mewajibkan pengunggahan setidaknya 1 berkas lampiran pendukung');
                showError('Wajib mengunggah minimal 1 berkas lampiran pendukung dalam format PDF!');
            }
        }

        // 2. Validate Keperluan
        if (!purposeInput || !purposeInput.value.trim()) {
            isValid = false;
            errors.push('Keperluan / Alasan Pengajuan wajib diisi');
            purposeInput?.classList.add('border-red-500');
            document.getElementById('error-purpose')?.classList.remove('hidden');
        } else {
            purposeInput?.classList.remove('border-red-500');
        }

        // 3. Validate Thesis Title if wrapper is visible
        if (thesisWrapper && !thesisWrapper.classList.contains('hidden')) {
            if (!thesisTitleInput || !thesisTitleInput.value.trim()) {
                isValid = false;
                errors.push('Judul Tugas Akhir / Proyek wajib diisi');
                thesisTitleInput?.classList.add('border-red-500');
                document.getElementById('error-thesis_title')?.classList.remove('hidden');
            } else {
                thesisTitleInput?.classList.remove('border-red-500');
            }
        }

        // 4. Validate Company Fields if wrapper is visible
        if (companyWrapper && !companyWrapper.classList.contains('hidden')) {
            if (!companyNameInput || !companyNameInput.value.trim()) {
                isValid = false;
                errors.push('Nama Perusahaan / Instansi wajib diisi');
                companyNameInput?.classList.add('border-red-500');
                document.getElementById('error-company_name')?.classList.remove('hidden');
            } else {
                companyNameInput?.classList.remove('border-red-500');
            }

            if (!companyAddressInput || !companyAddressInput.value.trim()) {
                isValid = false;
                errors.push('Alamat Instansi / Perusahaan wajib diisi');
                companyAddressInput?.classList.add('border-red-500');
                document.getElementById('error-company_address')?.classList.remove('hidden');
            } else {
                companyAddressInput?.classList.remove('border-red-500');
            }

            if (!startDateInput || !startDateInput.value.trim()) {
                isValid = false;
                errors.push('Tanggal Mulai Kegiatan wajib diisi');
                document.getElementById('start_date_display')?.classList.add('border-red-500');
                document.getElementById('error-start_date')?.classList.remove('hidden');
            } else {
                document.getElementById('start_date_display')?.classList.remove('border-red-500');
            }

            if (!endDateInput || !endDateInput.value.trim()) {
                isValid = false;
                errors.push('Tanggal Selesai Kegiatan wajib diisi');
                document.getElementById('end_date_display')?.classList.add('border-red-500');
                document.getElementById('error-end_date')?.classList.remove('hidden');
            } else {
                document.getElementById('end_date_display')?.classList.remove('border-red-500');
            }
        }

        if (!isValid) {
            const alertBox = document.getElementById('js-validation-alert');
            const alertList = document.getElementById('js-validation-list');
            if (alertBox && alertList) {
                alertList.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
                alertBox.classList.remove('hidden');
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        return isValid;
    }

    if (openBtn) {
        openBtn.addEventListener('click', (e) => {
            if (validateCreateForm()) {
                openModal('confirmation-modal');
            }
        });
    }
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

    const syncFileInput = () => {
        if (!fileInput) return;
        try {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        } catch (e) {
            console.warn('DataTransfer sync warning:', e);
        }
    };

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

        syncFileInput();
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

    // Dynamic Group Members & Letter Type Specific Field Handler
    const letterTypeSelect = document.getElementById('letter_type_id');
    const groupMembersWrapper = document.getElementById('group-members-wrapper');
    const groupNameWrapper = document.getElementById('group-name-wrapper');
    const thesisFieldsWrapper = document.getElementById('thesis-fields-wrapper');
    const companyFieldsWrapper = document.getElementById('company-fields-wrapper');
    const btnAddMember = document.getElementById('btn-add-member');
    const groupMembersContainer = document.getElementById('group-members-container');

    function toggleGroupMembersSection() {
        if (!letterTypeSelect) return;
        const val = letterTypeSelect.value;
        const letterOptions = @json($createLetterOptions);
        const selectedOpt = letterOptions.find(o => String(o.value) === String(val));
        
        const allowGroup = selectedOpt && selectedOpt.allowGroup === 'true';
        const code = selectedOpt ? (selectedOpt.code || '').toUpperCase() : '';
        const name = selectedOpt ? (selectedOpt.label || '').toUpperCase() : '';

        // Toggle Group Members & Group Name
        if (allowGroup || code.includes('NONREG') || code.includes('KELOMPOK')) {
            if (groupMembersWrapper) groupMembersWrapper.classList.remove('hidden');
            if (groupNameWrapper) groupNameWrapper.classList.remove('hidden');
        } else {
            if (groupMembersWrapper) groupMembersWrapper.classList.add('hidden');
            if (groupNameWrapper) groupNameWrapper.classList.add('hidden');
            if (groupMembersContainer) groupMembersContainer.innerHTML = '';
        }

        // Toggle Thesis Title Fields (for Non-Reg TA, Pendadaran, Skripsi)
        const hasThesis = selectedOpt && (selectedOpt.hasThesisFields === 'true' || code === 'SP-TA-NONREG' || code === 'SR-PENDADARAN' || code.includes('PENDADARAN') || code.includes('TA') || name.includes('PENDADARAN') || name.includes('TUGAS AKHIR'));
        if (hasThesis) {
            if (thesisFieldsWrapper) thesisFieldsWrapper.classList.remove('hidden');
        } else {
            if (thesisFieldsWrapper) thesisFieldsWrapper.classList.add('hidden');
        }

        // Toggle Internship / Company / Research Fields (for Magang, Penelitian, Riset, Observasi, or templates with company placeholders)
        const hasCompany = selectedOpt && (selectedOpt.hasCompanyFields === 'true' || code === 'SR-MAGANG' || code === 'SR-PENELITIAN' || code.includes('MAGANG') || code.includes('PENELITIAN') || code.includes('RISET') || code.includes('OBSERVASI') || code.includes('IZIN') || name.includes('MAGANG') || name.includes('PENELITIAN') || name.includes('RISET') || name.includes('IZIN') || name.includes('UJI COBA'));
        if (hasCompany) {
            if (companyFieldsWrapper) companyFieldsWrapper.classList.remove('hidden');
        } else {
            if (companyFieldsWrapper) companyFieldsWrapper.classList.add('hidden');
        }
    }

    if (letterTypeSelect) {
        letterTypeSelect.addEventListener('change', toggleGroupMembersSection);
        toggleGroupMembersSection();
    }

    // Dynamic Lecturer List based on selected letter type
    const letterTypesApprovers = {!! $letterTypesApproversJson !!};
    
    function updateLecturersList() {
        const selectedLetterTypeId = letterTypeSelect ? letterTypeSelect.value : '';
        const lecturersContainer = document.getElementById('lecturers-list-container');
        
        if (!lecturersContainer) return;
        
        lecturersContainer.innerHTML = '';
        
        if (!selectedLetterTypeId || selectedLetterTypeId === '') {
            lecturersContainer.innerHTML = `
                <div class="flex items-center gap-3 p-3 bg-pure-white/20 rounded-lg border border-secondary/10">
                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary/50 shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <p class="text-xs text-on-secondary-container/70 italic">Silakan pilih jenis surat terlebih dahulu untuk melihat dosen yang akan mereview pengajuan Anda.</p>
                </div>
            `;
            return;
        }
        
        const approvers = letterTypesApprovers[selectedLetterTypeId] || [];
        
        if (approvers.length === 0) {
            lecturersContainer.innerHTML = `
                <div class="flex items-center gap-3 p-3 bg-pure-white/20 rounded-lg border border-secondary/10">
                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary/50 shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <p class="text-xs text-on-secondary-container/70 italic">Belum ada dosen yang ditugaskan untuk jenis surat ini.</p>
                </div>
            `;
            return;
        }
        
        approvers.forEach((approver, index) => {
            const isFirst = index === 0;
            const dividerClass = isFirst ? '' : 'border-t border-secondary/10 pt-3 mt-3';
            
            const approverHtml = `
                <div class="${dividerClass}">
                    <p class="text-[10px] text-on-secondary-container/70 font-bold uppercase tracking-wider mb-2">${approver.role}</p>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-on-secondary-container text-[14px]">${approver.name}</p>
                            <p class="text-[11px] text-on-secondary-container/60 mt-0.5">NIP/NIK: ${approver.nik || '—'}</p>
                            <p class="text-[11px] text-on-secondary-container/60">Email: ${approver.email || '—'}</p>
                        </div>
                    </div>
                </div>
            `;
            lecturersContainer.insertAdjacentHTML('beforeend', approverHtml);
        });
    }
    
    if (letterTypeSelect) {
        const originalChangeHandler = letterTypeSelect.onchange;
        letterTypeSelect.addEventListener('change', function() {
            updateLecturersList();
        });
        updateLecturersList();
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
    // Create Form Date Picker Display Formatter
    function formatToIndonesianDate(isoDateStr) {
        if (!isoDateStr) return '';
        const parts = isoDateStr.split('-');
        if (parts.length === 3) {
            const year = parts[0];
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const monthIndex = parseInt(parts[1], 10) - 1;
            const day = parseInt(parts[2], 10);
            return `${day} ${monthNames[monthIndex]} ${year}`;
        }
        return isoDateStr;
    }

    function updateCreateDateDisplays() {
        const startInput = document.getElementById('start_date_input');
        const startDisplay = document.getElementById('start_date_display');
        const endInput = document.getElementById('end_date_input');
        const endDisplay = document.getElementById('end_date_display');

        if (startInput && startDisplay) {
            startDisplay.value = formatToIndonesianDate(startInput.value);
        }
        if (endInput && endDisplay) {
            endDisplay.value = formatToIndonesianDate(endInput.value);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCreateDateDisplays();
    });
</script>
@endpush
