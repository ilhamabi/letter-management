@extends('layouts.student')

@section('title', 'Dashboard - Universitas Amikom')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $prodi = '-';

    $stats = $stats ?? [
        'pending' => 0,
        'approved' => 0,
        'rejected' => 0,
    ];

    $submissions = $submissions ?? [];
@endphp

@section('content')
    <!-- Welcome Section -->
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-pure-white p-8 rounded-xl border border-outline-variant w-full">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Selamat datang kembali, {{ explode(' ', $studentName)[0] }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Berikut ikhtisar permintaan dokumen akademik Anda.</p>
        </div>
    </section>
    
    <!-- Quick Stats Components -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
        <x-stat-card 
            icon="pending_actions" 
            iconBg="bg-primary-fixed" 
            iconColor="text-primary" 
            title="Menunggu" 
            :value="$stats['pending']" 
        />
        <x-stat-card 
            icon="check_circle" 
            iconBg="bg-green-100" 
            iconColor="text-green-700" 
            title="Disetujui" 
            :value="$stats['approved']" 
        />
        <x-stat-card 
            icon="cancel" 
            iconBg="bg-error-container" 
            iconColor="text-error" 
            title="Ditolak / Perlu Tindakan" 
            :value="$stats['rejected']" 
        />
    </section>
    
    <!-- Recent Requests Table -->
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col w-full">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <h3 class="text-lg font-bold text-deep-black">Pengajuan yang Berlangsung</h3>
            <a href="{{ url('/student/submission-history') }}" class="group inline-flex items-center gap-1 text-primary text-sm font-semibold">
                <span class="group-hover:underline">Lihat Riwayat Pengajuan</span>
                <x-icon name="chevron_right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
            </a>
        </div>
        
        @if (count($submissions) > 0)
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/70 border-b border-outline-variant">
                        <tr>
                            <th class="text-xs font-bold uppercase tracking-wider text-on-surface-variant py-4 px-6">Jenis Surat</th>
                            <th class="text-xs font-bold uppercase tracking-wider text-on-surface-variant py-4 px-6">Tanggal Pengajuan</th>
                            <th class="text-xs font-bold uppercase tracking-wider text-on-surface-variant py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-on-surface divide-y divide-outline-variant">
                        @foreach ($submissions as $sub)
                            <tr class="hover:bg-surface-container-low/50 transition-colors duration-200 cursor-pointer" onclick="openStatusModal({{ json_encode($sub) }})">
                                <td class="py-4 px-6 font-semibold text-deep-black">{{ $sub['type'] }}</td>
                                <td class="py-4 px-6 text-on-surface-variant">{{ $sub['date'] }}</td>
                                <td class="py-4 px-6 text-center">
                                    <x-status-badge :status="$sub['status']" size="sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center text-on-surface-variant mb-4">
                    <x-icon name="description" class="w-9 h-9" />
                </div>
                <h4 class="text-lg font-bold text-deep-black mb-2">Tidak ada pengajuan yang sedang berlangsung</h4>
                <p class="text-sm text-on-surface-variant mb-6">Semua permintaan dokumen Anda telah selesai diproses atau belum ada pengajuan baru.</p>
                <a class="group inline-flex items-center gap-2 text-primary text-sm font-semibold" href="{{ url('/student/submission-history') }}">
                    <span class="group-hover:underline">Lihat Riwayat Pengajuan</span>
                    <x-icon name="arrow_forward" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                </a>
            </div>
        @endif
    </section>

    <!-- Modal Component -->
    <x-modal id="status-modal" title="Status Pengajuan" maxWidth="max-w-lg">
        <x-slot:subtitle>
            <span id="modal-doc-name">Verifikasi Pendaftaran</span>
        </x-slot:subtitle>

        <div class="mb-4">
            <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-700 border border-gray-200 flex items-center justify-center gap-1.5 w-fit" id="modal-status-badge">
                <span class="w-1.5 h-1.5 rounded-full bg-[#92400e] animate-pulse"></span>
                <span id="modal-status-text">SEDANG DIPROSES</span>
            </span>
        </div>

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
            <x-icon name="info" class="w-5 h-5 text-primary shrink-0" />
            <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat menghubungi dosen terkait.</p>
        </div>

        <x-slot:footer>
            <button class="px-8 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('status-modal').classList.add('hidden')">
                Tutup
            </button>
        </x-slot:footer>
    </x-modal>
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
                let iconSvg = '';
                let pulseClass = '';
                let textClass = 'text-deep-black';
                
                if (step.status === 'completed') {
                    iconBgClass = 'bg-green-100 text-green-700';
                    iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                } else if (step.status === 'active') {
                    iconBgClass = 'bg-[#fef3c7] text-[#92400e] border border-[#fcd400]';
                    iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                    pulseClass = 'animate-pulse';
                } else {
                    iconBgClass = 'bg-surface-container text-on-surface-variant';
                    iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                    textClass = 'text-on-surface-variant';
                }
                
                const stepHtml = `
                    <div class="relative font-body-sm">
                        <div class="absolute -left-8 w-6 h-6 rounded-full ${iconBgClass} flex items-center justify-center z-10 ${pulseClass}">
                            ${iconSvg}
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
                        <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"/><path d="M9 13v6"/></svg>
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
