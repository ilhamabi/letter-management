@extends('layouts.lecturer')

@section('title', 'Layanan Dokumen - Detail Permintaan Persetujuan')

@php
    $studentName = $submission->student?->user?->name ?? 'Budi Santoso';
    $studentNim = $submission->student?->student_number ?? '20210001';
    $prodi = $submission->student?->department ?? $submission->student?->study_program ?? 'D3 Teknik Informatika';
    $academicStatus = $submission->student?->academic_status ?? 'Aktif Kuliah';
    $creditsEarned = $submission->student?->total_credits ?? $submission->student?->credits_earned ?? 115;
    $gpa = number_format((float)($submission->student?->gpa ?? 3.85), 2);
    $letterTypeName = $submission->letterType?->name ?? 'Surat Persetujuan Tugas Akhir';
    $submittedDate = $submission->submitted_at?->translatedFormat('d M Y H:i') ?? $submission->created_at?->format('d M Y H:i');
    $statusValue = is_object($submission->status) ? $submission->status->value : (string) $submission->status;
    $statusText = $submission->status?->label() ?? 'Diproses';

    // Dynamic Letter Preview & File Naming prepared by LecturerSubmissionService
    $previewFileName = $previewFileName ?? ('Surat_' . strtoupper($submission->letterType?->code ?? 'AKADEMIK') . '_' . $studentNim . '.pdf');
@endphp

@section('content')
    <div class="space-y-8">
        @if (session('success'))
            <div
                class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <x-icon name="check_circle" class="w-5 h-5 text-green-600 shrink-0" />
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-green-600 hover:text-green-900 p-1 cursor-pointer">
                    <x-icon name="close" class="w-4 h-4" />
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <x-icon name="error" class="w-5 h-5 text-red-600 shrink-0" />
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-red-600 hover:text-red-900 p-1 cursor-pointer">
                    <x-icon name="close" class="w-4 h-4" />
                </button>
            </div>
        @endif

        <!-- Breadcrumbs & Header -->
        <div class="mb-4">
            <nav class="flex items-center gap-2 text-gray-400 mb-3">
                <a class="font-body-sm text-body-sm hover:text-primary transition-colors"
                    href="{{ route('lecturer.submissions.index') }}">Persetujuan Dokumen</a>
                <x-icon name="chevron_right" class="w-4 h-4" />
                <span class="font-label-sm text-label-sm text-gray-900 uppercase tracking-wider">Detail Permintaan
                    #SUB-{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
            </nav>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Detail {{ $letterTypeName }}</h2>
                    <p class="font-body-md text-body-md text-gray-500 flex items-center gap-2">
                        <x-icon name="calendar_today" class="w-4 h-4" />
                        Diajukan pada {{ $submittedDate }} WIB
                    </p>
                </div>
                <div class="self-start">
                    <x-status-badge :status="$statusValue" size="md" />
                </div>
            </div>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <!-- Left Column: Document Viewer (Preview Surat Dosen) -->
            <div class="xl:col-span-8 flex flex-col gap-6">
                <div class="bg-white border border-gray-200 rounded-xl flex flex-col shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-white flex-wrap gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-amikom-purple border border-purple-100 shrink-0">
                                <x-icon name="description" class="w-5 h-5 text-primary" />
                            </div>
                            <div>
                                <h3 class="font-label-lg text-label-lg text-gray-900 font-bold">
                                    {{ $previewFileName }}
                                </h3>
                                <p class="text-[12px] text-gray-400 font-body-sm">Pratinjau Dokumen Resmi (A4)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1 bg-white overflow-x-auto rounded-b-xl p-2 sm:p-4 flex justify-center items-start">
                        <iframe 
                            srcdoc="{!! e($previewHtml) !!}" 
                            class="w-[596pt] max-w-full h-[1140px] border border-gray-100 shadow-sm bg-white rounded-sm"
                            style="overflow: hidden;"
                            scrolling="no"
                            title="Preview Surat Dosen">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Right Column: Student Info, Roles & Details -->
            <div class="xl:col-span-4 flex flex-col gap-6">
                <!-- Student Profile Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3
                        class="font-title-lg text-title-lg text-gray-900 mb-6 flex items-center gap-2 pb-3 border-b border-gray-200">
                        <x-icon name="person_search" class="w-5 h-5 text-primary" />
                        Informasi Mahasiswa
                    </h3>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="relative">
                            <div
                                class="w-16 h-16 rounded-xl bg-purple-50 flex items-center justify-center border border-purple-200 shadow-xs text-amikom-purple shrink-0">
                                <x-icon name="person" class="w-9 h-9 text-amikom-purple" />
                            </div>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-900 leading-tight">{{ $studentName }}</p>
                            <p class="font-body-md text-primary font-semibold mt-1">NIM: {{ $studentNim }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                    <x-icon name="school" class="w-5 h-5 text-primary" />
                                </div>
                                <span
                                    class="font-label-sm text-label-sm text-gray-500 uppercase tracking-wider font-semibold">Program
                                    Studi</span>
                            </div>
                            <span
                                class="font-body-sm text-body-sm text-primary bg-primary/10 px-3 py-1 rounded-full font-bold">{{ $prodi }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                    <x-icon name="trending_up" class="w-5 h-5 text-primary" />
                                </div>
                                <span
                                    class="font-label-sm text-label-sm text-gray-500 uppercase tracking-wider font-semibold">Status
                                    Akademik</span>
                            </div>
                            <span
                                class="font-body-sm text-body-sm text-[#584409] bg-[#ffe16d] px-3 py-1 rounded-full font-bold">{{ $academicStatus }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                                <p
                                    class="font-label-sm text-label-sm text-blue-800 uppercase tracking-wider mb-1 font-semibold">
                                    Total SKS</p>
                                <div class="inline-block bg-blue-100 px-3 py-1 rounded-lg">
                                    <p class="font-title-lg text-title-lg text-blue-800 font-bold">{{ $creditsEarned }}</p>
                                </div>
                            </div>
                            <div class="p-3 bg-green-50 rounded-xl border border-green-100">
                                <p
                                    class="font-label-sm text-label-sm text-green-800 uppercase tracking-wider mb-1 font-semibold">
                                    IPK</p>
                                <div class="inline-block bg-green-100 px-3 py-1 rounded-lg">
                                    <p class="font-title-lg text-title-lg text-green-800 font-bold">{{ $gpa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lecturer Roles Detail Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3
                        class="font-title-lg text-title-lg text-gray-900 mb-6 flex items-center gap-2 pb-3 border-b border-gray-200">
                        <x-icon name="badge" class="w-5 h-5 text-primary" />Alur & Peran Approver Workflow
                    </h3>
                    <div class="space-y-4">
                        @foreach ($formattedSteps as $index => $step)
                            <div
                                class="p-4 rounded-xl border {{ $step['is_current'] ? 'bg-amber-50/50 border-amber-200 ring-1 ring-amber-300' : 'bg-gray-50/50 border-gray-200' }} transition-all">
                                <div class="flex items-center justify-between gap-3 mb-2 flex-wrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tahap
                                            {{ $step['step_order'] ?? ($index + 1) }}</span>
                                        <x-role-badge :role="$step['role_code'] ?? $step['role']" size="sm" />
                                    </div>
                                    @if($step['is_current'])
                                        <span
                                            class="text-[11px] font-bold text-amber-800 bg-amber-100 border border-amber-200 px-2.5 py-0.5 rounded-full flex items-center gap-1 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Tahap Saat Ini
                                        </span>
                                    @elseif($step['is_completed'])
                                        <span
                                            class="text-[11px] font-bold text-green-800 bg-green-100 border border-green-200 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                            <x-icon name="check_circle" class="w-3.5 h-3.5 text-green-600" />
                                            Selesai
                                        </span>
                                    @else
                                        <span
                                            class="text-[11px] font-medium text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-0.5 rounded-full">
                                            Menunggu
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="person" class="w-4 h-4 text-gray-400 shrink-0" />
                                        <span class="text-sm font-bold text-gray-900">{{ $step['approver_name'] }}</span>
                                    </div>
                                    @if($step['is_assigned_to_me'])
                                        <span
                                            class="text-xs font-semibold text-amikom-purple bg-purple-50 px-2 py-0.5 rounded border border-purple-100">
                                            (Saya)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Detail Pengajuan Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-6">
                    <div class="pb-4 border-b border-gray-100">
                        <h3 class="font-title-lg text-title-lg text-gray-900 mb-4 flex items-center gap-2"><x-icon
                                name="info" class="w-5 h-5 text-primary" />Detail Pengajuan</h3>
                        <div class="space-y-1">
                            <p class="text-label-sm text-gray-500 uppercase tracking-wider font-semibold">Tujuan / Keperluan
                            </p>
                            <p class="text-body-md font-medium text-gray-900">{{ $subDto['purpose'] }}</p>
                        </div>
                        @if(!empty($submission->additional_data) && is_array($submission->additional_data))
                            <div class="mt-3 pt-3 border-t border-gray-100 space-y-2">
                                <p class="text-label-sm text-gray-500 uppercase tracking-wider font-semibold">Informasi Tambahan / Instansi</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    @php
                                        $preferredOrder = ['thesis_title', 'company_name', 'company_address', 'start_date', 'end_date', 'group_name', 'academic_year', 'total_credits', 'gpa', 'purpose'];
                                        $sortedData = $submission->additional_data;
                                        uksort($sortedData, function($a, $b) use ($preferredOrder) {
                                            $idxA = array_search($a, $preferredOrder);
                                            $idxB = array_search($b, $preferredOrder);
                                            $idxA = ($idxA === false) ? 999 : $idxA;
                                            $idxB = ($idxB === false) ? 999 : $idxB;
                                            return $idxA <=> $idxB;
                                        });
                                    @endphp
                                    @foreach($sortedData as $key => $val)
                                        @if(!empty($val) && !is_array($val))
                                            @php
                                                $labelMap = [
                                                    'thesis_title' => 'Judul Tugas Akhir / Proyek',
                                                    'company_name' => 'Nama Instansi / Perusahaan',
                                                    'company_address' => 'Alamat Instansi / Perusahaan',
                                                    'start_date' => 'Tanggal Mulai',
                                                    'end_date' => 'Tanggal Selesai',
                                                    'total_credits' => 'Total SKS',
                                                    'gpa' => 'IPK Kumulatif',
                                                    'group_name' => 'Nama Kelompok / Tim',
                                                    'academic_year' => 'Tahun Akademik',
                                                    'purpose' => 'Keperluan / Alasan',
                                                ];
                                                $label = $labelMap[$key] ?? ucwords(str_replace('_', ' ', $key));

                                                $displayValue = $val;
                                                if (in_array($key, ['start_date', 'end_date']) && !empty($val)) {
                                                    try {
                                                        $months = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                                                        $dt = \Carbon\Carbon::parse($val);
                                                        $displayValue = $dt->format('j') . ' ' . $months[(int)$dt->format('n')] . ' ' . $dt->format('Y');
                                                    } catch (\Throwable $e) {
                                                        $displayValue = $val;
                                                    }
                                                }
                                            @endphp
                                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                                <span class="text-gray-500 font-semibold block uppercase text-[10px] tracking-wider mb-0.5">{{ $label }}</span>
                                                <span class="text-gray-900 font-bold text-xs">{{ $displayValue }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!empty($subDto['members']) && count($subDto['members']) > 0)
                        <div class="pb-4 border-b border-gray-100">
                            <p class="text-label-sm text-gray-500 uppercase tracking-wider font-semibold mb-2">Anggota Tim
                                (Pengajuan Kelompok)</p>
                            <ul class="text-xs text-gray-700 space-y-1 pl-4 list-disc">
                                @foreach($subDto['members'] as $m)
                                    <li><span class="font-bold">{{ $m['name'] }}</span> (NIM: {{ $m['nim'] }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pb-4 border-b border-gray-100">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-2">LAMPIRAN</p>
                        <div class="grid grid-cols-2 gap-4">
                            @forelse($subDto['attachments'] ?? [] as $att)
                                <a href="{{ $att['url'] }}" target="_blank" rel="noopener noreferrer" 
                                   class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group col-span-2 sm:col-span-1">
                                    <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error shrink-0">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"/><path d="M9 13v6"/></svg>
                                    </div>
                                    <div class="overflow-hidden font-body-sm flex-1">
                                        <p class="text-label-sm text-deep-black truncate font-semibold" title="{{ $att['name'] }}">{{ $att['name'] }}</p>
                                        <p class="text-[10px] text-on-surface-variant">{{ $att['size'] }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </a>
                            @empty
                                <p class="text-body-sm text-on-surface-variant italic col-span-2">Tidak ada lampiran</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h3 class="font-title-lg text-title-lg text-gray-900 mb-6 flex items-center gap-2"><x-icon
                                name="history" class="w-5 h-5 text-primary" />Riwayat Audit Trail</h3>
                        <div class="space-y-6">
                            @foreach ($subDto['timeline'] as $t)
                                @php
                                    $circleStyle = match ($t['status']) {
                                        'completed' => 'bg-emerald-500 ring-4 ring-emerald-100',
                                        'rejected' => 'bg-rose-500 ring-4 ring-rose-100',
                                        'active' => 'bg-amber-500 ring-4 ring-amber-100 animate-pulse',
                                        default => 'bg-slate-300 ring-4 ring-slate-100',
                                    };
                                @endphp
                                <div class="relative pl-7 border-l-2 border-slate-300">
                                    <div
                                        class="absolute -left-[9px] top-0.5 w-4 h-4 rounded-full border-2 border-white shadow-md {{ $circleStyle }}">
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-label-lg text-gray-900 font-bold leading-tight">{{ $t['title'] }}</span>
                                        <span class="text-body-sm text-gray-500 font-medium mt-0.5">{{ $t['time'] }}</span>
                                        @if(!empty($t['notes']))
                                            <p class="mt-1.5 text-xs bg-slate-50 p-2.5 rounded-lg border border-slate-200 text-slate-700 font-medium">
                                                Catatan: {{ $t['notes'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3
                        class="font-title-lg text-title-lg text-gray-900 mb-4 flex items-center gap-2 pb-3 border-b border-gray-200">
                        <x-icon name="edit_note" class="w-5 h-5 text-primary" />
                        Tindakan Persetujuan
                    </h3>

                    @if($canApprove)
                        @if(count($consecutiveStepIds) > 1)
                            <div
                                class="p-3 mb-4 bg-indigo-50 border border-indigo-200 rounded-lg text-xs text-indigo-800 flex items-center gap-2">
                                <x-icon name="auto_awesome" class="w-4 h-4 text-indigo-600 shrink-0" />
                                <span>Anda memegang <strong>{{ count($consecutiveStepIds) }} tahap berurutan</strong> pada workflow
                                    ini. Anda dapat memilih untuk memproses 1 tahap atau seluruhnya sekaligus.</span>
                            </div>
                        @endif

                        <div class="flex gap-3 pt-2">
                            <button type="button"
                                class="flex-1 py-3 px-4 border border-red-300 text-red-700 font-bold rounded-xl hover:bg-red-50 transition-colors flex items-center justify-center gap-2 cursor-pointer"
                                onclick="typeof openModal === 'function' ? openModal('reject-modal') : document.getElementById('reject-modal').classList.remove('hidden')">
                                <x-icon name="close" class="w-5 h-5" />
                                Tolak
                            </button>

                            @if(count($consecutiveStepIds) > 1)
                                <button type="button"
                                    onclick="typeof openModal === 'function' ? openModal('approve-choice-modal') : document.getElementById('approve-choice-modal').classList.remove('hidden')"
                                    class="flex-[2] py-3 px-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-container shadow-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                    <x-icon name="check_circle" class="w-5 h-5" />
                                    Setujui Dokumen...
                                </button>
                            @else
                                <button type="button"
                                    onclick="typeof openModal === 'function' ? openModal('approve-single-modal') : document.getElementById('approve-single-modal').classList.remove('hidden')"
                                    class="flex-[2] py-3 px-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-container shadow-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                    <x-icon name="check_circle" class="w-5 h-5" />
                                    Setujui Dokumen
                                </button>
                            @endif
                        </div>
                    @else
                        <div
                            class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-center text-sm text-gray-500 font-medium">
                            @if($statusValue === 'APPROVED' || $statusValue === 'GENERATED')
                                <p class="text-green-700 font-bold flex items-center justify-center gap-2">
                                    <x-icon name="check_circle" class="w-5 h-5 text-green-600" />
                                    Pengajuan Telah Disetujui
                                </p>
                            @elseif($statusValue === 'REJECTED')
                                <p class="text-red-700 font-bold flex items-center justify-center gap-2">
                                    <x-icon name="cancel" class="w-5 h-5 text-red-600" />
                                    Pengajuan Telah Ditolak
                                </p>
                            @else
                                <p class="text-gray-600">Pengajuan saat ini sedang diproses oleh approver lain pada workflow.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Single-Step Approval Modal -->
    @if($canApprove && count($consecutiveStepIds) <= 1)
        <x-modal id="approve-single-modal" title="Konfirmasi Persetujuan Dokumen" maxWidth="max-w-md">
            <x-slot:subtitle>
                Anda akan menyetujui pengajuan dokumen mahasiswa ini. Silakan tambahkan catatan persetujuan jika diperlukan:
            </x-slot:subtitle>

            <form action="{{ route('lecturer.submissions.approve', $submission->id) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="steps_to_approve" value="1">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Catatan Persetujuan
                        (Opsional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm resize-none focus:ring-2 focus:ring-primary outline-none"
                        placeholder="Tambahkan catatan untuk proses persetujuan ini (opsional)..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button"
                        class="py-2.5 px-5 text-gray-700 hover:bg-gray-100 rounded-xl font-semibold transition-colors border border-gray-300 cursor-pointer"
                        onclick="typeof closeModal === 'function' ? closeModal('approve-single-modal') : document.getElementById('approve-single-modal').classList.add('hidden')">Batal</button>
                    <button type="submit"
                        class="py-2.5 px-5 bg-primary text-white rounded-xl font-bold hover:bg-primary-container transition-colors shadow-sm cursor-pointer flex items-center gap-2">
                        <x-icon name="check_circle" class="w-4 h-4" />
                        Konfirmasi Persetujuan
                    </button>
                </div>
            </form>
        </x-modal>
    @endif

    <!-- Multi-Step Approval Choice Modal -->
    @if($canApprove && count($consecutiveStepIds) > 1)
        <x-modal id="approve-choice-modal" title="Persetujuan Multi-Tahap Workflow" maxWidth="max-w-lg">
            <x-slot:subtitle>
                Anda memegang <strong class="text-gray-900">{{ count($consecutiveStepIds) }} tahapan persetujuan
                    berurutan</strong> pada dokumen ini. Silakan pilih opsi tindakan persetujuan:
            </x-slot:subtitle>

            <form action="{{ route('lecturer.submissions.approve', $submission->id) }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-3">
                    <!-- Option 1: 1 Step Only -->
                    <label
                        class="flex items-start gap-3 p-4 rounded-xl border border-gray-200 bg-white hover:bg-purple-50/50 hover:border-purple-300 transition-all cursor-pointer group shadow-xs">
                        <input type="radio" name="steps_to_approve" value="1" checked
                            class="mt-1 text-primary focus:ring-primary">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors">Setujui
                                    Tahap Saat Ini Saja (1 Tahap)</span>
                                <span
                                    class="text-[10px] font-semibold text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full">Bertahap</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Hanya menyetujui tahap saat ini. Tahap
                                selanjutnya tetap akan menunggu persetujuan Anda kembali.</p>
                        </div>
                    </label>

                    <!-- Option 2: All Consecutive Steps -->
                    <label
                        class="flex items-start gap-3 p-4 rounded-xl border border-amber-300 bg-amber-50/60 hover:bg-amber-50 hover:border-amber-400 transition-all cursor-pointer group shadow-xs">
                        <input type="radio" name="steps_to_approve" value="{{ count($consecutiveStepIds) }}"
                            class="mt-1 text-primary focus:ring-primary">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-sm font-bold text-amber-950 group-hover:text-amber-900 transition-colors">Setujui
                                    {{ count($consecutiveStepIds) }} Tahap Sekaligus (Semua Peran Saya)</span>
                                <span
                                    class="text-[10px] font-bold text-amber-900 bg-amber-100 border border-amber-300 px-2 py-0.5 rounded-full">Rekomendasi</span>
                            </div>
                            <p class="text-xs text-amber-800 mt-1 leading-relaxed">Menyetujui seluruh
                                {{ count($consecutiveStepIds) }} tahap berurutan milik Anda secara otomatis sekaligus dalam 1
                                kali klik.</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Catatan Persetujuan
                        (Opsional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm resize-none focus:ring-2 focus:ring-primary outline-none"
                        placeholder="Tambahkan catatan untuk proses persetujuan ini (opsional)..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button"
                        class="py-2.5 px-5 text-gray-700 hover:bg-gray-100 rounded-xl font-semibold transition-colors border border-gray-300 cursor-pointer"
                        onclick="typeof closeModal === 'function' ? closeModal('approve-choice-modal') : document.getElementById('approve-choice-modal').classList.add('hidden')">Batal</button>
                    <button type="submit"
                        class="py-2.5 px-5 bg-primary text-white rounded-xl font-bold hover:bg-primary-container transition-colors shadow-sm cursor-pointer flex items-center gap-2">
                        <x-icon name="check_circle" class="w-4 h-4" />
                        Konfirmasi Persetujuan
                    </button>
                </div>
            </form>
        </x-modal>
    @endif

    <!-- Rejection Reason Modal -->
    <x-modal id="reject-modal" title="Konfirmasi Penolakan" maxWidth="max-w-md">
        <x-slot:subtitle>
            Berikan alasan penolakan dokumen pengajuan mahasiswa ini:
        </x-slot:subtitle>

        <form action="{{ route('lecturer.submissions.reject', $submission->id) }}" method="POST" id="reject-form"
            class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alasan Penolakan
                    Utama</label>
                <select name="reason" required
                    class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-primary outline-none">
                    <option value="Syarat SKS belum terpenuhi">Syarat SKS belum terpenuhi</option>
                    <option value="IPK di bawah standar minimum">IPK di bawah standar minimum</option>
                    <option value="Berkas lampiran tidak valid / tidak lengkap">Berkas lampiran tidak valid / tidak lengkap
                    </option>
                    <option value="Format permohonan tidak sesuai ketentuan">Format permohonan tidak sesuai ketentuan
                    </option>
                    <option value="Slot Dosen Pembimbing Penuh">Slot Dosen Pembimbing Penuh</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Catatan Tambahan
                    (Opsional)</label>
                <textarea name="notes" rows="3"
                    class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 text-sm resize-none focus:ring-2 focus:ring-primary outline-none"
                    placeholder="Masukkan instruksi perbaikan atau alasan tambahan..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                <button type="button"
                    class="py-2.5 px-5 text-gray-700 hover:bg-gray-100 rounded-xl font-semibold transition-colors border border-gray-300 cursor-pointer"
                    onclick="typeof closeModal === 'function' ? closeModal('reject-modal') : document.getElementById('reject-modal').classList.add('hidden')">Batal</button>
                <button type="submit"
                    class="py-2.5 px-5 bg-error text-white rounded-xl font-bold hover:bg-red-700 transition-colors shadow-sm cursor-pointer flex items-center gap-2">
                    <x-icon name="close" class="w-4 h-4" />
                    Konfirmasi Penolakan
                </button>
            </div>
        </form>
    </x-modal>

@endsection