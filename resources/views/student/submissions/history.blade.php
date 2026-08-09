@extends('layouts.student')

@section('title', 'Riwayat Pengajuan - Universitas Amikom')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $nim ?? ($user?->student?->student_number ?? $user?->username ?? '-');
    $prodi = $prodi ?? ($user?->student?->studyProgram?->name ?? 'D3 Teknik Informatika');
    $profilePhoto = null;

    $submissions = $submissions ?? [];
@endphp

@section('content')
    <!-- Page Title -->
    <section class="flex flex-col gap-2">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Pengajuan Saya</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan pantau status permohonan dokumen akademik Anda di sini.</p>
    </section>
    
    <!-- Filter Section -->
    <section class="bg-pure-white p-6 rounded-xl border border-outline-variant shadow-sm flex flex-col gap-4">
        <div class="flex items-center justify-between border-b border-outline-variant/60 pb-3">
            <div class="flex items-center gap-2 text-on-surface font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-primary" />
                <span>Filter Pengajuan</span>
            </div>
            <button id="btn-reset-filter" type="button" class="text-xs font-semibold text-primary hover:text-primary-container transition-colors flex items-center gap-1 cursor-pointer">
                <x-icon name="restart_alt" class="w-4 h-4" />
                <span>Reset Filter</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            <!-- Date Range -->
            <div class="lg:col-span-5 flex flex-col gap-1.5">
                <label class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Periode Tanggal</label>
                <div class="flex items-center gap-2">
                    <!-- Start Date -->
                    <div class="relative flex-1 cursor-pointer" onclick="try{document.getElementById('filter-start-date').showPicker()}catch(e){}">
                        <input id="filter-start-date-display" type="text" placeholder="dd/mm/yy" readonly class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg pl-4 pr-10 h-11 text-body-sm font-body-sm text-on-surface transition-all cursor-pointer">
                        <input id="filter-start-date" type="date" class="sr-only">
                        <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                    </div>
                    <span class="text-on-surface-variant font-medium text-sm">-</span>
                    <!-- End Date -->
                    <div class="relative flex-1 cursor-pointer" onclick="try{document.getElementById('filter-end-date').showPicker()}catch(e){}">
                        <input id="filter-end-date-display" type="text" placeholder="dd/mm/yy" readonly class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg pl-4 pr-10 h-11 text-body-sm font-body-sm text-on-surface transition-all cursor-pointer">
                        <input id="filter-end-date" type="date" class="sr-only">
                        <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                    </div>
                </div>
            </div>

            <!-- Jenis Surat -->
            <div class="lg:col-span-4 flex flex-col gap-1.5">
                <label for="filter-type" class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Jenis Surat</label>
                <div class="relative">
                    <select id="filter-type" class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg pl-4 pr-10 h-11 text-body-sm font-body-sm text-on-surface cursor-pointer transition-all">
                        <option value="">Semua Jenis Surat</option>
                        <option value="persetujuan">Surat Persetujuan Tugas Akhir Jalur Non-Reguler</option>
                        <option value="magang">Surat Rekomendasi Magang</option>
                        <option value="pendadaran">Surat Rekomendasi Pendaftaran Pendadaran</option>
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div class="lg:col-span-3 flex flex-col gap-1.5">
                <label for="filter-status" class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Status Pengajuan</label>
                <div class="relative">
                    <select id="filter-status" class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg pl-4 pr-10 h-11 text-body-sm font-body-sm text-on-surface cursor-pointer transition-all">
                        <option value="">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Data Table -->
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto w-full min-w-full">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low/70 border-b border-outline-variant">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jenis Surat</th>
                        <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tgl. Pengajuan</th>
                        <th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/60 font-body-sm text-on-surface" id="submission-table-body">
                    @forelse ($submissions as $index => $item)
                        @php
                            $letterType = is_array($item) ? $item['type'] : ($item->letterType?->name ?? 'Surat');
                            $submittedDate = is_array($item) ? $item['date'] : ($item->created_at?->translatedFormat('d M Y') ?? $item->created_at?->format('d M Y') ?? '-');
                            $submittedDateTime = is_array($item) ? ($item['time'] ?? ($item['date'] . (str_contains($item['date'], ':') ? '' : ', 08:30 WIB'))) : ($item->created_at?->translatedFormat('d M Y, H:i \W\I\B') ?? $item->created_at?->format('d M Y, H:i \W\I\B') ?? '-');
                            $statusValue = is_array($item) ? $item['status'] : (is_object($item->status) ? $item->status->value : (string) $item->status);
                            $statusLabel = is_array($item) ? $item['status'] : (is_object($item->status) && method_exists($item->status, 'label') ? $item->status->label() : $statusValue);
                            $rejectionReason = is_array($item) ? ($item['reason'] ?? '') : ($item->rejection_note ?? '');

                            if (is_array($item)) {
                                $modalPayload = $item;
                            } else {
                                $flowSteps = $item->letterType?->approvalFlow?->steps?->sortBy('step_order')->values() ?? collect();
                                $currentStepOrder = $item->approvalFlowStep?->step_order ?? 0;
                                $currentStepId = $item->approvalFlowStep?->id;

                                $timeline = $flowSteps->map(function ($step) use ($statusValue, $currentStepOrder, $currentStepId) {
                                    $stepStatus = 'pending';
                                    if ($statusValue === \App\Enums\SubmissionStatus::APPROVED->value) {
                                        $stepStatus = 'completed';
                                    } elseif ($step->id === $currentStepId) {
                                        $stepStatus = 'active';
                                    } elseif ($step->step_order < $currentStepOrder) {
                                        $stepStatus = 'completed';
                                    }

                                    return [
                                        'title' => $step->approval_role?->label() ?? $step->name,
                                        'time' => match ($stepStatus) {
                                            'completed' => 'Selesai',
                                            'active' => 'Sedang diverifikasi',
                                            default => 'Menunggu penugasan',
                                        },
                                        'status' => $stepStatus,
                                    ];
                                })->values()->all();

                                if (empty($timeline)) {
                                    $timeline = [
                                        ['title' => 'Pengajuan Terkirim', 'time' => $submittedDateTime, 'status' => 'completed'],
                                        ['title' => 'Persetujuan Dosen Wali', 'time' => $statusValue === 'approved' ? 'Selesai' : 'Sedang diverifikasi', 'status' => $statusValue === 'approved' ? 'completed' : 'active'],
                                        ['title' => 'Verifikasi Program Studi', 'time' => $statusValue === 'approved' ? 'Selesai' : 'Menunggu penugasan', 'status' => $statusValue === 'approved' ? 'completed' : 'pending'],
                                    ];
                                }

                                $attachments = $item->attachments?->map(function ($att) {
                                    $bytes = (int) ($att->file_size ?? 0);
                                    $sizeStr = $bytes >= 1048576 ? round($bytes / 1048576, 2) . ' MB' : round($bytes / 1024, 2) . ' KB';
                                    return [
                                        'name' => $att->original_filename ?? $att->stored_filename ?? 'Lampiran.pdf',
                                        'size' => $sizeStr,
                                        'url' => asset('storage/' . $att->file_path),
                                    ];
                                })->values()->all() ?? [];

                                $modalPayload = [
                                    'id' => $item->id,
                                    'type' => $letterType,
                                    'date' => $submittedDate,
                                    'time' => $submittedDateTime,
                                    'status' => $statusValue,
                                    'statusLabel' => $statusLabel,
                                    'purpose' => $item->purpose ?? 'Pengajuan dokumen akademik',
                                    'nim' => $nim,
                                    'prodi' => $prodi,
                                    'reason' => $rejectionReason,
                                    'attachments' => $attachments,
                                    'timeline' => $timeline,
                                ];
                            }
                        @endphp
                        <tr class="submission-row hover:bg-surface-container-low/50 transition-colors duration-200 cursor-pointer" 
                            data-type="{{ strtolower($letterType) }}" 
                            data-status="{{ strtolower($statusValue) }}" 
                            data-date="{{ $submittedDate }}"
                            onclick="openDetailModal({{ json_encode($modalPayload) }})">
                            <td class="px-6 py-4 text-center text-on-surface-variant font-medium">
                                {{ is_object($submissions) && method_exists($submissions, 'firstItem') ? ($submissions->firstItem() + $index) : ($index + 1) }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-deep-black">{{ $letterType }}</td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $submittedDate }}</td>
                            <td class="px-6 py-4 text-center">
                                <x-status-badge :status="$statusValue" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr id="no-results-row">
                            <td colspan="4" class="py-12 text-center text-on-surface-variant font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <x-icon name="search_off" class="w-8 h-8 text-outline" />
                                    <p>Belum ada riwayat pengajuan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-surface-container-low flex items-center justify-between border-t border-outline-variant flex-wrap gap-4">
            @if (is_object($submissions) && method_exists($submissions, 'firstItem'))
                <p class="text-body-sm text-on-surface-variant font-medium">
                    Menampilkan {{ $submissions->firstItem() ?? 0 }}-{{ $submissions->lastItem() ?? 0 }} dari {{ $submissions->total() }} pengajuan
                </p>
                <div>
                    {{ $submissions->links() }}
                </div>
            @else
                <p class="text-body-sm text-on-surface-variant font-medium">Menampilkan {{ count($submissions) }} pengajuan</p>
            @endif
        </div>
    </section>

    <!-- Status Detail Modal Component -->
    <x-student.status-modal id="status-detail-modal" :nim="$nim" :prodi="$prodi" />
@endsection

@push('scripts')
<script>
    const filterType = document.getElementById('filter-type');
    const filterStatus = document.getElementById('filter-status');
    const startDateInput = document.getElementById('filter-start-date');
    const endDateInput = document.getElementById('filter-end-date');
    const rows = document.querySelectorAll('.submission-row');

    function parseISOInputDate(val) {
        if (!val) return null;
        const parts = val.split('-');
        if (parts.length === 3) {
            return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
        }
        return new Date(val);
    }

    function filterTable() {
        const selectedType = filterType ? filterType.value.toLowerCase() : '';
        const selectedStatus = filterStatus ? filterStatus.value.toLowerCase() : '';
        const startDateVal = startDateInput && startDateInput.value ? parseISOInputDate(startDateInput.value) : null;
        const endDateVal = endDateInput && endDateInput.value ? parseISOInputDate(endDateInput.value) : null;
        let visibleCount = 0;

        rows.forEach(row => {
            const type = row.getAttribute('data-type').toLowerCase();
            const status = row.getAttribute('data-status').toLowerCase();
            const dateStr = row.getAttribute('data-date');
            
            let show = true;
            
            if (selectedType && !type.includes(selectedType)) {
                show = false;
            }
            
            if (selectedStatus && !status.includes(selectedStatus)) {
                show = false;
            }
            
            if (show && (startDateVal || endDateVal)) {
                const rowDate = parseIndonesianDate(dateStr);
                if (rowDate) {
                    if (startDateVal) {
                        const start = new Date(startDateVal.getFullYear(), startDateVal.getMonth(), startDateVal.getDate());
                        const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                        if (current < start) show = false;
                    }
                    if (endDateVal) {
                        const end = new Date(endDateVal.getFullYear(), endDateVal.getMonth(), endDateVal.getDate());
                        const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                        if (current > end) show = false;
                    }
                }
            }

            if (show) visibleCount++;
            row.style.display = show ? '' : 'none';
        });

        const noResultsRow = document.getElementById('no-results-row');
        if (noResultsRow) {
            noResultsRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
    }

    function parseIndonesianDate(dateStr) {
        const months = {
            'jan': 0, 'feb': 1, 'mar': 2, 'apr': 3, 'mei': 4, 'jun': 5,
            'jul': 6, 'agu': 7, 'sep': 8, 'okt': 9, 'nov': 10, 'des': 11
        };
        try {
            const datePart = dateStr.split(',')[0].trim();
            const parts = datePart.split(' ');
            if (parts.length === 3) {
                const day = parseInt(parts[0]);
                const monthName = parts[1].toLowerCase();
                const year = parseInt(parts[2]);
                const month = months[monthName] !== undefined ? months[monthName] : 0;
                return new Date(year, month, day);
            }
        } catch (e) {
            console.error('Failed to parse date:', dateStr, e);
        }
        return null;
    }

    const startDateDisplay = document.getElementById('filter-start-date-display');
    const endDateDisplay = document.getElementById('filter-end-date-display');

    function formatToDDMMYY(isoDateStr) {
        if (!isoDateStr) return '';
        const parts = isoDateStr.split('-');
        if (parts.length === 3) {
            const year = parts[0].slice(-2);
            const month = parts[1];
            const day = parts[2];
            return `${day}/${month}/${year}`;
        }
        return isoDateStr;
    }

    function updateDateDisplays() {
        if (startDateDisplay && startDateInput) {
            startDateDisplay.value = formatToDDMMYY(startDateInput.value);
        }
        if (endDateDisplay && endDateInput) {
            endDateDisplay.value = formatToDDMMYY(endDateInput.value);
        }
    }

    function handleDateChange() {
        updateDateDisplays();
        filterTable();
    }

    const btnResetFilter = document.getElementById('btn-reset-filter');
    if (btnResetFilter) {
        btnResetFilter.addEventListener('click', function() {
            if (filterType) filterType.value = '';
            if (filterStatus) filterStatus.value = '';
            if (startDateInput) startDateInput.value = '';
            if (endDateInput) endDateInput.value = '';
            updateDateDisplays();
            filterTable();
        });
    }

    if (filterType) filterType.addEventListener('change', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
    if (startDateInput) {
        startDateInput.addEventListener('change', handleDateChange);
        startDateInput.addEventListener('input', handleDateChange);
    }
    if (endDateInput) {
        endDateInput.addEventListener('change', handleDateChange);
        endDateInput.addEventListener('input', handleDateChange);
    }
</script>
@endpush
