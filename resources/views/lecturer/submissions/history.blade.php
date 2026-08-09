@extends('layouts.lecturer')

@section('title', 'Riwayat Persetujuan - Universitas Amikom')

@section('content')
<div class="space-y-8 font-body-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">Riwayat Persetujuan Saya</h1>
        <p class="text-gray-600">Lihat riwayat permohonan dokumen yang telah Anda proses beserta keputusan yang diberikan.</p>
    </div>

    <!-- BEGIN: Combined Filters (Symmetrical 3 Columns x 2 Rows Layout) -->
    <form action="{{ route('lecturer.submissions.history') }}" method="GET" id="filter-form" class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col gap-5 mb-6">
        <div class="flex items-center justify-between border-b border-gray-200/80 pb-3">
            <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-amikom-purple" />
                <span>Filter Riwayat Persetujuan</span>
            </div>
            @if(request()->hasAny(['search', 'role', 'letter_type_id', 'status', 'batch', 'sort']))
                <a href="{{ route('lecturer.submissions.history') }}" class="text-xs font-semibold text-amikom-purple hover:text-amikom-purple/80 transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4" />
                    <span>Reset Filter</span>
                </a>
            @else
                <button type="button" onclick="document.getElementById('filter-form').reset(); window.location='{{ route('lecturer.submissions.history') }}';" class="text-xs font-semibold text-gray-500 hover:text-amikom-purple transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4 text-gray-400" />
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <!-- Symmetrical 3x2 Filter Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- 1. Search Student (Nama / NIM) -->
            <div class="flex flex-col gap-1.5">
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider" for="searchHistory">Cari Mahasiswa (Nama / NIM)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <x-icon name="search" class="w-4 h-4 text-gray-400" />
                    </div>
                    <input name="search" value="{{ request('search') }}" onchange="document.getElementById('filter-form').submit()" class="block w-full pl-10 pr-3.5 h-11 text-sm border border-gray-300 rounded-xl bg-gray-50/50 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple transition-all" id="searchHistory" placeholder="Nama atau NIM..." type="text">
                </div>
            </div>

            <!-- 2. Peran Saya -->
            <div class="flex flex-col gap-1.5">
                <label for="filter-role" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Peran Saya</label>
                <x-select-input 
                    id="filter-role" 
                    name="role" 
                    placeholder="Semua Peran"
                    :options="$roleOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- 3. Jenis Surat -->
            <div class="flex flex-col gap-1.5">
                <label for="filter-type" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Jenis Surat</label>
                <x-select-input 
                    id="filter-type" 
                    name="letter_type_id" 
                    placeholder="Semua Jenis Surat"
                    :options="$letterTypeOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- 4. Status Pengajuan -->
            <div class="flex flex-col gap-1.5">
                <label for="filter-status" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Status Pengajuan</label>
                <x-select-input 
                    id="filter-status" 
                    name="status" 
                    placeholder="Semua Status"
                    :options="$statusOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- 5. Angkatan -->
            <div class="flex flex-col gap-1.5">
                <label for="filter-batch" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Angkatan</label>
                <x-select-input 
                    id="filter-batch" 
                    name="batch" 
                    placeholder="Semua Angkatan"
                    :options="$batchOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- 6. Urutan Data -->
            <div class="flex flex-col gap-1.5">
                <label for="filter-sort" class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Urutan Data</label>
                <x-select-input 
                    id="filter-sort" 
                    name="sort" 
                    placeholder="Urutan Data"
                    :options="$sortOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>
        </div>
    </form>
    <!-- END: Combined Filters -->

    <!-- BEGIN: Data Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
        <div class="overflow-x-auto min-h-[300px]">
            <table class="w-full text-left divide-y divide-gray-200">
                <thead class="bg-[#F8F9FA] border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Mahasiswa</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">NIM</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Jenis Surat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Peran Saya</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @php
                        $getEnumValue = function ($val) {
                            if ($val instanceof \BackedEnum) {
                                return $val->value;
                            }
                            return is_string($val) ? $val : '';
                        };

                        $getEnumLabel = function ($val) {
                            if ($val instanceof \App\Enums\SubmissionStatus) {
                                return $val->label();
                            }
                            if ($val instanceof \App\Enums\SubmissionLogStatus) {
                                return $val->label();
                            }
                            if (is_string($val)) {
                                $enum = \App\Enums\SubmissionStatus::tryFrom(strtoupper($val)) 
                                    ?? \App\Enums\SubmissionLogStatus::tryFrom(strtoupper($val));
                                return $enum?->label() ?? $val;
                            }
                            return 'Diproses';
                        };

                        $getEnumBadgeClass = function ($val) {
                            if ($val instanceof \App\Enums\SubmissionStatus) {
                                return $val->badgeClass();
                            }
                            if ($val instanceof \App\Enums\SubmissionLogStatus) {
                                return $val->badgeClass();
                            }
                            if (is_string($val)) {
                                $enum = \App\Enums\SubmissionStatus::tryFrom(strtoupper($val));
                                return $enum?->badgeClass() ?? 'bg-amber-100 text-amber-800 border-amber-200';
                            }
                            return 'bg-amber-100 text-amber-800 border-amber-200';
                        };
                    @endphp

                    @forelse ($submissions as $sub)
                        @php
                            $studentName = $sub->student?->user?->name ?? 'Mahasiswa';
                            $studentNim = $sub->student?->student_number ?? '-';
                            $letterType = $sub->letterType?->name ?? 'Surat';
                            $submittedDate = $sub->created_at?->translatedFormat('d M Y') ?? $sub->created_at?->format('d M Y');
                            $roleName = $sub->approvalFlowStep?->approval_role?->label() ?? $sub->approvalFlowStep?->name ?? 'Dosen Verifikator';
                            
                            $statusValue = $getEnumValue($sub->status);
                            $statusLabel = $getEnumLabel($sub->status);
                            $statusBadgeClass = $getEnumBadgeClass($sub->status);
                            $myRoles = app(\App\Services\LecturerSubmissionService::class)->getLecturerRolesForSubmission($sub, auth()->user());

                            // Formatted Timeline Logs for Modal
                            $logsData = [];
                            foreach ($sub->logs->sortBy('created_at') as $log) {
                                $logStatusLabel = $getEnumLabel($log->status);
                                $logStatusValue = $getEnumValue($log->status);

                                $logsData[] = [
                                    'title' => $log->approvalFlowStep?->name ?? 'Pengajuan Dibuat',
                                    'approver' => $log->user?->name ?? 'Sistem',
                                    'time' => $log->created_at?->translatedFormat('d M Y H:i') ?? $log->created_at?->format('d M Y H:i'),
                                    'status' => $logStatusLabel,
                                    'status_raw' => $logStatusValue,
                                    'notes' => $log->notes,
                                ];
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 cursor-pointer transition-colors group"
                            onclick="openHistoryModal({{ json_encode([
                                'id' => $sub->id,
                                'student_name' => $studentName,
                                'nim' => $studentNim,
                                'letter_type' => $letterType,
                                'status' => $statusLabel,
                                'status_badge_class' => $statusBadgeClass,
                                'logs' => $logsData
                            ]) }})">
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $studentName }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $studentNim }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $letterType }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $submittedDate }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($myRoles as $roleItem)
                                        <x-role-badge :role="$roleItem" size="sm" />
                                    @empty
                                        <x-role-badge :role="$sub->approvalFlowStep?->approval_role ?? $roleName" size="sm" />
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-status-badge :status="$statusValue" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-16 text-center" colspan="6">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <x-icon name="history_toggle_off" class="w-12 h-12 text-gray-300" />
                                    <div>
                                        <p class="text-base font-bold text-gray-900">Belum Ada Riwayat Persetujuan</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Seluruh pengajuan yang telah Anda beri verifikasi akan tercatat di sini.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 flex items-center justify-between text-gray-600 text-sm flex-wrap gap-4">
            @if(is_object($submissions) && method_exists($submissions, 'firstItem'))
                <div>
                    Menampilkan <span class="font-medium text-gray-900">{{ $submissions->firstItem() ?? 0 }}-{{ $submissions->lastItem() ?? 0 }}</span> dari <span class="font-medium text-gray-900">{{ $submissions->total() }}</span> pengajuan
                </div>
                <div>
                    {{ $submissions->links() }}
                </div>
            @else
                <div>Menampilkan {{ count($submissions) }} pengajuan</div>
            @endif
        </div>
    </div>
    <!-- END: Data Table -->
</div>

<!-- Modal History Detail Timeline (Alternating Layout: Kanan-Kiri-Kanan-Kiri) -->
<x-modal id="history-modal" title="Detail Alur Persetujuan Dokumen" maxWidth="max-w-2xl">
    <x-slot:subtitle>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase border transition-colors mt-1" id="history-modal-status-badge">SEDANG DIPROSES</span>
    </x-slot:subtitle>

    <!-- Student Info Summary -->
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">Mahasiswa</p>
                <p class="text-base font-bold text-gray-900" id="history-modal-student-name">-</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">NIM</p>
                <p class="text-base text-gray-700 font-semibold" id="history-modal-student-nim">-</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">Jenis Dokumen</p>
                <p class="text-base text-gray-800 font-semibold" id="history-modal-doc-type">-</p>
            </div>
        </div>
    </div>

    <!-- Alternating Timeline Container (Kanan - Kiri - Kanan - Kiri) -->
    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent" id="history-timeline-container">
        <!-- Dynamic JS items populated here -->
    </div>

    <x-slot:footer>
        <button class="px-6 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors shadow-sm cursor-pointer" onclick="typeof closeModal === 'function' ? closeModal('history-modal') : document.getElementById('history-modal').classList.add('hidden')">
            Tutup
        </button>
    </x-slot:footer>
</x-modal>

<script>
function openHistoryModal(data) {
    document.getElementById('history-modal-student-name').innerText = data.student_name;
    document.getElementById('history-modal-student-nim').innerText = data.nim;
    document.getElementById('history-modal-doc-type').innerText = data.letter_type;

    const badge = document.getElementById('history-modal-status-badge');
    badge.innerText = data.status;
    badge.className = `inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase border transition-colors mt-1 ${data.status_badge_class}`;

    const container = document.getElementById('history-timeline-container');
    container.innerHTML = '';

    if (!data.logs || data.logs.length === 0) {
        container.innerHTML = '<p class="text-center text-sm text-gray-500 py-4">Belum ada riwayat log.</p>';
    } else {
        data.logs.forEach((log, index) => {
            const isOdd = index % 2 === 0;
            const statusUpper = (log.status_raw || log.status || '').toUpperCase();
            const isSuccess = statusUpper === 'APPROVED' || statusUpper === 'SUCCESS' || log.status === 'Disetujui' || log.status === 'Selesai';
            const isRejected = statusUpper === 'REJECTED' || log.status === 'Ditolak';

            let iconBg = 'bg-amikom-purple';
            let iconSvg = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

            if (isSuccess) {
                iconBg = 'bg-emerald-600';
            } else if (isRejected) {
                iconBg = 'bg-red-600';
                iconSvg = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
            }

            const stepHtml = `
                <div class="relative flex items-center justify-between md:justify-normal ${isOdd ? 'md:odd:flex-row-reverse' : ''} group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-white ${iconBg} text-white shadow shrink-0 md:order-1 ${isOdd ? 'md:group-odd:-translate-x-1/2' : 'md:group-even:translate-x-1/2'} z-10">
                        ${iconSvg}
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between space-x-2 mb-1">
                            <div class="font-bold text-gray-900 text-sm">${log.title}</div>
                            <time class="font-semibold text-xs text-gray-500">${log.time}</time>
                        </div>
                        <p class="text-xs font-medium text-gray-600">Oleh: <span class="font-bold text-gray-800">${log.approver}</span></p>
                        ${log.notes ? `<p class="mt-2 text-xs bg-gray-50 p-2 rounded-lg border border-gray-200 text-gray-700 italic">"${log.notes}"</p>` : ''}
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', stepHtml);
        });
    }

    if (typeof openModal === 'function') {
        openModal('history-modal');
    } else {
        document.getElementById('history-modal').classList.remove('hidden');
    }
}
</script>
@endsection