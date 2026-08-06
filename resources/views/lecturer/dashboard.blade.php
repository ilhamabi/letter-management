@php
    $user = auth()->user();
    $lecturerName = $user?->name ?? 'User';
    $nidn = $user?->lecturer?->national_lecturer_number ?? $user?->username ?? '-';
    
    $pendingCount = $pendingCount ?? 0;
    $processedCount = $processedCount ?? 0;
    $totalCount = $totalCount ?? 0;
    $percentageProcessed = $percentageProcessed ?? 0;
    $latestSubmissions = $latestSubmissions ?? collect();
@endphp

@extends('layouts.lecturer')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="space-y-8 font-body-md">
    <!-- Welcome Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">Selamat Datang, {{ $lecturerName }}</h3>
            <p class="text-gray-600">Berikut adalah ringkasan permintaan persetujuan dokumen mahasiswa saat ini.</p>
        </div>
        <div class="bg-amikom-purple text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <x-icon name="calendar_today" class="w-4 h-4" />
            <span class="text-sm font-medium">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</span>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Permintaan -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Total Permintaan</p>
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $totalCount }}</h4>
                </div>
                <div class="p-3 bg-amikom-purple-light rounded-lg text-amikom-purple">
                    <x-icon name="folder_shared" class="w-6 h-6" />
                </div>
            </div>
        </div>
        
        <!-- Menunggu -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Menunggu</p>
                    <h4 class="text-amikom-purple text-4xl font-bold">{{ $pendingCount }}</h4>
                </div>
                <div class="p-3 bg-[#FEF3C7] rounded-lg text-amikom-gold">
                    <x-icon name="pending_actions" class="w-6 h-6" />
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500 italic">Membutuhkan tindakan segera</p>
        </div>
        
        <!-- Selesai Diverifikasi -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Selesai Diverifikasi</p>
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $processedCount }}</h4>
                </div>
                <div class="p-3 bg-[#D1FAE5] rounded-lg text-amikom-green">
                    <x-icon name="verified" class="w-6 h-6" />
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amikom-purple h-full" style="width: {{ round($percentageProcessed) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Container -->
    <section class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex flex-col">
                <h3 class="text-lg text-gray-900 font-semibold">Daftar Pengajuan Terbaru</h3>
                <p class="text-sm text-gray-600">Ringkasan pengajuan terbaru yang membutuhkan perhatian Anda.</p>
            </div>
            <div class="flex items-center gap-4">
                <a class="group inline-flex items-center gap-1 text-amikom-purple text-sm font-semibold ml-2" href="{{ route('lecturer.submissions.index') }}">
                    <span class="group-hover:underline">Lihat Semua Pengajuan</span>
                    <x-icon name="chevron_right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                </a>
            </div>
        </div>
        
        @if (count($latestSubmissions) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#F8F9FA] border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Mahasiswa</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">NIM</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Jenis Surat</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Peran</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @foreach ($latestSubmissions as $submission)
                            @php
                                $studentName = $submission->student?->user?->name ?? 'Mahasiswa';
                                $studentNim = $submission->student?->student_number ?? '-';
                                $letterType = $submission->letterType?->name ?? 'Surat';
                                $submittedDate = $submission->created_at?->translatedFormat('d M Y') ?? $submission->created_at?->format('d M Y');
                                $roleName = $submission->approvalFlowStep?->name ?? 'Dosen';
                                $statusValue = is_object($submission->status) ? $submission->status->value : (string) $submission->status;
                            @endphp
                            <tr class="transition-colors group cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('lecturer.submissions.detail') }}'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-gray-900 text-sm">{{ $studentName }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $studentNim }}</td>
                                <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $letterType }}</td>
                                <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $submittedDate }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1 items-start">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white tracking-wider bg-amikom-purple">{{ $roleName }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <x-status-badge :status="$statusValue" size="sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State UI -->
            <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-4 text-gray-400">
                    <x-icon name="task" class="w-12 h-12 text-gray-400" />
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Tidak ada pengajuan pending</h4>
                <p class="text-gray-600 text-sm max-w-md">
                    Semua dokumen telah diproses. Anda akan melihat pengajuan baru di sini saat mahasiswa melakukan pengajuan.
                </p>
            </div>
        @endif
    </section>
</div>
@endsection
