@extends('layouts.lecturer')

@section('title', 'Layanan Dokumen - Detail Permintaan Persetujuan')

@php
    $studentName = $submission->student?->user?->name ?? 'Budi Santoso';
    $studentNim = $submission->student?->student_number ?? '19.11.1234';
    $prodi = $submission->student?->study_program ?? 'D3 Teknik Informatika';
    $academicStatus = $submission->student?->academic_status ?? 'Aktif';
    $creditsEarned = $submission->student?->credits_earned ?? 110;
    $gpa = $submission->student?->gpa ?? '3.85';
    $letterTypeName = $submission->letterType?->name ?? 'Surat Persetujuan Tugas Akhir';
    $submittedDate = $submission->submitted_at?->translatedFormat('d M Y H:i') ?? $submission->created_at?->format('d M Y H:i');
    $statusValue = is_object($submission->status) ? $submission->status->value : (string) $submission->status;
    $statusText = $submission->status?->label() ?? 'Diproses';

    // HTML Letter Preview setup
    $letterHtmlPath = resource_path('views/letter/surat_persetujuan_non_reguler_ahmad_doni.html');
    $letterCssPath = resource_path('views/letter/letter-style.css');

    $bodyContent = '';
    $scopedCss = '';

    if (file_exists($letterHtmlPath)) {
        $htmlContent = file_get_contents($letterHtmlPath);
        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $htmlContent, $matches)) {
            $bodyContent = $matches[1];
        } else {
            $bodyContent = $htmlContent;
        }

        $bodyContent = preg_replace('/src=["\']([^"\']+\.(png|webp|svg|jpg|jpeg|gif))["\']/i', 'src="' . url('/letter') . '/$1"', $bodyContent);
    }

    if (file_exists($letterCssPath)) {
        $cssContent = file_get_contents($letterCssPath);
        $blocks = explode('}', $cssContent);
        foreach ($blocks as &$block) {
            if (trim($block) === '')
                continue;
            $parts = explode('{', $block);
            if (count($parts) === 2) {
                $selectors = explode(',', $parts[0]);
                foreach ($selectors as &$selector) {
                    $selector = trim($selector);
                    if ($selector === 'body') {
                        $selector = '.letter-preview-wrapper';
                    } elseif ($selector === '*') {
                        $selector = '.letter-preview-wrapper *';
                    } elseif (str_starts_with($selector, '@media') || str_starts_with($selector, '@page')) {
                    } else {
                        $selector = '.letter-preview-wrapper ' . $selector;
                    }
                }
                $parts[0] = implode(', ', $selectors);
                $block = implode('{', $parts);
            }
        }
        $scopedCss = implode('}', $blocks);
    }
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
            <!-- Left Column: Document Viewer -->
            <div class="xl:col-span-8 flex flex-col gap-6">
                <div class="bg-white border border-gray-200 rounded-xl flex flex-col shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
                        <div class="flex items-center gap-3">
                            <x-icon name="description" class="w-5 h-5 text-primary" />
                            <div>
                                <h3 class="font-label-lg text-label-lg text-gray-900">
                                    SURAT_{{ Str::upper($submission->letterType?->code ?? 'AKADEMIK') }}_{{ $studentNim }}.pdf
                                </h3>
                                <p class="text-[12px] text-gray-400 font-body-sm">Pratinjau Otomatis Sistem</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('/letter/surat_persetujuan_non_reguler_ahmad_doni.html') }}" target="_blank"
                                class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors flex items-center gap-1">
                                <x-icon name="download" class="w-5 h-5" />
                                <span class="font-label-sm text-label-sm hidden sm:inline font-semibold">Pratinjau
                                    Cetak</span>
                            </a>
                        </div>
                    </div>
                    <style>
                        {!! $scopedCss !!}
                        .letter-preview-wrapper .sheet-wrap {
                            margin: 0 !important;
                            box-shadow: none !important;
                            width: 100% !important;
                        }

                        .letter-preview-wrapper .page {
                            width: 100% !important;
                            height: auto !important;
                            min-height: 842pt !important;
                        }
                    </style>
                    <div class="flex-1 bg-white overflow-x-auto p-0 rounded-b-xl border-t border-gray-100 min-h-[500px]">
                        <div class="letter-preview-wrapper">
                            {!! $bodyContent !!}
                        </div>
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
                                class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-primary/10 shadow-sm overflow-hidden text-gray-400 font-bold text-2xl">
                                {{ Str::upper(substr($studentName, 0, 2)) }}
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

                    <div>
                        <h3 class="font-title-lg text-title-lg text-gray-900 mb-6 flex items-center gap-2"><x-icon
                                name="history" class="w-5 h-5 text-primary" />Riwayat Audit Trail</h3>
                        <div class="space-y-4">
                            @foreach ($subDto['timeline'] as $t)
                                @php
                                    $badgeClass = match ($t['status']) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'active' => 'bg-amber-100 text-amber-800 animate-pulse',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <div class="relative pl-6 border-l-2 border-gray-200">
                                    <div
                                        class="absolute -left-[9px] top-0 w-4 h-4 rounded-full border-4 border-white shadow-sm {{ $badgeClass }}">
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-label-lg text-gray-900 font-bold">{{ $t['title'] }}</span>
                                        <span class="text-body-sm text-gray-500">{{ $t['time'] }}</span>
                                        @if(!empty($t['notes']))
                                            <p class="mt-1 text-xs bg-gray-50 p-2 rounded border border-gray-200 text-gray-700">
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