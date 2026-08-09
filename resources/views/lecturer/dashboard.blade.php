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

@section('title', 'Dashboard Dosen - Universitas Amikom')

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
        <!-- Total Permintaan Terkait -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Total Permintaan Terkait</p>
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $totalCount }}</h4>
                </div>
                <div class="p-3 bg-amikom-purple-light rounded-lg text-amikom-purple">
                    <x-icon name="folder_shared" class="w-6 h-6" />
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500 italic">Keseluruhan pengajuan terkait peran Anda</p>
        </div>
        
        <!-- Menunggu Persetujuan Saya -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Menunggu Persetujuan Saya</p>
                    <h4 class="text-amikom-purple text-4xl font-bold">{{ $pendingCount }}</h4>
                </div>
                <div class="p-3 bg-[#FEF3C7] rounded-lg text-amikom-gold">
                    <x-icon name="pending_actions" class="w-6 h-6" />
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500 italic">Membutuhkan tindakan persetujuan Anda</p>
        </div>
        
        <!-- Sudah Saya Proses -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Sudah Saya Proses</p>
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $processedCount }}</h4>
                </div>
                <div class="p-3 bg-[#D1FAE5] rounded-lg text-amikom-green">
                    <x-icon name="task_alt" class="w-6 h-6" />
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
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider">Peran Saya</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @foreach ($latestSubmissions as $sub)
                            @php
                                $studentName = $sub->student?->user?->name ?? 'Mahasiswa';
                                $studentNim = $sub->student?->student_number ?? '-';
                                $letterType = $sub->letterType?->name ?? 'Surat';
                                $submittedDate = $sub->created_at?->translatedFormat('d M Y') ?? $sub->created_at?->format('d M Y');
                                $roleName = $sub->approvalFlowStep?->approval_role?->label() ?? $sub->approvalFlowStep?->name ?? 'Dosen Verifikator';
                                $statusValue = is_object($sub->status) ? $sub->status->value : (string) $sub->status;
                                $myRoles = app(\App\Services\LecturerSubmissionService::class)->getLecturerRolesForSubmission($sub, auth()->user());
                            @endphp
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors group" onclick="window.location='{{ route('lecturer.submissions.show', $sub->id) }}'">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                    <x-icon name="task" class="w-12 h-12 text-gray-300" />
                    <div>
                        <p class="text-base font-bold text-gray-900">Tidak Ada Pengajuan Menunggu Persetujuan</p>
                        <p class="text-xs text-gray-500 mt-0.5">Semua dokumen telah diverifikasi atau belum ada pengajuan baru.</p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
