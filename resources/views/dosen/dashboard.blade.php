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

<x-app-layout>
    <x-slot name="title">Dashboard - Universitas Amikom</x-slot>
    <x-slot name="head">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Public+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet">
    </x-slot>
    <x-slot name="fullPage">true</x-slot>

    <div class="flex h-screen overflow-hidden text-sm bg-[#FAFAFA]">

        <!-- BEGIN: Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col justify-between"
            data-purpose="sidebar">
            <!-- Top Section: Logo & Nav -->
            <div>
                <!-- Logo -->
                <div class="px-6 py-8 flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <img alt="Universitas Amikom Logo" class="w-10 h-10 object-contain"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjgUI4zaYlX51lbXCaQCgsysUwapK1PGQCi-WXmC5mHugpUw0m1Hc2HsTQTMeTSUVEj-f1a3Q8hyOCxeXdcBHRieKppabbINKUbu8GvOBrmQDltQRNBaxc43NNCNssv3V109JdKSRGK-Kditdog1qCT5qiIigPZn5NJit1sGMgQL397ZCVG-KWQcJyJ55apPJygmFqyDZtvWKPL_bJSWbI0SgnkQINZFh9cOXAHGnNEPqz2UoD24dbXC3jyQlaR3QB-SSvpo0hoh8">
                        <div>
                            <h1 class="font-headline-lg text-[18px] leading-[1.1] text-primary font-bold"
                                style="color: rgb(65, 0, 99);">
                                UNIVERSITAS<br>AMIKOM
                            </h1>
                            <p
                                class="text-[10px] uppercase tracking-widest text-on-surface-variant font-medium text-gray-500">
                                Student Services</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
                    <a class="flex items-center gap-3 px-3 py-2 bg-amikom-purple text-white rounded-lg transition-colors font-bold relative"
                        href="{{ url('/lecturer') }}">
                        <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center"
                            style="font-variation-settings: 'FILL' 1;">grid_view</span>
                        <span class="font-label-lg text-label-lg">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                        href="{{ url('/lecturer/approval') }}">
                        <span
                            class="material-symbols-outlined w-6 h-6 flex items-center justify-center">description</span>
                        <span class="font-label-lg text-label-lg">Persetujuan Dokumen</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                        href="{{ url('/lecturer/approval-history') }}">
                        <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">history</span>
                        <span class="font-label-lg text-label-lg">Riwayat</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Section: User Profile -->
            <div class="p-6 border-t border-gray-200 bg-white" data-purpose="user-profile">
                <div class="flex flex-col gap-4 px-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                            <img alt="{{ $lecturerName }}" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida/AP1WRLsHUqb9lePpAkuZBB4EY_kmGB_qH99xpJTT5LrXNWLswF7ijJNXzre2g_OE6rOGyPrMqZxU9X6brzK_hTo1sSZgL_0r7i97LY53fQ-csLV1mToJvT5FHGmIAXJcriWvbJth3LN2OrfqhLApjsCSVhJMCaJF0xRZUomarXFAF9qu0t_rFc-kxSshL5zzP1vHQ3iD_DWB0D-AXzSO2Waps6HHTcdLC3u4N0pVJHinjsr7GYjga6rt0kf7U34">
                        </div>
                        <div class="flex-1">
                            <p class="text-body-md font-headline-lg text-gray-900 leading-tight font-bold">
                                {{ $lecturerName }}</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">NIDN: {{ $nidn }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($roles as $role)
                            <span
                                class="text-[10px] font-semibold text-white uppercase tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>
        <!-- END: Sidebar -->

        <!-- BEGIN: Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden bg-[#FAFAFA]" data-purpose="main-content">

            <!-- BEGIN: Header -->
            <header class="h-16 flex items-center justify-between px-8 bg-white border-b border-gray-200 shrink-0"
                data-purpose="top-header">
                <h2 class="text-xl font-semibold text-amikom-purple">Layanan Dokumen</h2>

                <!-- Logout Button -->
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <button
                        class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium"
                        onclick="alert('Logout action placeholder')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        Logout
                    </button>
                @endif
            </header>
            <!-- END: Header -->

            <!-- BEGIN: Page Content -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">

                <!-- Welcome Section -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $lecturerName }}</h3>
                        <p class="text-gray-600">Berikut adalah ringkasan permintaan persetujuan dokumen mahasiswa saat
                            ini.</p>
                    </div>
                    <div class="bg-amikom-purple text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        <span
                            class="text-sm font-medium">{{ Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</span>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Permintaan -->
                    <div
                        class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
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
                    <div
                        class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Menunggu Persetujuan</p>
                                <h4 class="text-amikom-purple text-4xl font-bold">{{ $stats['pending'] }}</h4>
                            </div>
                            <div class="p-3 bg-[#FEF3C7] rounded-lg text-amikom-gold">
                                <span class="material-symbols-outlined"
                                    data-icon="pending_actions">pending_actions</span>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-gray-500 italic">Membutuhkan tindakan segera</p>
                    </div>

                    <!-- Selesai Diverifikasi -->
                    <div
                        class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
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
                            <div class="bg-amikom-purple h-full" style="width: {{ $stats['percentage_verified'] }}%">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Data Table Container (Dynamic State) -->
                <section class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
                    data-purpose="data-table">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex flex-col">
                            <h3 class="text-lg text-gray-900 font-semibold">Daftar Pengajuan Terbaru</h3>
                            <p class="text-sm text-gray-600">Ringkasan pengajuan terbaru yang membutuhkan perhatian
                                Anda.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <a class="flex items-center gap-1 text-amikom-purple hover:underline text-sm font-semibold ml-2"
                                href="{{ url('/lecturer/approval') }}">
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
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                                            Nama Mahasiswa</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                                            NIM</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                                            Jenis Surat</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                                            Tanggal Pengajuan</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                                            Peran</th>
                                        <th
                                            class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 tracking-wider text-center">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach (array_slice($submissions, 0, 5) as $submission)
                                        <tr class="transition-colors group cursor-pointer hover:bg-gray-50"
                                            onclick="window.location='{{ url('/lecturer/approval/detail') }}'">
                                            <td class="px-6 py-4">
                                                <span
                                                    class="font-semibold text-gray-900">{{ $submission['name'] }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $submission['nim'] }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $submission['type'] }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $submission['date'] }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col gap-1 items-start">
                                                    @foreach ($submission['roles'] as $role)
                                                        <span
                                                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold text-white uppercase tracking-wider {{ $role['bg'] }}">{{ $role['name'] }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold bg-[#FEF3C7] text-[#92400E] border border-[#FDE68A] text-xs uppercase">
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
                            <div
                                class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-4 text-gray-400">
                                <span class="material-symbols-outlined text-5xl"
                                    style="font-variation-settings: 'FILL' 1, 'wght' 200, 'GRAD' 0, 'opsz' 48;">task</span>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Tidak ada pengajuan pending</h4>
                            <p class="text-gray-600 text-sm max-w-md">
                                Semua dokumen telah diproses. Anda akan melihat pengajuan baru di sini saat mahasiswa
                                melakukan pengajuan.
                            </p>
                        </div>
                    @endif
                </section>
            </div>
            <!-- END: Page Content -->

        </main>
        <!-- END: Main Content -->

    </div>
</x-app-layout>
