@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan - Universitas Amikom')

@php
    // Default / Mock data so the page works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto =
        $profilePhoto ??
        'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';

    $submissions = $submissions ?? [
        [
            'id' => 1,
            'type' => 'Surat Keterangan Aktif Kuliah',
            'date' => '14 Okt 2023, 09:12',
            'status' => 'Disetujui',
            'purpose' => 'Syarat Beasiswa',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ['name' => 'Transkrip_Nilai.pdf', 'size' => '850 KB'],
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '14 Okt 2023, 09:12 WIB', 'status' => 'completed'],
                [
                    'title' => 'Persetujuan Dosen Wali',
                    'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.',
                    'status' => 'completed',
                ],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed'],
            ],
        ],
        [
            'id' => 2,
            'type' => 'Permohonan Cuti Akademik',
            'date' => '12 Okt 2023, 14:30',
            'status' => 'Disetujui',
            'purpose' => 'Fokus Kerja',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'Surat_Pernyataan_Orang_Tua.pdf', 'size' => '1.5 MB'],
                ['name' => 'Formulir_Cuti.pdf', 'size' => '950 KB'],
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '12 Okt 2023, 14:30 WIB', 'status' => 'completed'],
                [
                    'title' => 'Persetujuan Dosen Wali',
                    'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.',
                    'status' => 'completed',
                ],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed'],
            ],
        ],
        [
            'id' => 3,
            'type' => 'Transkrip Nilai Sementara',
            'date' => '10 Okt 2023, 11:05',
            'status' => 'Disetujui',
            'purpose' => 'Melamar Magang',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB']],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '10 Okt 2023, 11:05 WIB', 'status' => 'completed'],
                [
                    'title' => 'Persetujuan Dosen Wali',
                    'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.',
                    'status' => 'completed',
                ],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed'],
            ],
        ],
        [
            'id' => 4,
            'type' => 'Surat Izin Penelitian',
            'date' => '08 Okt 2023, 16:45',
            'status' => 'Ditolak',
            'purpose' => 'Tugas Akhir / Skripsi',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'Proposal_Penelitian.pdf', 'size' => '2.4 MB'],
                ['name' => 'Surat_Pengantar_Instansi.pdf', 'size' => '1.1 MB'],
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '08 Okt 2023, 16:45 WIB', 'status' => 'completed'],
                [
                    'title' => 'Penolakan Dosen Wali',
                    'time' => 'Ditolak oleh Heri Setyawan, M.Kom. (Alasan: Proposal belum disetujui)',
                    'status' => 'rejected',
                ],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Proses dihentikan', 'status' => 'cancelled'],
            ],
        ],
        [
            'id' => 5,
            'type' => 'Surat Pengantar Magang',
            'date' => '05 Okt 2023, 08:20',
            'status' => 'Disetujui',
            'purpose' => 'Persyaratan Magang BUMN',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [['name' => 'Proposal_Magang.pdf', 'size' => '1.8 MB']],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '05 Okt 2023, 08:20 WIB', 'status' => 'completed'],
                [
                    'title' => 'Persetujuan Dosen Wali',
                    'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.',
                    'status' => 'completed',
                ],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed'],
            ],
        ],
    ];
@endphp

@section('content')
    <!-- Page Title -->
    <section class="flex flex-col gap-2">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Pengajuan Saya</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan pantau status permohonan dokumen akademik
            Anda di sini.</p>
    </section>

    <!-- Filter Section -->
    <section
        class="bg-pure-white p-6 rounded-xl border border-outline-variant shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4 w-full">
            <div class="flex items-center gap-2">
                <div class="relative">
                    <input id="filter-start-date"
                        class="appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer w-40"
                        onblur="(this.type='text')" onfocus="(this.type='date')" placeholder="Mulai Tanggal" type="text">
                    <span
                        class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[20px]">calendar_today</span>
                </div>
                <span class="text-on-surface-variant font-medium">-</span>
                <div class="relative">
                    <input id="filter-end-date"
                        class="appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer w-40"
                        onblur="(this.type='text')" onfocus="(this.type='date')" placeholder="Sampai Tanggal"
                        type="text">
                    <span
                        class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[20px]">calendar_today</span>
                </div>
            </div>

            <div class="relative flex-1 min-w-[200px]">
                <select id="filter-type"
                    class="w-full appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer">
                    <option value="">Semua Jenis Surat</option>
                    <option value="aktif">Keterangan Aktif</option>
                    <option value="cuti">Cuti Akademik</option>
                    <option value="transkrip">Transkrip Nilai</option>
                    <option value="penelitian">Izin Penelitian</option>
                    <option value="magang">Pengantar Magang</option>
                    <option value="legalisir">Legalisir Ijazah</option>
                </select>
                <span
                    class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
            </div>

            <div class="relative w-48">
                <select id="filter-status"
                    class="w-full appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <span
                    class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
            </div>
        </div>
    </section>

    <!-- Data Table -->
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th
                            class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">
                            No</th>
                        <th
                            class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">
                            Jenis Surat</th>
                        <th
                            class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">
                            Tgl. Pengajuan</th>
                        <th
                            class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium text-center">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant"
                    id="submissions-tbody">
                    @foreach ($submissions as $index => $sub)
                        <tr class="submission-row hover:bg-surface-container-low transition-colors duration-200 cursor-pointer"
                            data-type="{{ $sub['type'] }}" data-status="{{ $sub['status'] }}"
                            data-date="{{ $sub['date'] }}" onclick="openStatusDetailModal({{ json_encode($sub) }})">
                            <td class="py-5 px-6 font-semibold text-deep-black">{{ $index + 1 }}</td>
                            <td class="py-5 px-6 font-semibold text-deep-black">{{ $sub['type'] }}</td>
                            <td class="py-5 px-6 text-on-surface-variant">{{ $sub['date'] }}</td>
                            <td class="py-5 px-6 text-center">
                                @if (strtolower($sub['status']) === 'disetujui')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                        {{ $sub['status'] }}
                                    </span>
                                @elseif (strtolower($sub['status']) === 'ditolak')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                        {{ $sub['status'] }}
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-surface-container text-on-surface-variant border border-outline-variant">
                                        {{ $sub['status'] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Status Detail Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="status-detail-modal">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
        <div
            class="relative bg-pure-white w-full max-w-lg mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-outline-variant flex justify-between items-center">
                <div class="flex flex-col">
                    <h3 class="font-headline-sm text-headline-sm text-deep-black">Detail Status Pengajuan</h3>
                    <p id="modal-title" class="text-body-sm text-on-surface-variant">Surat Keterangan Aktif Kuliah</p>
                </div>
                <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="closeModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6 space-y-6 overflow-y-auto max-h-[60vh]">
                <!-- Status Timeline -->
                <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant"
                    id="modal-timeline">
                    <!-- Timeline will be populated dynamically -->
                </div>
            </div>
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end">
                <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow"
                    onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openStatusDetailModal(data) {
            document.getElementById('modal-title').innerText = data.type;

            let timelineHtml = '';
            if (data.timeline && data.timeline.length > 0) {
                data.timeline.forEach(step => {
                    let icon = 'hourglass_empty';
                    let iconClass = 'bg-surface-container text-on-surface-variant';

                    if (step.status === 'completed') {
                        icon = 'check';
                        iconClass = 'bg-green-100 text-green-700';
                    } else if (step.status === 'rejected') {
                        icon = 'close';
                        iconClass = 'bg-error-container text-error';
                    } else if (step.status === 'active') {
                        icon = 'sync';
                        iconClass = 'bg-secondary-container text-secondary';
                    } else if (step.status === 'upcoming' || step.status === 'cancelled') {
                        icon = step.status === 'cancelled' ? 'block' : 'schedule';
                        iconClass = 'bg-surface-container-high text-on-surface-variant';
                    }

                    timelineHtml += `
                <div class="relative font-body-sm">
                    <div class="absolute -left-8 w-6 h-6 rounded-full ${iconClass} flex items-center justify-center z-10">
                        <span class="material-symbols-outlined text-sm font-bold">${icon}</span>
                    </div>
                    <div>
                        <p class="font-label-lg text-label-lg text-deep-black">${step.title}</p>
                        <p class="text-body-sm text-on-surface-variant">${step.time}</p>
                    </div>
                </div>`;
                });
            }
            document.getElementById('modal-timeline').innerHTML = timelineHtml;

            // Show Modal
            document.getElementById('status-detail-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('status-detail-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Client-side filtering logic
        const filterType = document.getElementById('filter-type');
        const filterStatus = document.getElementById('filter-status');
        const startDateInput = document.getElementById('filter-start-date');
        const endDateInput = document.getElementById('filter-end-date');
        const rows = document.querySelectorAll('.submission-row');

        function filterTable() {
            const selectedType = filterType.value.toLowerCase();
            const selectedStatus = filterStatus.value.toLowerCase();
            const startDateVal = startDateInput.value ? new Date(startDateInput.value) : null;
            const endDateVal = endDateInput.value ? new Date(endDateInput.value) : null;

            rows.forEach(row => {
                const type = row.getAttribute('data-type').toLowerCase();
                const status = row.getAttribute('data-status').toLowerCase();
                const dateStr = row.getAttribute('data-date'); // e.g., "14 Okt 2023, 09:12"

                let show = true;

                // Type filter
                if (selectedType && !type.includes(selectedType)) {
                    show = false;
                }

                // Status filter
                if (selectedStatus && !status.includes(selectedStatus)) {
                    show = false;
                }

                // Date range filter
                if (show && (startDateVal || endDateVal)) {
                    const rowDate = parseIndonesianDate(dateStr);
                    if (rowDate) {
                        if (startDateVal) {
                            const start = new Date(startDateVal.getFullYear(), startDateVal.getMonth(), startDateVal
                                .getDate());
                            const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                            if (current < start) show = false;
                        }
                        if (endDateVal) {
                            const end = new Date(endDateVal.getFullYear(), endDateVal.getMonth(), endDateVal
                                .getDate());
                            const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                            if (current > end) show = false;
                        }
                    }
                }

                row.style.display = show ? '' : 'none';
            });
        }

        // Helper function to parse dates formatted as "14 Okt 2023, 09:12"
        function parseIndonesianDate(dateStr) {
            const months = {
                'jan': 0,
                'feb': 1,
                'mar': 2,
                'apr': 3,
                'mei': 4,
                'jun': 5,
                'jul': 6,
                'agu': 7,
                'sep': 8,
                'okt': 9,
                'nov': 10,
                'des': 11
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

        if (filterType) filterType.addEventListener('change', filterTable);
        if (filterStatus) filterStatus.addEventListener('change', filterTable);
        if (startDateInput) startDateInput.addEventListener('change', filterTable);
        if (endDateInput) endDateInput.addEventListener('change', filterTable);
    </script>
@endpush
