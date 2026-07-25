@extends('layouts.student')

@section('title', 'Dashboard - Universitas Amikom')

@php
    // Detect if we want to simulate the empty state (via query parameter e.g., ?empty=1)
    $isEmpty = request()->has('empty');

    // Default / Mock data so the dashboard works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';

    if ($isEmpty) {
        $stats = $stats ?? [
            'pending' => 0,
            'approved' => 12,
            'rejected' => 1,
        ];
        $submissions = [];
    } else {
        $stats = $stats ?? [
            'pending' => 3,
            'approved' => 12,
            'rejected' => 1,
        ];

        $submissions = $submissions ?? [
            [
                'id' => 1,
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '24 Okt 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Pengajuan TA Non-Reguler',
                'lecturer' => 'Heri Setyawan, M.Kom.',
                'kaprodi' => 'Dr. Barka Satya, M.Kom.',
                'time' => '09:45 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                    ['name' => 'Draft_Proposal.pdf', 'size' => '850 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '14 Okt 2023, 09:12', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Sedang diverifikasi oleh Kaprodi', 'status' => 'active']
                ]
            ],
            [
                'id' => 2,
                'type' => 'Surat Rekomendasi Magang',
                'date' => '02 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Magang Industri',
                'lecturer' => 'Heri Setyawan, M.Kom.',
                'kaprodi' => 'Dr. Barka Satya, M.Kom.',
                'time' => '10:15 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '02 Nov 2023, 10:15', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Sedang diverifikasi oleh Kaprodi', 'status' => 'active']
                ]
            ],
            [
                'id' => 3,
                'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'date' => '15 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Pendaftaran Ujian Pendadaran',
                'lecturer' => 'Heri Setyawan, M.Kom.',
                'kaprodi' => 'Dr. Barka Satya, M.Kom.',
                'time' => '08:30 WIB',
                'attachments' => [
                    ['name' => 'Transkrip_Final.pdf', 'size' => '2.1 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '15 Nov 2023, 08:30', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Sedang diverifikasi oleh Kaprodi', 'status' => 'active']
                ]
            ],
            [
                'id' => 4,
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '20 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Proyek Industri Mandiri',
                'lecturer' => 'Heri Setyawan, M.Kom.',
                'kaprodi' => 'Dr. Barka Satya, M.Kom.',
                'time' => '11:00 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '20 Nov 2023, 11:00', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Sedang diverifikasi oleh Kaprodi', 'status' => 'active']
                ]
            ],
            [
                'id' => 5,
                'type' => 'Surat Rekomendasi Magang',
                'date' => '25 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Magang BUMN Merdeka Belajar',
                'lecturer' => 'Heri Setyawan, M.Kom.',
                'kaprodi' => 'Dr. Barka Satya, M.Kom.',
                'time' => '14:20 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '510 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '25 Nov 2023, 14:20', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Sedang diverifikasi oleh Kaprodi', 'status' => 'active']
                ]
            ],
        ];
    }
@endphp

@section('content')
    <!-- Welcome Section -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-pure-white p-8 rounded-xl border border-outline-variant w-full">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Selamat datang kembali, {{ explode(' ', $studentName)[0] }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Berikut ikhtisar permintaan dokumen akademik Anda.</p>
        </div>
    </section>
    
    <!-- Quick Stats -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
        <!-- Pending -->
        <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-primary-fixed rounded-lg text-primary">
                <span class="material-symbols-outlined text-[28px]" data-icon="pending_actions">pending_actions</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant mb-1">Menunggu</p>
                <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['pending'] }}</p>
            </div>
        </div>
        
        <!-- Approved -->
        <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 rounded-lg bg-green-100 text-green-700">
                <span class="material-symbols-outlined text-[28px]" data-icon="check_circle">check_circle</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant mb-1">Disetujui</p>
                <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['approved'] }}</p>
            </div>
        </div>
        
        <!-- Rejected -->
        <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="p-3 bg-error-container rounded-lg text-error">
                <span class="material-symbols-outlined text-[28px]" data-icon="cancel">cancel</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant mb-1">Ditolak / Perlu Tindakan</p>
                <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['rejected'] }}</p>
            </div>
        </div>
    </section>
    
    <!-- Recent Requests Table -->
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col w-full">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-deep-black">Pengajuan yang Berlangsung</h3>
            <a href="{{ url('/student/submission-history') }}" class="text-primary font-label-md text-label-md hover:underline flex items-center gap-1">
                Lihat Riwayat Pengajuan
                <span class="material-symbols-outlined text-sm">chevron_right</span>
            </a>
        </div>
        
        @if (count($submissions) > 0)
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low">
                        <tr>
                            <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium">Jenis Surat</th>
                            <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium">Tanggal Pengajuan</th>
                            <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant">
                        @foreach ($submissions as $sub)
                            <tr class="hover:bg-surface-container-low transition-colors duration-200 cursor-pointer" onclick="openStatusModal({{ json_encode($sub) }})">
                                <td class="py-5 px-6 font-semibold text-deep-black">{{ $sub['type'] }}</td>
                                <td class="py-5 px-6 text-on-surface-variant">{{ $sub['date'] }}</td>
                                <td class="py-5 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-surface-container text-on-surface-variant border border-outline-variant flex items-center justify-center gap-1.5 w-fit mx-auto">
                                        {{ $sub['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center text-on-surface-variant mb-4">
                    <span class="material-symbols-outlined text-4xl">description</span>
                </div>
                <h4 class="font-headline-sm text-headline-sm text-deep-black mb-2">Tidak ada pengajuan yang sedang berlangsung</h4>
                <p class="font-body-md text-body-md text-on-surface-variant mb-6">Semua permintaan dokumen Anda telah selesai diproses atau belum ada pengajuan baru.</p>
                <a class="text-primary font-label-lg text-label-lg hover:underline flex items-center gap-2" href="{{ url('/student/submission-history') }}">
                    Lihat Riwayat Pengajuan
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        @endif
    </section>

    <!-- Modal Overlay -->
    <div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="status-modal">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('status-modal').classList.add('hidden')"></div>
        <div class="relative bg-pure-white w-full max-w-lg mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-outline-variant flex justify-between items-center">
                <div class="flex flex-col">
                    <h3 class="font-headline-sm text-headline-sm text-deep-black">Status Pengajuan</h3>
                    <p class="text-body-sm text-on-surface-variant" id="modal-doc-name">Verifikasi Pendaftaran</p>
                    <span class="mt-2 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#fef3c7] text-[#92400e] border border-[#fcd400] flex items-center justify-center gap-1.5 w-fit" id="modal-status-badge">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#92400e] animate-pulse"></span>
                        <span id="modal-status-text">SEDANG DIPROSES</span>
                    </span>
                </div>
                <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="document.getElementById('status-modal').classList.add('hidden')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 space-y-6 overflow-y-auto max-h-[60vh]">
                <!-- Status Timeline -->
                <div class="relative pl-8 space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant" id="timeline-container">
                    <!-- Timeline items will be populated dynamically -->
                </div>

                <hr class="border-outline-variant">

                <!-- Details Section -->
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">KEPERLUAN</p>
                        <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-purpose">Syarat Beasiswa</p>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-2">DOSEN DITUJU</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant">
                                <p class="text-body-sm text-on-surface-variant font-semibold mb-1">Dosen Wali</p>
                                <p class="text-body-sm font-bold text-deep-black" id="modal-lecturer">Heri Setyawan, M.Kom.</p>
                            </div>
                            <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant">
                                <p class="text-body-sm text-on-surface-variant font-semibold mb-1">Kaprodi</p>
                                <p class="text-body-sm font-bold text-deep-black" id="modal-kaprodi">Andi Afandi, M.T.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">NIM</p>
                            <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-nim">{{ $nim }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">PROGRAM STUDI</p>
                            <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-prodi">{{ $prodi }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-2">LAMPIRAN</p>
                        <div class="grid grid-cols-2 gap-4" id="attachments-container">
                            <!-- Attachments will be populated dynamically -->
                        </div>
                    </div>
                </div>

                <!-- SLA Info Box -->
                <div class="bg-primary-fixed/10 p-4 rounded-lg border border-primary-container/10 flex gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat menghubungi dosen terkait.</p>
                </div>
            </div>
            
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
                <button class="px-8 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('status-modal').classList.add('hidden')">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openStatusModal(data) {
        // Update Title & Status Badge
        document.getElementById('modal-doc-name').innerText = data.type;
        document.getElementById('modal-status-text').innerText = (data.status || 'SEDANG DIPROSES').toUpperCase();
        
        // Populate the timeline dynamically
        const timelineContainer = document.getElementById('timeline-container');
        timelineContainer.innerHTML = ''; // Clear previous items
        
        if (data.timeline && data.timeline.length > 0) {
            data.timeline.forEach((step) => {
                let iconBgClass = '';
                let iconText = '';
                let pulseClass = '';
                let textClass = 'text-deep-black';
                
                if (step.status === 'completed') {
                    iconBgClass = 'bg-green-100 text-green-700';
                    iconText = 'check';
                } else if (step.status === 'active') {
                    iconBgClass = 'bg-[#fef3c7] text-[#92400e] border border-[#fcd400]';
                    iconText = 'hourglass_empty';
                    pulseClass = 'animate-pulse';
                } else {
                    iconBgClass = 'bg-surface-container text-on-surface-variant';
                    iconText = 'schedule';
                    textClass = 'text-on-surface-variant';
                }
                
                const stepHtml = `
                    <div class="relative font-body-sm">
                        <div class="absolute -left-8 w-6 h-6 rounded-full ${iconBgClass} flex items-center justify-center z-10 ${pulseClass}">
                            <span class="material-symbols-outlined text-sm">${iconText}</span>
                        </div>
                        <div>
                            <p class="font-label-lg text-label-lg ${textClass}">${step.title}</p>
                            <p class="text-body-sm text-on-surface-variant">${step.time}</p>
                        </div>
                    </div>
                `;
                timelineContainer.insertAdjacentHTML('beforeend', stepHtml);
            });
        }

        // Update Details
        document.getElementById('modal-purpose').innerText = data.purpose || 'Syarat Beasiswa';
        document.getElementById('modal-lecturer').innerText = data.lecturer || 'Heri Setyawan, M.Kom.';
        if (document.getElementById('modal-kaprodi')) {
            document.getElementById('modal-kaprodi').innerText = data.kaprodi || 'Andi Afandi, M.T.';
        }

        // Update Attachments
        const attachmentsContainer = document.getElementById('attachments-container');
        attachmentsContainer.innerHTML = '';
        if (data.attachments && data.attachments.length > 0) {
            data.attachments.forEach(file => {
                const fileHtml = `
                    <div class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group">
                        <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div class="overflow-hidden font-body-sm">
                            <p class="text-label-sm text-deep-black truncate font-semibold">${file.name}</p>
                            <p class="text-[10px] text-on-surface-variant">${file.size}</p>
                        </div>
                    </div>
                `;
                attachmentsContainer.insertAdjacentHTML('beforeend', fileHtml);
            });
        } else {
            attachmentsContainer.innerHTML = '<p class="text-body-sm text-on-surface-variant italic col-span-2">Tidak ada lampiran</p>';
        }

        // Show Modal
        document.getElementById('status-modal').classList.remove('hidden');
    }
</script>
@endpush
