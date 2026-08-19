@extends('layouts.student')

@section('title', 'Riwayat Pengajuan - Universitas Amikom')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $prodi = $user?->student?->study_program ?? 'D3 Teknik Informatika';
    $profilePhoto = null;

    $submissions = $submissions ?? [];
    $letterTypes = $letterTypes ?? [];

    $typeOptions = [
        ['value' => '', 'label' => 'Semua Jenis Surat']
    ];
    foreach ($letterTypes as $type) {
        $typeOptions[] = [
            'value' => (string) $type->id,
            'label' => $type->name,
            'badge' => $type->allow_group_submission ? 'Kelompok' : 'Individu',
            'badgeClass' => $type->allow_group_submission 
                ? 'bg-indigo-50 text-indigo-700 border-indigo-200' 
                : 'bg-gray-50 text-gray-600 border-gray-200'
        ];
    }

    use App\Enums\SubmissionStatus;

    $statusOptions = [
        ['value' => '', 'label' => 'Semua Status'],
        ['value' => 'diproses', 'label' => 'Diproses', 'badge' => 'Sedang Diproses', 'badgeClass' => SubmissionStatus::IN_REVIEW->badgeClass()],
        ['value' => 'disetujui', 'label' => 'Disetujui', 'badge' => 'Disetujui', 'badgeClass' => SubmissionStatus::APPROVED->badgeClass()],
        ['value' => 'ditolak', 'label' => 'Ditolak', 'badge' => 'Ditolak', 'badgeClass' => SubmissionStatus::REJECTED->badgeClass()],
    ];

    $sortOptions = [
        ['value' => 'newest', 'label' => 'Terbaru'],
        ['value' => 'oldest', 'label' => 'Terlama'],
    ];
@endphp

@section('content')
    <!-- Page Title -->
    <section class="flex flex-col gap-2">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Pengajuan Saya</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan pantau status permohonan dokumen akademik Anda di sini.</p>
    </section>

    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <x-icon name="check_circle" class="w-5 h-5 text-green-600 shrink-0" />
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900 p-1 cursor-pointer">
                <x-icon name="close" class="w-4 h-4" />
            </button>
        </div>
    @endif
    
    <!-- Filter Section -->
    <form action="{{ route('student.submissions.history') }}" method="GET" id="filter-form" class="bg-pure-white p-6 rounded-xl border border-outline-variant shadow-sm flex flex-col gap-4">
        <div class="flex items-center justify-between border-b border-outline-variant/60 pb-3">
            <div class="flex items-center gap-2 text-on-surface font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-primary" />
                <span>Filter Pengajuan</span>
            </div>
            @if(request()->hasAny(['start_date', 'end_date', 'letter_type_id', 'status', 'sort']))
                <a href="{{ route('student.submissions.history') }}" class="text-xs font-semibold text-primary hover:text-primary-container transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4" />
                    <span>Reset Filter</span>
                </a>
            @else
                <button type="button" onclick="resetFilterForm()" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4" />
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            <!-- Date Range -->
            <div class="lg:col-span-4 flex flex-col gap-1.5">
                <label class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Periode Tanggal</label>
                <div class="flex items-center gap-2">
                    <!-- Start Date -->
                    <div class="relative flex-1 cursor-pointer" onclick="try{document.getElementById('filter-start-date').showPicker()}catch(e){}">
                        <input id="filter-start-date-display" type="text" placeholder="dd/mm/yy" readonly class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl pl-3.5 pr-9 h-11 text-xs font-body-sm text-on-surface transition-all cursor-pointer">
                        <input id="filter-start-date" name="start_date" type="date" value="{{ request('start_date') }}" onchange="handleDateInputChange()" class="sr-only">
                        <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                    </div>
                    <span class="text-on-surface-variant font-medium text-sm">-</span>
                    <!-- End Date -->
                    <div class="relative flex-1 cursor-pointer" onclick="try{document.getElementById('filter-end-date').showPicker()}catch(e){}">
                        <input id="filter-end-date-display" type="text" placeholder="dd/mm/yy" readonly class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl pl-3.5 pr-9 h-11 text-xs font-body-sm text-on-surface transition-all cursor-pointer">
                        <input id="filter-end-date" name="end_date" type="date" value="{{ request('end_date') }}" onchange="handleDateInputChange()" class="sr-only">
                        <x-icon name="calendar_today" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
                    </div>
                </div>
            </div>

            <!-- Jenis Surat -->
            <div class="lg:col-span-3 flex flex-col gap-1.5">
                <label for="filter-type" class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Jenis Surat</label>
                <x-select-input 
                    id="filter-type" 
                    name="letter_type_id" 
                    placeholder="Semua Jenis Surat"
                    :options="$typeOptions" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- Status -->
            <div class="lg:col-span-3 flex flex-col gap-1.5">
                <label for="filter-status" class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Status Pengajuan</label>
                <x-select-input 
                    id="filter-status" 
                    name="status" 
                    placeholder="Semua Status"
                    :options="$statusOptions" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- Urutan Data -->
            <div class="lg:col-span-2 flex flex-col gap-1.5">
                <label for="filter-sort" class="block text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Urutan Data</label>
                <x-select-input 
                    id="filter-sort" 
                    name="sort" 
                    placeholder="Urutan Data"
                    :options="$sortOptions" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>
        </div>
    </form>
    
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
                            $subDto = app(\App\Services\StudentDashboardService::class)->formatSubmissionDto($item);
                        @endphp
                        <tr class="submission-row hover:bg-surface-container-low/50 transition-colors duration-200 cursor-pointer" 
                            onclick="openStatusModal({{ json_encode($subDto) }})">
                            <td class="px-6 py-4 text-center text-on-surface-variant font-medium">
                                {{ is_object($submissions) && method_exists($submissions, 'firstItem') ? ($submissions->firstItem() + $index) : ($index + 1) }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-deep-black">
                                <div class="flex items-center gap-2">
                                    <span>{{ $subDto['type'] }}</span>
                                    @if($subDto['isGroup'])
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">Kelompok</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">Individu</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant">{{ $subDto['date'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <x-status-badge :status="$subDto['status']" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr id="no-results-row">
                            <td colspan="4" class="py-12 text-center text-on-surface-variant font-medium">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-outline-variant/30 flex items-center justify-center text-on-surface-variant">
                                        <x-icon name="search_off" class="w-6 h-6" />
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-deep-black">Tidak ada data pengajuan yang sesuai dengan filter yang dipilih.</p>
                                        <p class="text-xs text-on-surface-variant mt-1">Coba ubah rentang tanggal, jenis surat, atau status yang Anda cari.</p>
                                    </div>
                                    <a href="{{ route('student.submissions.history') }}" class="mt-1 px-4 py-2 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition-colors inline-flex items-center gap-1.5">
                                        <x-icon name="restart_alt" class="w-4 h-4" />
                                        <span>Reset Filter</span>
                                    </a>
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

    <!-- Submission Detail Modal -->
    @include('student.submissions.partials.submission-detail-modal')
@endsection

@push('scripts')
<script>
    const startDateInput = document.getElementById('filter-start-date');
    const endDateInput = document.getElementById('filter-end-date');
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

    function handleDateInputChange() {
        updateDateDisplays();
        document.getElementById('filter-form').submit();
    }

    function resetFilterForm() {
        window.location.href = "{{ route('student.submissions.history') }}";
    }

    // Initialize displays on load
    document.addEventListener('DOMContentLoaded', function() {
        updateDateDisplays();
    });
</script>
@endpush
