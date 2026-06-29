@php
    // Default / Mock data so the page works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
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
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Persetujuan Dokumen - Universitas Amikom' }}</title>

    <!-- Tailwind CSS (Vite / Fallback CDN) -->
    @if (Route::has('login'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @endif

    <!-- Separated Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dosen-dashboard.css') }}">
    
    <!-- Material Symbols & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen overflow-hidden text-sm">

<!-- BEGIN: Sidebar -->
<aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col justify-between" data-purpose="sidebar">
    <!-- Top Section: Logo & Nav -->
    <div>
        <!-- Logo -->
        <div class="px-6 py-8 flex items-center gap-4 mb-6">
            <div class="flex items-center gap-3">
                <img alt="Universitas Amikom Logo" class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjgUI4zaYlX51lbXCaQCgsysUwapK1PGQCi-WXmC5mHugpUw0m1Hc2HsTQTMeTSUVEj-f1a3Q8hyOCxeXdcBHRieKppabbINKUbu8GvOBrmQDltQRNBaxc43NNCNssv3V109JdKSRGK-Kditdog1qCT5qiIigPZn5NJit1sGMgQL397ZCVG-KWQcJyJ55apPJygmFqyDZtvWKPL_bJSWbI0SgnkQINZFh9cOXAHGnNEPqz2UoD24dbXC3jyQlaR3QB-SSvpo0hoh8">
                <div>
                    <h1 class="font-headline-lg text-[18px] leading-[1.1] text-primary font-bold" style="color: rgb(65, 0, 99);">
                        UNIVERSITAS<br>AMIKOM
                    </h1>
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-medium text-gray-500">Student Services</p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
            <a class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" href="{{ url('/dashboard-dosen') }}">
                <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">grid_view</span>
                <span class="font-label-lg text-label-lg">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 bg-amikom-purple text-white rounded-lg transition-colors font-bold relative" href="{{ url('/persetujuan-dokumen') }}">
                <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">description</span>
                <span class="font-label-lg text-label-lg">Persetujuan Dokumen</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" href="#">
                <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">history</span>
                <span class="font-label-lg text-label-lg">Riwayat</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section: User Profile -->
    <div class="p-6 border-t border-gray-200 bg-white" data-purpose="user-profile">
        <div class="flex flex-col gap-4 px-2">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                    <img alt="{{ $lecturerName }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLsHUqb9lePpAkuZBB4EY_kmGB_qH99xpJTT5LrXNWLswF7ijJNXzre2g_OE6rOGyPrMqZxU9X6brzK_hTo1sSZgL_0r7i97LY53fQ-csLV1mToJvT5FHGmIAXJcriWvbJth3LN2OrfqhLApjsCSVhJMCaJF0xRZUomarXFAF9qu0t_rFc-kxSshL5zzP1vHQ3iD_DWB0D-AXzSO2Waps6HHTcdLC3u4N0pVJHinjsr7GYjga6rt0kf7U34">
                </div>
                <div class="flex-1">
                    <p class="text-body-md font-headline-lg text-gray-900 leading-tight font-bold">{{ $lecturerName }}</p>
                    <p class="text-xs text-gray-500 truncate mt-0.5">NIDN: {{ $nidn }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-1.5">
                @foreach ($roles as $role)
                    <span class="text-[10px] font-semibold text-white uppercase tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
                @endforeach
            </div>
        </div>
    </div>
</aside>
<!-- END: Sidebar -->

<!-- BEGIN: Main Content -->
<main class="flex-1 flex flex-col overflow-hidden bg-background" data-purpose="main-content">
    
    <!-- BEGIN: Header -->
    <header class="h-16 flex items-center justify-between px-8 bg-white border-b border-gray-200 shrink-0" data-purpose="top-header">
        <h2 class="text-xl font-semibold text-amikom-purple">Layanan Dokumen</h2>
        
        <!-- Logout Button -->
        @if (Route::has('logout'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    Logout
                </button>
            </form>
        @else
            <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium" onclick="alert('Logout action placeholder')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                Logout
            </button>
        @endif
    </header>
    <!-- END: Header -->

    <!-- BEGIN: Page Content -->
    <div class="flex-1 overflow-y-auto p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Permintaan Menunggu Persetujuan</h1>
            <p class="text-gray-600">Kelola dan verifikasi dokumen pengajuan mahasiswa yang membutuhkan tindakan segera.</p>
        </div>

        <!-- BEGIN: Filters -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6" data-purpose="filter-section">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Row 1: Search, Role, Doc Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="searchStudent">Cari Mahasiswa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                        <input class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm transition-colors" id="searchStudent" placeholder="Nama atau NIM" type="text">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="role">Peran</label>
                    <div class="relative">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="role">
                            <option>Semua Peran</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="docType">Jenis Dokumen</label>
                    <div class="relative">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="docType">
                            <option>Surat Keterangan ...</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Row 2: Batch, Sort, Empty Spacer -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="batch">Angkatan</label>
                    <div class="relative">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white" id="batch">
                            <option>Semua Angkatan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 tracking-wider mb-1.5 uppercase" for="sort">Urutan</label>
                    <div class="relative">
                        <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-amikom-purple focus:border-amikom-purple sm:text-sm rounded-md appearance-none bg-white font-headline-md" id="sort">
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
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">Nama Mahasiswa</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-32" scope="col">NIM</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/4" scope="col">Jenis Surat</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-40" scope="col">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-1/5" scope="col">Peran</th>
                            <th class="px-6 py-4 text-left text-gray-600 tracking-wider uppercase w-24" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-body-md">
                        @foreach ($submissions as $sub)
                            <tr class="hover:bg-gray-50 cursor-pointer transition-colors group">
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
                                            <span class="inline-flex items-center w-fit px-2.5 py-0.5 rounded-full font-semibold {{ $r['bg'] }} text-white text-xs">{{ $r['name'] }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 whitespace-nowrap py-4">
                                    @if (strtoupper($sub['status']) === 'PENDING')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] text-xs">PENDING</span>
                                    @elseif (strtoupper($sub['status']) === 'VERIFIED')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-green-100 text-green-800 border border-green-200 text-xs">VERIFIED</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-gray-100 text-gray-800 border border-gray-200 text-xs">{{ $sub['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Table Footer/Pagination info -->
            <div class="bg-[#F8F9FA] px-6 py-4 border-t border-gray-200 text-gray-600 text-base">
                Menampilkan <span class="font-medium text-gray-900">{{ count($submissions) }}</span> permintaan yang membutuhkan persetujuan
            </div>
        </div>
        <!-- END: Data Table -->
    </div>
    <!-- END: Page Content -->
</main>
<!-- END: Main Content -->

</body>
</html>
