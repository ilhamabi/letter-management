@php
    $user = auth()->user();
    $lecturerName = $user?->name ?? 'User';
    $nidn = $user?->lecturer?->national_lecturer_number ?? $user?->username ?? '-';
    $roles = $roles ?? [];

    $submissions = $submissions ?? [];
@endphp

@extends('layouts.lecturer')

@section('title', 'Riwayat Persetujuan - Universitas Amikom')

@section('content')

<div class="space-y-8 font-body-md">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">Riwayat Persetujuan</h1>
        <p class="text-gray-600">Lihat riwayat permintaan dokumen yang telah diproses dan status akhirnya.</p>
    </div>

    <!-- BEGIN: Filters -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col gap-5 mb-6" data-purpose="filter-section">
        <!-- Filter Header -->
        <div class="flex items-center justify-between border-b border-gray-200/80 pb-3">
            <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
                <x-icon name="filter_list" class="w-5 h-5 text-amikom-purple" />
                <span>Filter Riwayat Persetujuan</span>
            </div>
            <button id="btn-reset-filter" type="button" class="text-xs font-semibold text-amikom-purple hover:text-amikom-purple/80 transition-colors flex items-center gap-1 cursor-pointer">
                <x-icon name="restart_alt" class="w-4 h-4" />
                <span>Reset Filter</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Row 1: Search, Doc Type, Status -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="searchHistory">Cari Mahasiswa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <input class="block w-full pl-10 pr-3.5 h-11 text-sm border border-gray-300 rounded-lg bg-gray-50/50 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple transition-all" id="searchHistory" placeholder="Nama atau NIM..." type="text">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="docType">Jenis Surat</label>
                <div class="relative">
                    <select class="block w-full pl-3.5 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="docType">
                        <option value="all">Semua Jenis Surat</option>
                        <option value="non-reguler">Surat Persetujuan Tugas Akhir Jalur Non-Reguler</option>
                        <option value="magang">Surat Rekomendasi Magang</option>
                        <option value="pendadaran">Surat Rekomendasi Pendaftaran Pendadaran</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="status">Status Pengajuan</label>
                <div class="relative">
                    <select class="block w-full pl-3.5 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="status">
                        <option value="all">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="diteruskan">Diteruskan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <!-- Row 2: Role, Batch, Sort -->
            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="role">Peran</label>
                <div class="relative">
                    <select class="block w-full pl-3.5 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="role">
                        <option value="all">Semua Peran</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="dosen wali">Dosen Wali</option>
                        <option value="dosen pembimbing">Dosen Pembimbing</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="batch">Angkatan</label>
                <div class="relative">
                    <select class="block w-full pl-3.5 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="batch">
                        <option value="all">Semua Angkatan</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                        <x-icon name="expand_more" class="w-4 h-4 text-gray-400" />
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5" for="sort">Urutan</label>
                <div class="relative">
                    <select class="block w-full pl-3.5 pr-10 h-11 text-sm border border-gray-300 rounded-lg appearance-none bg-none bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amikom-purple/20 focus:border-amikom-purple cursor-pointer transition-all" id="sort">
                        <option value="newest" selected>Terbaru (Newest First)</option>
                        <option value="oldest">Terlama (Oldest First)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
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
            <table class="w-full text-left divide-y divide-gray-200">
                <thead class="bg-[#F8F9FA] border-b border-gray-200 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider" scope="col">Nama Mahasiswa</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider" scope="col">NIM</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider" scope="col">Jenis Surat</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider" scope="col">Tanggal Pengajuan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider" scope="col">Peran</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 tracking-wider text-center" scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
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
                        <tr class="hover:bg-surface-container-low cursor-pointer transition-colors group submission-row"
                            data-name="{{ strtolower($sub['name']) }}"
                            data-nim="{{ $sub['nim'] }}"
                            data-type="{{ strtolower($sub['type']) }}"
                            data-batch="{{ $batchYear }}"
                            data-roles="{{ implode(',', $roleNames) }}"
                            data-status="{{ strtolower($sub['status']) }}"
                            data-date="{{ $sub['timestamp'] }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 text-sm">{{ $sub['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-normal text-sm">{{ $sub['nim'] }}</td>
                            <td class="px-6 py-4 text-gray-600 font-normal text-sm">{{ $sub['type'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-normal text-sm">{{ $sub['date'] }}</td>
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
                        <tr>
                            <td class="py-20 text-center" colspan="6">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <x-icon name="history_toggle_off" class="w-16 h-16 text-gray-300" />
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
                                    <x-icon name="search_off" class="w-12 h-12 text-gray-400" />
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
        <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 flex items-center justify-between text-gray-600 text-sm">
            <div>
                Menampilkan <span id="startCount" class="font-medium text-gray-900">@if(count($submissions) > 0) 1 @else 0 @endif</span> - <span id="endCount" class="font-medium text-gray-900">{{ count($submissions) }}</span> dari <span id="totalCount" class="font-medium text-gray-900">{{ count($submissions) }}</span> entri
            </div>
            <div class="flex gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-400 hover:bg-gray-50 disabled:opacity-50" disabled>
                    <x-icon name="chevron_left" class="w-4 h-4" />
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-amikom-purple text-white font-bold text-xs">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 text-xs">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 text-xs">3</button>
                <span class="w-8 h-8 flex items-center justify-center text-gray-400 text-xs">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50">
                    <x-icon name="chevron_right" class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
    <!-- END: Data Table -->
</div>

<!-- Modal Detail Alur Persetujuan -->
<x-modal id="approval-modal" title="Detail Alur Persetujuan" maxWidth="max-w-2xl">
    <x-slot:subtitle>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-gray-100 text-gray-700 border border-gray-200 mt-1" id="modal-status-badge">DITERUSKAN</span>
    </x-slot:subtitle>

    <!-- Student Info Summary -->
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">Mahasiswa</p>
                <p class="text-base font-bold text-gray-900" id="modal-student-name">-</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">NIM</p>
                <p class="text-base text-gray-700" id="modal-student-nim">-</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs font-semibold text-gray-500 tracking-wider font-label-sm">Jenis Dokumen</p>
                <p class="text-base text-gray-700" id="modal-doc-type">-</p>
            </div>
        </div>
    </div>
    <!-- Rejection Reason -->
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg hidden" id="modal-rejection-reason">
        <h4 class="text-sm font-semibold text-red-800 mb-1">Alasan Penolakan</h4>
        <p class="text-sm text-red-700">Dokumen tidak lengkap atau tidak sesuai dengan persyaratan administrasi yang berlaku. Silakan perbaiki dan ajukan kembali.</p>
    </div>
    <!-- Timeline -->
    <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
        <!-- Step 1 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-green text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                <x-icon name="check_circle" class="w-4 h-4" />
            </div>
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 bg-white shadow">
                <div class="flex items-center justify-between space-x-2 mb-1">
                    <div class="font-bold text-slate-900 font-label-lg font-headline-md">Pengajuan Terkirim</div>
                    <time class="font-medium text-xs text-amikom-green">Selesai</time>
                </div>
                <div class="text-slate-500 text-xs">Dokumen telah berhasil diunggah oleh mahasiswa.</div>
            </div>
        </div>
        <!-- Step 2 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group" id="step-2">
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-green text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2" id="step-2-icon">
                <x-icon name="check_circle" class="w-4 h-4" />
            </div>
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 bg-white shadow">
                <div class="flex items-center justify-between space-x-2 mb-1">
                    <div class="font-bold text-slate-900 font-label-lg font-headline-md">Persetujuan Dosen Wali</div>
                    <time class="font-medium text-xs text-amikom-green" id="step-2-time">Selesai</time>
                </div>
                <div class="text-slate-500 text-xs" id="step-2-desc">Telah diverifikasi oleh Dosen Wali.</div>
            </div>
        </div>
        <!-- Step 3 -->
        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group" id="step-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-purple text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 animate-pulse" id="step-3-icon">
                <x-icon name="sync" class="w-4 h-4" />
            </div>
            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 bg-white shadow">
                <div class="flex items-center justify-between space-x-2 mb-1">
                    <div class="font-bold text-slate-900 font-label-lg font-headline-md">Verifikasi Program Studi</div>
                    <time class="font-medium text-xs text-amikom-purple" id="step-3-time">Menunggu</time>
                </div>
                <div class="text-slate-500 text-xs" id="step-3-desc">Sedang dalam tahap verifikasi oleh Program Studi.</div>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <button class="px-6 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors shadow-sm" id="close-modal-footer-btn" onclick="closeModal('approval-modal')">
            Tutup
        </button>
    </x-slot:footer>
</x-modal>

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

            // 1. Search Query (Mahasiswa: Nama atau NIM)
            const matchesQuery = !query || name.includes(query) || nim.includes(query);

            // 2. Angkatan/Batch
            const matchesBatch = batch === 'all' || rowBatch === batch;

            // 3. Jenis Surat
            const matchesDocType = docType === 'all' || type.includes(docType);

            // 4. Peran/Role
            const matchesRole = role === 'all' || rowRoles.includes(role);

            // 5. Status
            const matchesStatus = status === 'all' || rowStatus === status ||
                                  (status === 'diteruskan' && (rowStatus === 'diteruskan' || rowStatus === 'sedang diproses'));

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

    const resetBtn = document.getElementById('btn-reset-filter');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (batchSelect) batchSelect.value = 'all';
            if (docTypeSelect) docTypeSelect.value = 'all';
            if (roleSelect) roleSelect.value = 'all';
            if (statusSelect) statusSelect.value = 'all';
            if (sortSelect) sortSelect.value = 'newest';
            filterAndSort();
        });
    }

    // Initial run
    filterAndSort();

    // Modal Interaction
    const modal = document.getElementById('approval-modal');
    
    function closeModal() {
        modal.classList.add('hidden');
    }

    document.getElementById('close-modal-btn').addEventListener('click', closeModal);
    document.getElementById('close-modal-footer-btn').addEventListener('click', closeModal);
    modal.addEventListener('click', closeModal);

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const name = row.querySelector('td:nth-child(1) span').innerText;
            const nim = row.querySelector('td:nth-child(2)').innerText;
            const doc = row.querySelector('td:nth-child(3)').innerText;
            const statusElement = row.querySelector('td:nth-child(6) span');
            const statusText = statusElement ? statusElement.innerText.trim().toUpperCase() : '';
            
            document.getElementById('modal-student-name').innerText = name;
            document.getElementById('modal-student-nim').innerText = nim;
            document.getElementById('modal-doc-type').innerText = doc;
            
            const badge = document.getElementById('modal-status-badge');
            const rejectionSection = document.getElementById('modal-rejection-reason');
            
            const step2Icon = document.getElementById('step-2-icon');
            const step2Time = document.getElementById('step-2-time');
            const step2Desc = document.getElementById('step-2-desc');

            const step3Icon = document.getElementById('step-3-icon');
            const step3Time = document.getElementById('step-3-time');
            const step3Desc = document.getElementById('step-3-desc');

            const checkIcon = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
            const cancelIcon = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
            const hourglassIcon = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>`;
            const syncIcon = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>`;
            const pendingIcon = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;

            if (statusText === 'DISETUJUI') {
                badge.innerText = 'DISETUJUI';
                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-[#DCFCE7] text-[#166534] border border-[#166534]/10';
                
                rejectionSection.classList.add('hidden');

                // Step 2
                step2Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-green text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step2Icon.innerHTML = checkIcon;
                step2Time.innerText = 'Selesai';
                step2Time.className = 'font-medium text-xs text-amikom-green';
                step2Desc.innerText = 'Telah diverifikasi oleh Dosen Wali.';

                // Step 3
                step3Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-green text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step3Icon.innerHTML = checkIcon;
                step3Time.innerText = 'Selesai';
                step3Time.className = 'font-medium text-xs text-amikom-green';
                step3Desc.innerText = 'Telah disetujui oleh Kepala Program Studi.';

            } else if (statusText === 'DITOLAK') {
                badge.innerText = 'DITOLAK';
                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-[#FEE2E2] text-[#991B1B] border border-[#991B1B]/10';
                
                rejectionSection.classList.remove('hidden');

                // Step 2
                step2Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-red-600 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step2Icon.innerHTML = cancelIcon;
                step2Time.innerText = 'Ditolak';
                step2Time.className = 'font-medium text-xs text-red-600';
                step2Desc.innerText = 'Ditolak oleh Dosen Wali.';

                // Step 3
                step3Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-200 text-gray-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step3Icon.innerHTML = hourglassIcon;
                step3Time.innerText = 'Dibatalkan';
                step3Time.className = 'font-medium text-xs text-gray-400';
                step3Desc.innerText = 'Tahap ini tidak dilanjutkan.';
            } else if (statusText === 'DITERUSKAN' || statusText === 'SEDANG DIPROSES') {
                badge.innerText = 'DITERUSKAN';
                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-[#FFEDD5] text-[#9A3412] border border-[#9A3412]/10';
                
                rejectionSection.classList.add('hidden');

                // Step 2
                step2Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-green text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step2Icon.innerHTML = checkIcon;
                step2Time.innerText = 'Selesai';
                step2Time.className = 'font-medium text-xs text-amikom-green';
                step2Desc.innerText = 'Telah diverifikasi oleh Dosen Wali.';

                // Step 3
                step3Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-purple text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 animate-pulse';
                step3Icon.innerHTML = syncIcon;
                step3Time.innerText = 'Menunggu';
                step3Time.className = 'font-medium text-xs text-amikom-purple';
                step3Desc.innerText = 'Sedang dalam tahap verifikasi oleh Program Studi.';
            } else {
                badge.innerText = statusText;
                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-gray-100 text-gray-800 border border-gray-200';
                rejectionSection.classList.add('hidden');
                
                step2Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-amikom-gold text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step2Icon.innerHTML = pendingIcon;
                step2Time.innerText = 'Menunggu';
                step2Time.className = 'font-medium text-xs text-amikom-gold';
                step2Desc.innerText = 'Menunggu verifikasi dari Dosen Wali terkait.';

                step3Icon.className = 'flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-200 text-gray-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2';
                step3Icon.innerHTML = hourglassIcon;
                step3Time.innerText = 'Belum Dimulai';
                step3Time.className = 'font-medium text-xs text-gray-400';
                step3Desc.innerText = 'Tahap akhir persetujuan oleh Kepala Program Studi.';
            }
            
            openModal('approval-modal');
        });
    });
});
</script>
@endsection
