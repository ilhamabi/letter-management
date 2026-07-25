@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan - Universitas Amikom')

@php
    // Default / Mock data so the page works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';

    $submissions = $submissions ?? [
        [
            'id' => 1,
            'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
            'date' => '14 Okt 2023, 09:12',
            'status' => 'Sedang Diproses',
            'purpose' => 'Pengajuan Tugas Akhir Non-Reguler',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'reason' => '',
            'attachments' => [
                ['name' => 'Dokumen_1.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '14 Okt 2023, 09:12 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Sedang diproses oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
            ]
        ],
        [
            'id' => 2,
            'type' => 'Surat Rekomendasi Magang',
            'date' => '12 Okt 2023, 14:30',
            'status' => 'Disetujui',
            'purpose' => 'Persyaratan Magang Industri',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'reason' => '',
            'attachments' => [
                ['name' => 'Dokumen_1.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '12 Okt 2023, 14:30 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Dr. Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Disetujui Kaprodi', 'time' => 'Disetujui oleh Dr. Barka Satya, M.Kom.', 'status' => 'completed']
            ]
        ],
        [
            'id' => 3,
            'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
            'date' => '10 Okt 2023, 11:05',
            'status' => 'Ditolak',
            'purpose' => 'Pendaftaran Ujian Pendadaran',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'reason' => 'Berkas kelengkapan prasyarat pendadaran belum terpenuhi.',
            'attachments' => [
                ['name' => 'Dokumen_1.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '10 Okt 2023, 11:05 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Dr. Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Verifikasi Program Studi Ditolak', 'time' => 'Ditolak pada proses akhir', 'status' => 'rejected']
            ]
        ],
        [
            'id' => 4,
            'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
            'date' => '08 Okt 2023, 16:45',
            'status' => 'Disetujui',
            'purpose' => 'Persyaratan Lomba / Proyek Mandiri',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'reason' => '',
            'attachments' => [
                ['name' => 'Dokumen_1.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '08 Okt 2023, 16:45 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Dr. Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Disetujui Kaprodi', 'time' => 'Disetujui oleh Dr. Barka Satya, M.Kom.', 'status' => 'completed']
            ]
        ],
        [
            'id' => 5,
            'type' => 'Surat Rekomendasi Magang',
            'date' => '05 Okt 2023, 08:20',
            'status' => 'Disetujui',
            'purpose' => 'Persyaratan Magang BUMN',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'reason' => '',
            'attachments' => [
                ['name' => 'Dokumen_1.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '05 Okt 2023, 08:20 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Dr. Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Disetujui Kaprodi', 'time' => 'Disetujui oleh Dr. Barka Satya, M.Kom.', 'status' => 'completed']
            ]
        ]
    ];
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
                <span class="material-symbols-outlined text-primary text-[20px]">filter_list</span>
                <span>Filter Pengajuan</span>
            </div>
            <button id="btn-reset-filter" type="button" class="text-xs font-semibold text-primary hover:text-primary-container transition-colors flex items-center gap-1 cursor-pointer">
                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
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
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[18px]">calendar_today</span>
                    </div>
                    <span class="text-on-surface-variant font-medium text-sm">-</span>
                    <!-- End Date -->
                    <div class="relative flex-1 cursor-pointer" onclick="try{document.getElementById('filter-end-date').showPicker()}catch(e){}">
                        <input id="filter-end-date-display" type="text" placeholder="dd/mm/yy" readonly class="w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg pl-4 pr-10 h-11 text-body-sm font-body-sm text-on-surface transition-all cursor-pointer">
                        <input id="filter-end-date" type="date" class="sr-only">
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[18px]">calendar_today</span>
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
                        <option value="sedang diproses">Sedang Diproses</option>
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
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">No</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">Jenis Surat</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">Tgl. Pengajuan</th>
                        <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant font-body-sm text-on-surface" id="submission-table-body">
                    @foreach ($submissions as $index => $item)
                        <tr class="submission-row hover:bg-surface-container-low transition-colors duration-200 cursor-pointer" 
                            data-type="{{ strtolower($item['type']) }}" 
                            data-status="{{ strtolower($item['status']) }}" 
                            data-date="{{ $item['date'] }}"
                            onclick="openDetailModal('{{ addslashes($item['type']) }}', '{{ $item['date'] }}', '{{ $item['status'] }}', '{{ addslashes($item['reason'] ?? '') }}')">
                            <td class="px-6 py-5">{{ $index + 1 }}</td>
                            <td class="px-6 py-5 font-semibold text-deep-black">{{ $item['type'] }}</td>
                            <td class="px-6 py-5 text-on-surface-variant">{{ $item['date'] }}</td>
                            <td class="px-6 py-5 text-center">
                                @if ($item['status'] === 'Disetujui')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 text-[11px] rounded-full font-semibold tracking-wider">Disetujui</span>
                                @elseif ($item['status'] === 'Ditolak')
                                    <span class="px-3 py-1 bg-error-container text-error border border-error/20 text-[11px] rounded-full font-semibold tracking-wider">Ditolak</span>
                                @else
                                    <span class="px-3 py-1 bg-surface-container text-on-surface-variant border border-outline-variant text-[11px] rounded-full font-semibold tracking-wider">Sedang Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-surface-container-low flex items-center justify-between border-t border-outline-variant flex-wrap">
            <p class="text-body-sm text-on-surface-variant font-medium">Menampilkan 1-5 dari 24 pengajuan</p>
            <div class="flex gap-2">
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary text-on-primary font-bold">1</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">2</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">3</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Status Detail Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="status-detail-modal">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative bg-pure-white w-full max-w-lg mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="p-6 border-b border-outline-variant flex justify-between items-center">
                <div class="flex flex-col">
                    <h3 class="font-headline-sm text-headline-sm text-deep-black">Status Pengajuan</h3>
                    <p class="text-body-sm text-on-surface-variant" id="modal-title">Surat Keterangan Aktif Kuliah</p>
                </div>
                <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="closeModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]" id="modal-body">
                <!-- Dynamic Content Rendered via JavaScript -->
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3" id="modal-footer">
                <button class="px-6 py-2 border border-primary text-primary font-label-md rounded-lg hover:bg-primary-fixed/20 transition-colors flex items-center gap-2" id="download-btn">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Unduh Dokumen
                </button>
                <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openDetailModal(title, date, status, reason = '') {
        document.getElementById('modal-title').innerText = title;
        
        const modalBody = document.getElementById('modal-body');
        let timelineHTML = '';
        let detailsHTML = '';
        let slaHTML = '';
        const downloadBtn = document.getElementById('download-btn');

        if (status === 'Disetujui') {
            timelineHTML = `
                <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant">
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Pengajuan Terkirim</p>
                            <p class="text-body-sm text-on-surface-variant">${date}</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Persetujuan Dosen Wali</p>
                            <p class="text-body-sm text-on-surface-variant">Diverifikasi oleh Dr. Heri Setyawan, M.Kom.</p>
                        </div>
                    </div>
                     <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Disetujui Kaprodi</p>
                            <p class="text-body-sm text-on-surface-variant">Disetujui oleh Andi Afandi, M.T.</p>
                        </div>
                    </div>
                </div>
            `;
            detailsHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2 space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                        <p class="font-label-lg text-label-lg text-deep-black">Keperluan Umum</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $nim }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $prodi }}</p>
                    </div>
                </div>
            `;
            slaHTML = `<div class="bg-green-100 p-4 rounded-lg border border-green-200 flex gap-3"><span class="material-symbols-outlined text-green-700">info</span><p class="text-body-sm text-green-700">Pengajuan Anda telah disetujui. Dokumen dapat diunduh.</p></div>`;
            if (downloadBtn) downloadBtn.classList.remove('hidden');
        } else if (status === 'Ditolak') {
            timelineHTML = `
                <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant">
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Pengajuan Terkirim</p>
                            <p class="text-body-sm text-on-surface-variant">${date}</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Persetujuan Dosen Wali</p>
                            <p class="text-body-sm text-on-surface-variant">Diverifikasi oleh Dr. Heri Setyawan, M.Kom.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-error-container text-error flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-error">Verifikasi Program Studi Ditolak</p>
                            <p class="text-body-sm text-on-surface-variant">Ditolak pada proses akhir</p>
                        </div>
                    </div>
                </div>
            `;
            detailsHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2 space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                        <p class="font-label-lg text-label-lg text-deep-black">Syarat Beasiswa</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $nim }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $prodi }}</p>
                    </div>
                    ${reason ? `
                    <div class="col-span-1 md:col-span-2 space-y-1 bg-error-container/20 p-3 rounded-lg border border-error/20">
                        <p class="text-[10px] uppercase tracking-widest text-error font-semibold">Alasan Penolakan</p>
                        <p class="font-label-lg text-label-lg text-deep-black">${reason}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            slaHTML = `<div class="bg-error-container/20 p-4 rounded-lg border border-error/20 flex gap-3"><span class="material-symbols-outlined text-error">warning</span><p class="text-body-sm text-on-surface-variant">Pengajuan Anda ditolak. Silakan perbaiki data sesuai alasan penolakan dan buat pengajuan baru.</p></div>`;
            if (downloadBtn) downloadBtn.classList.add('hidden');
        } else {
            // Sedang Diproses
            timelineHTML = `
                <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant">
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-green-100 text-green-700 flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Pengajuan Terkirim</p>
                            <p class="text-body-sm text-on-surface-variant">${date}</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-secondary-container text-secondary flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm font-bold">sync</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-deep-black">Persetujuan Dosen Wali</p>
                            <p class="text-body-sm text-on-surface-variant">SEDANG DIPROSES oleh Dr. Heri Setyawan, M.Kom.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-8 w-6 h-6 rounded-full bg-surface-container-high text-on-surface-variant flex items-center justify-center z-10">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg text-on-surface-variant">Verifikasi Program Studi</p>
                            <p class="text-body-sm text-on-surface-variant">Akan datang</p>
                        </div>
                    </div>
                </div>
            `;
            detailsHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2 space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                        <p class="font-label-lg text-label-lg text-deep-black">Keperluan Umum</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $nim }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                        <p class="font-label-lg text-label-lg text-deep-black">{{ $prodi }}</p>
                    </div>
                </div>
            `;
            slaHTML = `<div class="bg-primary-fixed/30 p-4 rounded-lg border border-primary/10 flex gap-3"><span class="material-symbols-outlined text-primary">info</span><p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat menghubungi bagian Akademik.</p></div>`;
            if (downloadBtn) downloadBtn.classList.add('hidden');
        }

        modalBody.innerHTML = `
            ${timelineHTML}
            <hr class="border-outline-variant">
            ${detailsHTML}
            <div class="space-y-2 mt-4">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Lampiran</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group">
                        <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-label-sm text-deep-black truncate font-semibold">Dokumen_1.pdf</p>
                            <p class="text-[10px] text-on-surface-variant">1.2 MB</p>
                        </div>
                    </div>
                </div>
            </div>
            ${slaHTML}
        `;

        document.getElementById('status-detail-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('status-detail-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Interactive Client-Side Filters
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

            row.style.display = show ? '' : 'none';
        });
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
