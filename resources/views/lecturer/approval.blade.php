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
                'type' => 'Surat Keterangan Aktif',
                'date' => '12 Okt 2023',
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Budi Pratama Kusuma',
                'nim' => '20.11.3902',
                'type' => 'Surat Keterangan Lulus',
                'date' => '10 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Dewi Anggraini Lestari',
                'nim' => '21.11.4722',
                'type' => 'Surat Keterangan Aktif',
                'date' => '09 Okt 2023',
                'roles' => [['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Rizky Fauzi Rahman',
                'nim' => '21.11.4123',
                'type' => 'Surat Pengantar Magang',
                'date' => '08 Okt 2023',
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Siti Nurhaliza Putri',
                'nim' => '21.11.4256',
                'type' => 'Surat Keterangan Aktif',
                'date' => '08 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'nim' => '21.11.4301',
                'type' => 'Surat Keterangan Aktif',
                'date' => '07 Okt 2023',
                'roles' => [['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Laila Sari',
                'nim' => '21.11.4302',
                'type' => 'Surat Keterangan Aktif',
                'date' => '07 Okt 2023',
                'roles' => [['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Muhammad Rizky',
                'nim' => '21.11.4303',
                'type' => 'Surat Pengantar Magang',
                'date' => '06 Okt 2023',
                'roles' => [['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Putri Indah',
                'nim' => '21.11.4304',
                'type' => 'Surat Keterangan Aktif',
                'date' => '06 Okt 2023',
                'roles' => [['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Dimas Prayoga',
                'nim' => '21.11.4305',
                'type' => 'Surat Keterangan Lulus',
                'date' => '05 Okt 2023',
                'roles' => [['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Siska Amelia',
                'nim' => '21.11.4306',
                'type' => 'Surat Keterangan Aktif',
                'date' => '05 Okt 2023',
                'roles' => [['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'nim' => '21.11.4307',
                'type' => 'Surat Pengantar Magang',
                'date' => '04 Okt 2023',
                'roles' => [['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Nadia Safira',
                'nim' => '21.11.4308',
                'type' => 'Surat Keterangan Aktif',
                'date' => '04 Okt 2023',
                'roles' => [['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Eko Prasetyo',
                'nim' => '21.11.4309',
                'type' => 'Surat Keterangan Lulus',
                'date' => '03 Okt 2023',
                'roles' => [['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green']],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Rina Melati',
                'nim' => '21.11.4310',
                'type' => 'Surat Keterangan Aktif',
                'date' => '03 Okt 2023',
                'roles' => [['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple']],
                'status' => 'PENDING',
            ],
        ];
    }
@endphp

@extends('layouts.dosen')

@section('title', 'Persetujuan Dokumen - Universitas Amikom')

@section('content')
    <div class="space-y-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Permintaan Menunggu Persetujuan</h1>
            <p class="text-gray-600">Kelola dan verifikasi dokumen pengajuan mahasiswa yang membutuhkan tindakan segera.</p>
        </div>

        <!-- BEGIN: Filters -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6" data-purpose="filter-section">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Row 1: Search, Role, Doc Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase"
                        for="searchStudent">Cari Mahasiswa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                        <input
                            class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm transition-colors"
                            id="searchStudent" placeholder="Nama atau NIM" type="text">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase"
                        for="role">Peran</label>
                    <div class="relative">
                        <select
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white"
                            id="role">
                            <option>Semua Peran</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase"
                        for="docType">Jenis Dokumen</label>
                    <div class="relative">
                        <select
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white"
                            id="docType">
                            <option>Surat Keterangan ...</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Row 2: Batch, Sort, Empty Spacer -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase"
                        for="batch">Angkatan</label>
                    <div class="relative">
                        <select
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white"
                            id="batch">
                            <option>Semua Angkatan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase"
                        for="sort">Urutan</label>
                    <div class="relative">
                        <select
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white font-headline-md"
                            id="sort">
                            <option value="oldest">Terlama (Oldest)</option>
                            <option value="newest">Terbaru (Newest)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-500">
                            <span class="material-symbols-outlined text-gray-400">expand_more</span>
                        </div>
                    </div>
                </div>

                <div class="hidden md:block"></div>
            </div>
        </div>
        <!-- END: Filters -->

        <!-- BEGIN: Data Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-[#F8F9FA] sticky top-0 z-10 text-base">
                        <tr>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">Nama
                                Mahasiswa</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-32" scope="col">NIM
                            </th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">
                                Jenis Surat</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-40" scope="col">
                                Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/5" scope="col">
                                Peran</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-24" scope="col">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-body-md">
                        @forelse ($submissions as $sub)
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors group"
                                onclick="window.location='{{ url('/lecturer/approval/detail') }}'">
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
                                            <span
                                                class="inline-flex items-center w-fit px-2.5 py-0.5 rounded-full font-semibold {{ $r['bg'] }} text-white text-xs">{{ $r['name'] }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 whitespace-nowrap py-4">
                                    @if (strtoupper($sub['status']) === 'PENDING')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] text-xs">PENDING</span>
                                    @elseif (strtoupper($sub['status']) === 'VERIFIED')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-green-100 text-green-800 border border-green-200 text-xs">VERIFIED</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-gray-100 text-gray-800 border border-gray-200 text-xs">{{ $sub['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-20 text-center" colspan="6">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div
                                            class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                                            <span class="material-symbols-outlined text-gray-400"
                                                style="font-size: 48px;">task_alt</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900">Tidak Ada Permintaan Menunggu</h3>
                                        <p class="text-gray-500 max-w-md mx-auto">Semua dokumen telah diproses. Anda dapat
                                            memeriksa riwayat untuk melihat dokumen yang sudah selesai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Table Footer/Pagination info -->
            <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 text-gray-600 text-base">
                Menampilkan <span class="font-medium text-gray-900">{{ count($submissions) }}</span> permintaan
                {{ count($submissions) === 0 ? 'pending' : 'yang membutuhkan persetujuan' }}
            </div>
        </div>
        <!-- END: Data Table -->
    </div>
@endsection
