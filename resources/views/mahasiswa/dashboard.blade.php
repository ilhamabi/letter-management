@extends('layouts.mahasiswa')

@section('title', 'Dashboard - Universitas Amikom')

@php
    // Detect if we want to simulate the empty state (via query parameter e.g., ?empty=1)
    $isEmpty = request()->has('empty');

    // Default / Mock data so the dashboard works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';

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
                'type' => 'Surat Keterangan Aktif',
                'date' => '24 Okt 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Syarat Beasiswa',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '09:45 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                    ['name' => 'Transkrip_Nilai.pdf', 'size' => '850 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '24 Okt 2023, 09:45 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 2,
                'type' => 'Verifikasi Pendaftaran',
                'date' => '02 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Lomba Kompetisi Nasional',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '10:15 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '02 Nov 2023, 10:15 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 3,
                'type' => 'Legalisir Ijazah',
                'date' => '15 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Persyaratan Melamar Pekerjaan',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '08:30 WIB',
                'attachments' => [
                    ['name' => 'Ijazah_Alex.pdf', 'size' => '2.1 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '15 Nov 2023, 08:30 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 4,
                'type' => 'Transkrip Akademik Sementara',
                'date' => '20 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Magang MBKM Merdeka Belajar',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '11:00 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                    ['name' => 'KRS_Terakhir.pdf', 'size' => '720 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '20 Nov 2023, 11:00 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 5,
                'type' => 'Surat Bebas Pustaka',
                'date' => '25 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Syarat Kelulusan Wisuda',
                'lecturer' => 'Perpustakaan Amikom',
                'time' => '14:20 WIB',
                'attachments' => [
                    ['name' => 'Bebas_Pinjam_Perpus.pdf', 'size' => '510 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '25 Nov 2023, 14:20 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
        ];
    }
@endphp

@section('content')
    <!-- Welcome Section -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-pure-white p-8 rounded-xl border border-outline-variant">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Selamat datang kembali, {{ $studentName }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Berikut ikhtisar permintaan dokumen akademik Anda.</p>
        </div>
    </section>
    
    <!-- Quick Stats -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
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
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-surface-container text-on-surface-variant border border-outline-variant">
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
                    <p class="text-body-sm text-on-surface-variant" id="modal-doc-name">Legalisir Ijazah</p>
                </div>
                <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="document.getElementById('status-modal').classList.add('hidden')">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 space-y-6 overflow-y-auto max-h-[60vh]">
                <!-- Content (Top): Status Timeline -->
                <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant" id="timeline-container">
                    <!-- Timeline items will be populated dynamically -->
                </div>
                
                <!-- Divider -->
                <hr class="border-outline-variant">
                
                <!-- Content (Bottom): Submission Details -->
                <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                        <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-purpose">Syarat Beasiswa</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Dosen Dituju</p>
                        <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-lecturer">Dr. Heri Setyawan, M.Kom. (Dosen Wali)</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                        <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-nim">{{ $nim }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                        <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-prodi">{{ $prodi }}</p>
                    </div>
                    
                    <div class="col-span-2 space-y-2 mt-2">
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Lampiran</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="attachments-container">
                            <!-- Attachments will be populated dynamically -->
                        </div>
                    </div>
                </div>
                
                <!-- SLA Info Box -->
                <div class="bg-primary-fixed/30 p-4 rounded-lg border border-primary/10 flex gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat mengirim pengingat.</p>
                </div>
            </div>
            
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
                <button class="px-6 py-2 border border-error text-error font-label-md rounded-lg hover:bg-error-container transition-colors" onclick="document.getElementById('cancel-confirm-modal').classList.remove('hidden')">Batalkan Pengajuan</button>
                <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('status-modal').classList.add('hidden')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="fixed inset-0 z-[60] flex items-center justify-center hidden" id="cancel-confirm-modal">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('cancel-confirm-modal').classList.add('hidden')"></div>
        <div class="relative bg-pure-white w-full max-w-md mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-outline-variant">
                <h3 class="font-headline-sm text-headline-sm text-deep-black">Batalkan Pengajuan?</h3>
            </div>
            <div class="p-6">
                <p class="font-body-md text-body-md text-on-surface-variant">Apakah Anda yakin ingin membatalkan pengajuan surat ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
                <button class="px-6 py-2 border border-error text-error font-label-md rounded-lg hover:bg-error-container transition-colors" onclick="alert('Pengajuan berhasil dibatalkan'); document.getElementById('cancel-confirm-modal').classList.add('hidden'); document.getElementById('status-modal').classList.add('hidden');">Ya, Batalkan</button>
                <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('cancel-confirm-modal').classList.add('hidden')">Kembali</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openStatusModal(data) {
        // Update Title & Date
        document.getElementById('modal-doc-name').innerText = data.type;
        
        // Populate the timeline dynamically
        const timelineContainer = document.getElementById('timeline-container');
        timelineContainer.innerHTML = ''; // Clear previous items
        
        data.timeline.forEach((step) => {
            let iconBgClass = '';
            let iconText = '';
            let pulseClass = '';
            let textClass = 'text-deep-black';
            
            if (step.status === 'completed') {
                iconBgClass = 'bg-green-100 text-green-700';
                iconText = 'check';
            } else if (step.status === 'active') {
                iconBgClass = 'bg-secondary-container text-secondary';
                iconText = 'sync';
                pulseClass = 'animate-pulse';
            } else {
                iconBgClass = 'bg-surface-container text-on-surface-variant';
                iconText = 'hourglass_empty';
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

        // Update Details
        document.getElementById('modal-purpose').innerText = data.purpose;
        document.getElementById('modal-lecturer').innerText = data.lecturer;

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
                        <span class="material-symbols-outlined text-on-surface-variant ml-auto opacity-0 group-hover:opacity-100 transition-opacity">download</span>
                    </div>
                `;
                attachmentsContainer.insertAdjacentHTML('beforeend', fileHtml);
            });
        } else {
            attachmentsContainer.innerHTML = '<p class="text-body-sm text-on-surface-variant italic">Tidak ada lampiran</p>';
        }

        // Show Modal
        document.getElementById('status-modal').classList.remove('hidden');
    }
</script>
@endpush
