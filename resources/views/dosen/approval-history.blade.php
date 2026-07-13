@php
    // Detect if we want to simulate the empty state (via query parameter e.g., ?empty=1)
    $isEmpty = request()->has('empty');

    // Default / Mock data so the page works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
    ];

    if ($isEmpty) {
        $submissions = [];
    } else {
        $submissions = $submissions ?? [
            [
                'name' => 'Budi Santoso',
                'nim' => '21.11.4321',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '12 Okt 2023',
                'timestamp' => strtotime('2023-10-12'),
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'DISETUJUI',
            ],
            [
                'name' => 'Siti Aminah',
                'nim' => '21.11.4092',
                'type' => 'Pengajuan Cuti Akademik',
                'date' => '11 Okt 2023',
                'timestamp' => strtotime('2023-10-11'),
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'DITOLAK',
            ],
            [
                'name' => 'Rizky Aditya',
                'nim' => '20.12.3321',
                'type' => 'Surat Keterangan Lulus',
                'date' => '10 Okt 2023',
                'timestamp' => strtotime('2023-10-10'),
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'DISETUJUI',
            ],
            [
                'name' => 'Dian Permatasari',
                'nim' => '22.11.5110',
                'type' => 'Surat Rekomendasi Lomba',
                'date' => '08 Okt 2023',
                'timestamp' => strtotime('2023-10-08'),
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'DISETUJUI',
            ],
        ];
    }
@endphp

@extends('layouts.dosen')

@section('title', 'Riwayat Persetujuan - Universitas Amikom')

@section('content')
<div class="space-y-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Riwayat Persetujuan</h1>
        <p class="text-gray-600">Lihat riwayat permintaan dokumen yang telah diproses dan status akhirnya.</p>
    </div>

    <!-- BEGIN: Filters -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6" data-purpose="filter-section">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Row 1: Search & Batch -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="searchHistory">Cari Dokumen</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <input class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm transition-colors" id="searchHistory" placeholder="Cari nama, NIM, atau jenis surat..." type="text">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="batch">Angkatan</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="batch">
                        <option value="all">Semua Angkatan</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Row 2: Doc Type, Role, Status, Sort -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="docType">Jenis Surat</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="docType">
                        <option value="all">Semua Jenis</option>
                        <option value="rekomendasi">Surat Rekomendasi</option>
                        <option value="keterangan">Surat Keterangan</option>
                        <option value="cuti">Pengajuan Cuti</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="role">Peran</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="role">
                        <option value="all">Semua Peran</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen wali">Dosen Wali</option>
                        <option value="dosen pembimbing">Dosen Pembimbing</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="status">Status</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="status">
                        <option value="all">Semua</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="sort">Urutan</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white font-headline-md" id="sort">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Filters -->

    <!-- BEGIN: Data Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
        <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-[#F8F9FA] sticky top-0 z-10 text-base">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">Nama Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-32" scope="col">NIM</th>
                        <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">Jenis Surat</th>
                        <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-40" scope="col">Tanggal Pengajuan</th>
                        <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/5" scope="col">Peran</th>
                        <th class="px-6 py-4 text-center text-gray-600 tracking-wider uppercase w-24" scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-body-md">
                    @forelse ($submissions as $sub)
                        @php
                            // Extract batch from NIM: e.g. 21.11.4321 -> 2021
                            $nimParts = explode('.', $sub['nim']);
                            $batchYear = count($nimParts) > 0 && is_numeric($nimParts[0]) ? '20' . $nimParts[0] : '';
                            
                            // Gather role names for data attribute
                            $roleNames = array_map(function($r) {
                                return strtolower($r['name']);
                            }, $sub['roles']);
                        @endphp
                        <tr class="hover:bg-gray-50 cursor-pointer transition-colors group submission-row"
                            data-name="{{ strtolower($sub['name']) }}"
                            data-nim="{{ $sub['nim'] }}"
                            data-type="{{ strtolower($sub['type']) }}"
                            data-batch="{{ $batchYear }}"
                            data-roles="{{ implode(',', $roleNames) }}"
                            data-status="{{ strtolower($sub['status']) }}"
                            data-date="{{ $sub['timestamp'] }}">
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-gray-900 font-medium text-base">{{ $sub['name'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 whitespace-nowrap text-gray-600 py-4">{{ $sub['nim'] }}</td>
                            <td class="px-6 text-gray-600 py-4">{{ $sub['type'] }}</td>
                            <td class="px-6 whitespace-nowrap text-gray-600 py-4">{{ $sub['date'] }}</td>
                            <td class="px-6 whitespace-nowrap py-4">
                                <div class="flex flex-col gap-1.5">
                                    @foreach ($sub['roles'] as $r)
                                        <span class="inline-flex items-center w-fit px-2.5 py-0.5 rounded-full font-semibold {{ $r['bg'] }} text-white text-[10px] uppercase">{{ $r['name'] }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 whitespace-nowrap py-4 text-center">
                                @if (strtoupper($sub['status']) === 'DISETUJUI')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full font-bold bg-[#DCFCE7] text-[#166534] border border-[#166534]/10 text-[10px] tracking-wider uppercase">DISETUJUI</span>
                                @elseif (strtoupper($sub['status']) === 'DITOLAK')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full font-bold bg-[#FEE2E2] text-[#991B1B] border border-[#991B1B]/10 text-[10px] tracking-wider uppercase">DITOLAK</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full font-bold bg-gray-100 text-gray-800 border border-gray-200 text-[10px] tracking-wider uppercase">{{ $sub['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-20 text-center" colspan="6">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <span class="material-symbols-outlined text-gray-300 text-6xl" style="font-size: 64px;">history_toggle_off</span>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900">Belum ada riwayat persetujuan</p>
                                        <p class="text-gray-500">Semua dokumen yang telah Anda proses akan muncul di sini.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <!-- JavaScript Search/Filter Empty State Row -->
                    <tr id="noDataRow" style="display: none;">
                        <td class="py-20 text-center" colspan="6">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                                    <span class="material-symbols-outlined text-gray-400" style="font-size: 48px;">search_off</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Tidak Ada Hasil Ditemukan</h3>
                                <p class="text-gray-500 max-w-md mx-auto">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Table Footer/Pagination info -->
        <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 flex items-center justify-between text-gray-600 text-base">
            <div>
                Menampilkan <span id="startCount" class="font-medium text-gray-900">@if(count($submissions) > 0) 1 @else 0 @endif</span> - <span id="endCount" class="font-medium text-gray-900">{{ count($submissions) }}</span> dari <span id="totalCount" class="font-medium text-gray-900">{{ count($submissions) }}</span> entri
            </div>
            <div class="flex gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-400 hover:bg-gray-50 disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-amikom-purple text-white font-bold text-xs">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 text-xs">3</button>
                <span class="w-8 h-8 flex items-center justify-center text-gray-400 text-xs">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
    <!-- END: Data Table -->
</div>

<!-- Client-side Interactive Filter Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchHistory');
    const batchSelect = document.getElementById('batch');
    const docTypeSelect = document.getElementById('docType');
    const roleSelect = document.getElementById('role');
    const statusSelect = document.getElementById('status');
    const sortSelect = document.getElementById('sort');
    const tableBody = document.querySelector('tbody');
    const noDataRow = document.getElementById('noDataRow');
    
    // Counts UI
    const startCount = document.getElementById('startCount');
    const endCount = document.getElementById('endCount');
    const totalCount = document.getElementById('totalCount');

    // Retrieve initial list of rows
    const rows = Array.from(tableBody.querySelectorAll('tr.submission-row'));

    function filterAndSort() {
        const query = searchInput.value.toLowerCase().trim();
        const batch = batchSelect.value.toLowerCase();
        const docType = docTypeSelect.value.toLowerCase();
        const role = roleSelect.value.toLowerCase();
        const status = statusSelect.value.toLowerCase();
        const sort = sortSelect.value;

        let visibleRows = [];

        rows.forEach(row => {
            const name = row.dataset.name;
            const nim = row.dataset.nim;
            const type = row.dataset.type;
            const rowBatch = row.dataset.batch;
            const rowRoles = row.dataset.roles;
            const rowStatus = row.dataset.status;

            // 1. Search Query
            const matchesQuery = !query || name.includes(query) || nim.includes(query) || type.includes(query);

            // 2. Angkatan/Batch
            const matchesBatch = batch === 'all' || rowBatch === batch;

            // 3. Jenis Surat
            const matchesDocType = docType === 'all' || type.includes(docType);

            // 4. Peran/Role
            const matchesRole = role === 'all' || rowRoles.includes(role);

            // 5. Status
            const matchesStatus = status === 'all' || rowStatus === status;

            if (matchesQuery && matchesBatch && matchesDocType && matchesRole && matchesStatus) {
                row.style.display = '';
                visibleRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        // Sort visible rows by date (timestamp)
        visibleRows.sort((a, b) => {
            const dateA = parseInt(a.dataset.date);
            const dateB = parseInt(b.dataset.date);
            return sort === 'newest' ? dateB - dateA : dateA - dateB;
        });

        // Re-append sorted elements back to DOM
        visibleRows.forEach(row => tableBody.appendChild(row));

        // Toggle search empty state if all filter matches are zero, but database isn't fully empty
        if (visibleRows.length === 0 && rows.length > 0) {
            if (noDataRow) noDataRow.style.display = '';
        } else {
            if (noDataRow) noDataRow.style.display = 'none';
        }

        // Update entries display text
        if (startCount && endCount && totalCount) {
            if (visibleRows.length === 0) {
                startCount.textContent = '0';
                endCount.textContent = '0';
            } else {
                startCount.textContent = '1';
                endCount.textContent = visibleRows.length.toString();
            }
            totalCount.textContent = visibleRows.length.toString();
        }
    }

    // Attach event listeners
    if (searchInput) searchInput.addEventListener('input', filterAndSort);
    if (batchSelect) batchSelect.addEventListener('change', filterAndSort);
    if (docTypeSelect) docTypeSelect.addEventListener('change', filterAndSort);
    if (roleSelect) roleSelect.addEventListener('change', filterAndSort);
    if (statusSelect) statusSelect.addEventListener('change', filterAndSort);
    if (sortSelect) sortSelect.addEventListener('change', filterAndSort);

    // Initial run
    filterAndSort();
});
</script>
@endsection
