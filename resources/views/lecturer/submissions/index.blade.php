@extends('layouts.lecturer')

@section('title', 'Persetujuan Dokumen - Universitas Amikom')

@section('content')
<div class="space-y-8 font-body-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">Daftar Permintaan Menunggu Persetujuan</h1>
        <p class="text-gray-600">Kelola dan verifikasi dokumen pengajuan mahasiswa yang membutuhkan tindakan segera.</p>
    </div>

    <!-- BEGIN: Combined Filters (Server-Side GET) -->
    <form action="{{ route('lecturer.submissions.index') }}" method="GET" id="filter-form" class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col gap-3 mb-4">
        <div class="flex items-center justify-between border-b border-gray-200/80 pb-3">
            <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-amikom-purple" />
                <span>Filter Pengajuan</span>
            </div>
            @if(request()->hasAny(['search', 'role', 'letter_type_id', 'batch', 'sort']))
                <a href="{{ route('lecturer.submissions.index') }}" class="text-xs font-semibold text-amikom-purple hover:text-amikom-purple/80 transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4" />
                    <span>Reset Filter</span>
                </a>
            @else
                <button type="button" onclick="document.getElementById('filter-form').reset(); window.location='{{ route('lecturer.submissions.index') }}';" class="text-xs font-semibold text-gray-500 hover:text-amikom-purple transition-colors flex items-center gap-1 cursor-pointer">
                    <x-icon name="restart_alt" class="w-4 h-4" />
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
            <!-- Search Student (Nama / NIM) -->
            <div class="lg:col-span-3 flex flex-col gap-1">
                <label class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider" for="searchStudent">Cari Mahasiswa (Nama / NIM)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <x-icon name="search" class="w-4 h-4 text-gray-400" />
                    </div>
                    <input name="search" value="{{ request('search') }}" onchange="document.getElementById('filter-form').submit()" class="block w-full pl-10 pr-3.5 h-11 text-sm border border-gray-300 rounded-xl bg-gray-50/50 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple transition-all" id="searchStudent" placeholder="Nama atau NIM..." type="text">
                </div>
            </div>

            <!-- Peran (Dosen Login Only) -->
            <div class="lg:col-span-2 flex flex-col gap-1">
                <label for="filter-role" class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Peran Saya</label>
                <x-select-input 
                    id="filter-role" 
                    name="role" 
                    placeholder="Semua Peran"
                    :options="$roleOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- Jenis Surat (Database) -->
            <div class="lg:col-span-3 flex flex-col gap-1">
                <label for="filter-type" class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Jenis Surat</label>
                <x-select-input 
                    id="filter-type" 
                    name="letter_type_id" 
                    placeholder="Semua Jenis Surat"
                    :options="$letterTypeOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- Angkatan (Database Students Only) -->
            <div class="lg:col-span-2 flex flex-col gap-1">
                <label for="filter-batch" class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Angkatan</label>
                <x-select-input 
                    id="filter-batch" 
                    name="batch" 
                    placeholder="Semua Angkatan"
                    :options="$batchOptions ?? []" 
                    onchange="document.getElementById('filter-form').submit()" 
                />
            </div>

            <!-- Urutan -->
            <div class="lg:col-span-2 flex flex-col gap-1">
                <label for="filter-sort" class="block text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Urutan</label>
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
        <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-22rem)]">
            <table class="w-full text-left table-fixed divide-y divide-gray-200">
                <thead class="bg-[#F8F9FA] border-b border-gray-200 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[28%]">Nama Mahasiswa</th>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[10%]">NIM</th>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[20%]">Jenis Surat</th>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[14%]">Tanggal Pengajuan</th>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[18%]">Peran Saya</th>
                        <th class="px-4 py-3 text-xs font-bold uppercase text-gray-500 tracking-wider w-[10%] text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse ($submissions as $sub)
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
                            <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900">{{ $studentName }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $studentNim }}</td>
                            <td class="px-4 py-3 text-gray-600 break-words">{{ $letterType }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $submittedDate }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($myRoles as $roleItem)
                                        <x-role-badge :role="$roleItem" size="sm" />
                                    @empty
                                        <x-role-badge :role="$sub->approvalFlowStep?->approval_role ?? $roleName" size="sm" />
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <x-status-badge :status="$statusValue" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-16 text-center" colspan="6">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <x-icon name="task" class="w-12 h-12 text-gray-300" />
                                    <div>
                                        <p class="text-base font-bold text-gray-900">Tidak Ada Pengajuan Menunggu</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Semua dokumen telah diverifikasi atau tidak ada data yang cocok dengan filter Anda.</p>
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
@endsection
