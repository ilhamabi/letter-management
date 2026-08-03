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
                'name' => 'Aditya Saputra Ramadhan',
                'nim' => '21.11.4589',
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '12 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Budi Pratama Kusuma',
                'nim' => '20.11.3902',
                'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'date' => '10 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Dewi Anggraini Lestari',
                'nim' => '21.11.4722',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '09 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Rizky Fauzi Rahman',
                'nim' => '21.11.4123',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '08 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Siti Nurhaliza Putri',
                'nim' => '21.11.4256',
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '08 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'nim' => '21.11.4301',
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '07 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Laila Sari',
                'nim' => '21.11.4302',
                'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'date' => '07 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Muhammad Rizky',
                'nim' => '21.11.4303',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '06 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Putri Indah',
                'nim' => '21.11.4304',
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '06 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Dimas Prayoga',
                'nim' => '21.11.4305',
                'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'date' => '05 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Siska Amelia',
                'nim' => '21.11.4306',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '05 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'nim' => '21.11.4307',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '04 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Nadia Safira',
                'nim' => '21.11.4308',
                'type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'date' => '04 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Eko Prasetyo',
                'nim' => '21.11.4309',
                'type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'date' => '03 Okt 2023',
                'roles' => [
                    ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'Menunggu',
            ],
            [
                'name' => 'Rina Melati',
                'nim' => '21.11.4310',
                'type' => 'Surat Rekomendasi Magang',
                'date' => '03 Okt 2023',
                'roles' => [
                    ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'Menunggu',
            ],
        ];
    }
@endphp

@extends('layouts.lecturer')

@section('title', 'Persetujuan Dokumen - Universitas Amikom')

@section('content')
<div class="space-y-8 font-body-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">Daftar Permintaan Menunggu Persetujuan</h1>
        <p class="text-gray-600">Kelola dan verifikasi dokumen pengajuan mahasiswa yang membutuhkan tindakan segera.</p>
    </div>

    <!-- BEGIN: Filters -->
    <!-- BEGIN: Filters -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col gap-4 mb-6" data-purpose="filter-section">
        <!-- Filter Header -->
        <div class="flex items-center justify-between border-b border-gray-200/80 pb-3">
            <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-amikom-purple" />
                <span>Filter Pengajuan</span>
            </div>
            <button id="btn-reset-filter" type="button" class="text-xs font-semibold text-amikom-purple hover:text-amikom-purple/80 transition-colors flex items-center gap-1 cursor-pointer">
                <x-icon name="restart_alt" class="w-4 h-4" />
                <span>Reset Filter</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
            <!-- Search Student -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="searchStudent">Cari Mahasiswa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <input class="block w-full pl-9 pr-3 h-11 text-sm border border-gray-300 rounded-lg bg-gray-50/50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple transition-all" id="searchStudent" placeholder="Nama atau NIM..." type="text">
                </div>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="role">Peran</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="role">
                        <option value="all">Semua Peran</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen wali">Dosen Wali</option>
                        <option value="dosen pembimbing">Dosen Pembimbing</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <!-- Doc Type -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="docType">Jenis Dokumen</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="docType">
                        <option value="all">Semua Jenis Dokumen</option>
                        <option value="non-reguler">Surat Persetujuan Tugas Akhir Jalur Non-Reguler</option>
                        <option value="magang">Surat Rekomendasi Magang</option>
                        <option value="pendadaran">Surat Rekomendasi Pendaftaran Pendadaran</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <!-- Batch -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="batch">Angkatan</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="batch">
                        <option value="all">Semua Angkatan</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="sort">Urutan</label>
                <div class="relative">
                    <select class="block w-full pl-3 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="sort">
                        <option value="newest" selected>Terbaru (Newest First)</option>
                        <option value="oldest">Terlama (Oldest First)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Filters -->

    <!-- BEGIN: Data Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
        <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
            <table class="w-full text-left">
                <thead class="bg-[#F8F9FA] border-b border-gray-200 sticky top-0 z-10">
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
                    @forelse ($submissions as $sub)
                        @php
                            // Extract batch from NIM: e.g. 21.11.4589 -> 2021
                            $nimParts = explode('.', $sub['nim']);
                            $batchYear = count($nimParts) > 0 && is_numeric($nimParts[0]) ? '20' . $nimParts[0] : '';
                            
                            // Gather role names for data attribute
                            $roleNames = array_map(function($r) {
                                return strtolower($r['name']);
                            }, $sub['roles']);

                            $timestamp = isset($sub['timestamp']) ? $sub['timestamp'] : strtotime(str_replace(['Okt', 'Des', 'Mei'], ['Oct', 'Dec', 'May'], $sub['date']));
                        @endphp
                        <tr class="transition-colors group cursor-pointer hover:bg-gray-50 submission-row"
                            data-name="{{ strtolower($sub['name']) }}"
                            data-nim="{{ $sub['nim'] }}"
                            data-type="{{ strtolower($sub['type']) }}"
                            data-batch="{{ $batchYear }}"
                            data-roles="{{ implode(',', $roleNames) }}"
                            data-status="{{ strtolower($sub['status']) }}"
                            data-date="{{ $timestamp }}"
                            onclick="window.location='{{ url('/lecturer/approval/detail') }}'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 text-sm">{{ $sub['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $sub['nim'] }}</td>
                            <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $sub['type'] }}</td>
                            <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $sub['date'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 items-start">
                                    @foreach ($sub['roles'] as $r)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white tracking-wider {{ $r['bg'] }}">{{ $r['name'] }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-status-badge :status="$sub['status']" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyPendingRow">
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <x-icon name="task_alt" class="w-12 h-12 text-gray-400" />
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 mb-1">Semua Pengajuan Telah Diproses!</h4>
                                    <p class="text-xs text-gray-500">Tidak ada permohonan persetujuan baru yang memerlukan tindakan Anda saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    
                    <tr id="emptySearchRow" class="hidden">
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <x-icon name="search_off" class="w-12 h-12 text-gray-300" />
                                </div>
                                <h4 class="text-base font-bold text-gray-900 mb-1">Pengajuan Tidak Ditemukan</h4>
                                <p class="text-xs text-gray-500">Tidak ada data permohonan yang sesuai dengan kata kunci atau filter pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Table Footer/Pagination info -->
        <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 text-gray-600 text-base">
            Menampilkan <span class="font-medium text-gray-900" id="displayCount">{{ count($submissions) }}</span> permintaan <span id="displayLabel">{{ count($submissions) === 0 ? 'pending' : 'yang membutuhkan persetujuan' }}</span>
        </div>
    </div>
    <!-- END: Data Table -->
</div>

<script>
(function() {
    function initApprovalFilter() {
        const searchInput = document.getElementById('searchStudent');
        const roleSelect = document.getElementById('role');
        const docTypeSelect = document.getElementById('docType');
        const batchSelect = document.getElementById('batch');
        const sortSelect = document.getElementById('sort');
        const tableBody = document.querySelector('tbody');
        const noResultsRow = document.getElementById('noResultsRow');
        const displayCount = document.getElementById('displayCount');
        const displayLabel = document.getElementById('displayLabel');
        const resetBtn = document.getElementById('btn-reset-filter');

        if (!tableBody) return;

        const rows = Array.from(tableBody.querySelectorAll('tr.submission-row'));

        function filterAndSort() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const role = roleSelect ? roleSelect.value.toLowerCase() : 'all';
            const docType = docTypeSelect ? docTypeSelect.value.toLowerCase() : 'all';
            const batch = batchSelect ? batchSelect.value.toLowerCase() : 'all';
            const sort = sortSelect ? sortSelect.value : 'newest';

            let visibleRows = [];

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const nim = row.dataset.nim || '';
                const type = row.dataset.type || '';
                const rowBatch = row.dataset.batch || '';
                const rowRoles = row.dataset.roles || '';

                // 1. Search Query (Mahasiswa: Nama atau NIM)
                const matchesQuery = !query || name.includes(query) || nim.includes(query);

                // 2. Peran/Role
                const matchesRole = role === 'all' || rowRoles.includes(role);

                // 3. Jenis Surat
                const matchesDocType = docType === 'all' || type.includes(docType);

                // 4. Angkatan/Batch
                const matchesBatch = batch === 'all' || rowBatch === batch;

                if (matchesQuery && matchesRole && matchesDocType && matchesBatch) {
                    row.style.display = '';
                    visibleRows.push(row);
                } else {
                    row.style.display = 'none';
                }
            });

            // Sort visible rows by date
            visibleRows.sort((a, b) => {
                const dateA = parseInt(a.dataset.date) || 0;
                const dateB = parseInt(b.dataset.date) || 0;
                return sort === 'newest' ? dateB - dateA : dateA - dateB;
            });

            // Re-append sorted elements back to DOM
            visibleRows.forEach(row => tableBody.appendChild(row));

            // Empty state handling for zero filter matches
            if (noResultsRow) {
                noResultsRow.style.display = (visibleRows.length === 0 && rows.length > 0) ? '' : 'none';
            }

            // Update footer count
            if (displayCount) displayCount.textContent = visibleRows.length;
            if (displayLabel) displayLabel.textContent = visibleRows.length === 0 ? 'pending' : 'yang membutuhkan persetujuan';
        }

        if (searchInput) searchInput.addEventListener('input', filterAndSort);
        if (roleSelect) roleSelect.addEventListener('change', filterAndSort);
        if (docTypeSelect) docTypeSelect.addEventListener('change', filterAndSort);
        if (batchSelect) batchSelect.addEventListener('change', filterAndSort);
        if (sortSelect) sortSelect.addEventListener('change', filterAndSort);

        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                if (e) e.preventDefault();
                if (searchInput) searchInput.value = '';
                if (roleSelect) roleSelect.value = 'all';
                if (docTypeSelect) docTypeSelect.value = 'all';
                if (batchSelect) batchSelect.value = 'all';
                if (sortSelect) sortSelect.value = 'newest';
                filterAndSort();
            });
        }

        // Initial filter run
        filterAndSort();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initApprovalFilter);
    } else {
        initApprovalFilter();
    }
})();
</script>
@endsection
