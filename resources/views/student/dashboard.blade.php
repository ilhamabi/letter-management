@extends('layouts.student')

@section('title', 'Dashboard - Universitas Amikom')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $nim ?? ($user?->student?->student_number ?? $user?->username ?? '-');
    $prodi = $prodi ?? '-';

    $pendingCount = $pendingCount ?? 0;
    $approvedCount = $approvedCount ?? 0;
    $rejectedCount = $rejectedCount ?? 0;

    $latestSubmissions = $latestSubmissions ?? collect();
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
            :value="$pendingCount" 
        />
        <x-stat-card 
            icon="check_circle" 
            iconBg="bg-green-100" 
            iconColor="text-green-700" 
            title="Disetujui" 
            :value="$approvedCount" 
        />
        <x-stat-card 
            icon="cancel" 
            iconBg="bg-error-container" 
            iconColor="text-error" 
            title="Ditolak / Perlu Tindakan" 
            :value="$rejectedCount" 
        />
    </section>
    
    <!-- Recent Requests Table -->
    <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col w-full">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <h3 class="text-lg font-bold text-deep-black">Pengajuan yang Berlangsung</h3>
            <a href="{{ route('student.submissions.history') }}" class="group inline-flex items-center gap-1 text-primary text-sm font-semibold">
                <span class="group-hover:underline">Lihat Riwayat Pengajuan</span>
                <x-icon name="chevron_right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
            </a>
        </div>
        
        @if (count($latestSubmissions) > 0)
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
                        @foreach ($latestSubmissions as $sub)
                            @php
                                $letterType = is_array($sub) ? $sub['type'] : ($sub->letterType?->name ?? 'Surat');
                                $submittedDate = is_array($sub) ? ($sub['date'] ?? '-') : ($sub->created_at?->translatedFormat('d M Y') ?? '-');
                                $statusValue = is_array($sub) ? $sub['status'] : (is_object($sub->status) ? $sub->status->value : (string) $sub->status);
                            @endphp
                            <tr class="hover:bg-surface-container-low/50 transition-colors duration-200 cursor-pointer" onclick="openStatusModal({{ json_encode($sub) }})">
                                <td class="py-4 px-6 font-semibold text-deep-black">{{ $letterType }}</td>
                                <td class="py-4 px-6 text-on-surface-variant">{{ $submittedDate }}</td>
                                <td class="py-4 px-6 text-center">
                                    <x-status-badge :status="$statusValue" size="sm" />
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
                <a class="group inline-flex items-center gap-2 text-primary text-sm font-semibold" href="{{ route('student.submissions.history') }}">
                    <span class="group-hover:underline">Lihat Riwayat Pengajuan</span>
                    <x-icon name="arrow_forward" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                </a>
            </div>
        @endif
    </section>

    <x-student.status-modal id="status-modal" :nim="$nim" :prodi="$prodi" />
@endsection
