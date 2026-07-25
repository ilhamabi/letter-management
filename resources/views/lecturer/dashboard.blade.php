@php
    // Detect if we want to simulate the empty state (via query parameter e.g., ?empty=1)
    $isEmpty = request()->has('empty');

    // Default / Mock data so the dashboard works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
    ];
    
    if ($isEmpty) {
        $stats = $stats ?? [
            'total' => 128,
            'pending' => 0,
            'verified' => 128,
            'percentage_verified' => 100,
        ];
        $submissions = [];
    } else {
        $stats = $stats ?? [
            'total' => 128,
            'pending' => 15,
            'verified' => 113,
            'percentage_verified' => 88,
        ];
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
                'roles' => [
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
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
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Laila Sari',
                'nim' => '21.11.4302',
                'type' => 'Surat Keterangan Aktif',
                'date' => '07 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Muhammad Rizky',
                'nim' => '21.11.4303',
                'type' => 'Surat Pengantar Magang',
                'date' => '06 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Putri Indah',
                'nim' => '21.11.4304',
                'type' => 'Surat Keterangan Aktif',
                'date' => '06 Okt 2023',
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Dimas Prayoga',
                'nim' => '21.11.4305',
                'type' => 'Surat Keterangan Lulus',
                'date' => '05 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Siska Amelia',
                'nim' => '21.11.4306',
                'type' => 'Surat Keterangan Aktif',
                'date' => '05 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'nim' => '21.11.4307',
                'type' => 'Surat Pengantar Magang',
                'date' => '04 Okt 2023',
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Nadia Safira',
                'nim' => '21.11.4308',
                'type' => 'Surat Keterangan Aktif',
                'date' => '04 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN WALI', 'bg' => 'bg-amikom-gold'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Eko Prasetyo',
                'nim' => '21.11.4309',
                'type' => 'Surat Keterangan Lulus',
                'date' => '03 Okt 2023',
                'roles' => [
                    ['name' => 'DOSEN PEMBIMBING', 'bg' => 'bg-amikom-green'],
                ],
                'status' => 'PENDING',
            ],
            [
                'name' => 'Rina Melati',
                'nim' => '21.11.4310',
                'type' => 'Surat Keterangan Aktif',
                'date' => '03 Okt 2023',
                'roles' => [
                    ['name' => 'KAPRODI', 'bg' => 'bg-amikom-purple'],
                ],
                'status' => 'PENDING',
            ],
        ];
    }
@endphp

@extends('layouts.lecturer')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $lecturerName }}</h3>
            <p class="text-gray-600">Berikut adalah ringkasan permintaan persetujuan dokumen mahasiswa saat ini.</p>
        </div>
        <div class="bg-amikom-purple text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">calendar_today</span>
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
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $stats['total'] }}</h4>
                </div>
                <div class="p-3 bg-amikom-purple-light rounded-lg text-amikom-purple">
                    <span class="material-symbols-outlined" data-icon="folder_shared">folder_shared</span>
                </div>
            </div>
        </div>
        
        <!-- Menunggu Persetujuan -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Menunggu Persetujuan</p>
                    <h4 class="text-amikom-purple text-4xl font-bold">{{ $stats['pending'] }}</h4>
                </div>
                <div class="p-3 bg-[#FEF3C7] rounded-lg text-amikom-gold">
                    <span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500 italic">Membutuhkan tindakan segera</p>
        </div>
        
        <!-- Selesai Diverifikasi -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Selesai Diverifikasi</p>
                    <h4 class="text-gray-900 text-4xl font-bold">{{ $stats['verified'] }}</h4>
                </div>
                <div class="p-3 bg-[#D1FAE5] rounded-lg text-amikom-green">
                    <span class="material-symbols-outlined" data-icon="verified">verified</span>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amikom-purple h-full" style="width: {{ $stats['percentage_verified'] }}%"></div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Container (Dynamic State) -->
    <section class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" data-purpose="data-table">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex flex-col">
                <h3 class="text-lg text-gray-900 font-semibold">Daftar Pengajuan Terbaru</h3>
                <p class="text-sm text-gray-600">Ringkasan pengajuan terbaru yang membutuhkan perhatian Anda.</p>
            </div>
            <div class="flex items-center gap-4">
                <a class="flex items-center gap-1 text-amikom-purple hover:underline text-sm font-semibold ml-2" href="{{ url('/lecturer/approval') }}">
                    <span>Lihat Semua Pengajuan</span>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>
            </div>
        </div>
        
        @if (count($submissions) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#F8F9FA] border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">Nama Mahasiswa</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">NIM</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">Jenis Surat</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">Peran</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach (array_slice($submissions, 0, 5) as $submission)
                            <tr class="transition-colors group cursor-pointer hover:bg-gray-50" onclick="window.location='{{ url('/lecturer/approval/detail') }}'">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900">{{ $submission['name'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $submission['nim'] }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $submission['type'] }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $submission['date'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1 items-start">
                                        @foreach ($submission['roles'] as $role)
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white uppercase tracking-wider {{ $role['bg'] }}">{{ $role['name'] }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] text-xs uppercase">
                                        {{ $submission['status'] }}
                                    </span>
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
                    <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1, 'wght' 200, 'GRAD' 0, 'opsz' 48;">task</span>
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
