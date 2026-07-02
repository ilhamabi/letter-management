@php
    // Detect if we want to simulate the empty state (via query parameter e.g., ?empty=1)
    $isEmpty = request()->has('empty');

    // Default / Mock data so the dashboard works out of the box even without controller variables
    $studentName = $studentName ?? 'Alex Chandra';
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';

    if ($isEmpty) {
        $stats = $stats ?? [
            'pending' => 0,
            'approved' => 12,
            'rejected' => 1,
        ];
        $submissions = [];
    } else {
        $stats = $stats ?? [
            'pending' => 3,
            'approved' => 12,
            'rejected' => 1,
        ];

        $submissions = $submissions ?? [
            [
                'id' => 1,
                'type' => 'Surat Keterangan Aktif',
                'date' => '24 Okt 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Syarat Beasiswa',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '09:45 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                    ['name' => 'Transkrip_Nilai.pdf', 'size' => '850 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '24 Okt 2023, 09:45 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 2,
                'type' => 'Verifikasi Pendaftaran',
                'date' => '02 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Lomba Kompetisi Nasional',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '10:15 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '02 Nov 2023, 10:15 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 3,
                'type' => 'Legalisir Ijazah',
                'date' => '15 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Persyaratan Melamar Pekerjaan',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '08:30 WIB',
                'attachments' => [
                    ['name' => 'Ijazah_Alex.pdf', 'size' => '2.1 MB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '15 Nov 2023, 08:30 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 4,
                'type' => 'Transkrip Akademik Sementara',
                'date' => '20 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Magang MBKM Merdeka Belajar',
                'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
                'time' => '11:00 WIB',
                'attachments' => [
                    ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                    ['name' => 'KRS_Terakhir.pdf', 'size' => '720 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '20 Nov 2023, 11:00 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
            [
                'id' => 5,
                'type' => 'Surat Bebas Pustaka',
                'date' => '25 Nov 2023',
                'status' => 'Sedang Diproses',
                'purpose' => 'Syarat Kelulusan Wisuda',
                'lecturer' => 'Perpustakaan Amikom',
                'time' => '14:20 WIB',
                'attachments' => [
                    ['name' => 'Bebas_Pinjam_Perpus.pdf', 'size' => '510 KB'],
                ],
                'timeline' => [
                    ['title' => 'Pengajuan Terkirim', 'time' => '25 Nov 2023, 14:20 WIB', 'status' => 'completed'],
                    ['title' => 'Persetujuan Dosen Wali', 'time' => 'SEDANG DIPROSES oleh Heri Setyawan, M.Kom.', 'status' => 'active'],
                    ['title' => 'Verifikasi Program Studi', 'time' => 'Akan datang', 'status' => 'upcoming']
                ]
            ],
        ];
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Universitas Amikom</title>
    
    <!-- Tailwind CSS (Vite / Fallback CDN) -->
    @if (Route::has('login'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet">
    
    <!-- Separated Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/mahasiswa-dashboard.css') }}">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "error-container": "#ffdad6",
                        "secondary-fixed-dim": "#e9c400",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#1b1c1c",
                        "secondary-container": "#fcd400",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed": "#221b00",
                        "surface": "#fbf9f9",
                        "surface-bright": "#fbf9f9",
                        "on-secondary": "#ffffff",
                        "primary-container": "#59207b",
                        "inverse-surface": "#303031",
                        "outline": "#7e7481",
                        "tertiary": "#332500",
                        "surface-container-low": "#f5f3f3",
                        "on-secondary-fixed-variant": "#544600",
                        "on-tertiary-container": "#c0a461",
                        "on-tertiary-fixed-variant": "#584409",
                        "surface-gray": "#F7F7F7",
                        "background": "#fbf9f9",
                        "on-error": "#ffffff",
                        "on-primary-container": "#cc8ff0",
                        "tertiary-fixed": "#ffdf96",
                        "surface-container": "#efeded",
                        "surface-dim": "#dbdad9",
                        "tertiary-fixed-dim": "#e1c37d",
                        "secondary": "#705d00",
                        "surface-tint": "#7e45a0",
                        "surface-container-highest": "#e3e2e2",
                        "deep-black": "#1A1A1A",
                        "on-background": "#1b1c1c",
                        "inverse-on-surface": "#f2f0f0",
                        "on-primary-fixed": "#30004b",
                        "tertiary-container": "#4d3a00",
                        "on-secondary-container": "#6e5c00",
                        "on-surface-variant": "#4d4450",
                        "on-primary-fixed-variant": "#642c86",
                        "primary": "#410063",
                        "outline-variant": "#cfc2d1",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#ffe16d",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#e5b4ff",
                        "pure-white": "#FFFFFF",
                        "on-tertiary-fixed": "#251a00",
                        "primary-fixed-dim": "#e5b4ff",
                        "surface-container-high": "#e9e8e7",
                        "primary-fixed": "#f5d9ff",
                        "surface-variant": "#e3e2e2"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "container-max": "1280px",
                        "margin-desktop": "48px",
                        "margin-mobile": "16px",
                        "base": "8px",
                        "sidebar-width": "280px",
                        "unit": "8px",
                        "stack-lg": "32px",
                        "stack-sm": "8px",
                        "container-padding": "32px",
                        "stack-md": "16px"
                    },
                    "fontFamily": {
                        "body-md": ["Public Sans"],
                        "headline-lg-mobile": ["Montserrat"],
                        "body-sm": ["Public Sans"],
                        "title-lg": ["Montserrat"],
                        "headline-md": ["Montserrat"],
                        "headline-lg": ["Montserrat"],
                        "label-lg": ["Public Sans"],
                        "body-lg": ["Public Sans"],
                        "label-sm": ["Public Sans"],
                        "display-lg": ["Montserrat"],
                        "headline-sm": ["Montserrat"],
                        "label-md": ["Public Sans"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "title-lg": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }]
                    }
                },
            }
        }
    </script>
</head>
<body class="bg-surface-gray text-on-surface min-h-screen flex">
<!-- SideNavBar -->
<nav class="hidden md:flex flex-col h-screen w-sidebar-width fixed left-0 top-0 bg-pure-white border-r border-outline-variant z-20 w-[280px] pt-8">
    <div class="px-container-padding mb-12 flex items-center gap-4">
        <img alt="Universitas Amikom Logo" class="w-12 h-12 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs">
        <div>
            <h1 class="font-display-lg text-title-lg text-primary leading-[1.2] font-bold uppercase tracking-tight">Universitas<br>Amikom</h1>
            <p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">Student Services</p>
        </div>
    </div>
    
    <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
        <a class="flex items-center gap-3 px-3 py-2 bg-primary text-white rounded-lg transition-colors font-bold relative" href="{{ url('/dashboard-mahasiswa') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">grid_view</span>
            <span class="font-label-lg text-label-lg">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/pengajuan') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">add_circle</span>
            <span class="font-label-lg text-label-lg">Buat Baru</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="#">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">history</span>
            <span class="font-label-lg text-label-lg">Riwayat Pengajuan</span>
        </a>
    </nav>
    
    <div class="border-t border-outline-variant bg-surface-container-low/30">
        <div class="flex items-center gap-4 px-6 py-4">
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center shrink-0">
                <img alt="{{ $studentName }}" class="w-12 h-12 rounded-full object-cover shrink-0" src="{{ $profilePhoto }}">
            </div>
            <div class="overflow-hidden">
                <p class="font-label-md text-body-md text-on-surface truncate font-semibold">{{ $studentName }}</p>
                <p class="font-label-sm text-xs text-on-surface-variant">NIM: {{ $nim }}</p>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content Wrapper -->
<div class="flex-grow md:ml-sidebar-width flex flex-col min-h-screen md:ml-[280px] pt-0">
    <!-- Top AppBar -->
    <header class="h-16 bg-pure-white border-b border-outline-variant flex justify-between items-center px-container-padding sticky top-0 z-10 w-full">
        <h2 class="font-headline-sm text-headline-sm text-primary hidden md:block w-auto whitespace-nowrap">Layanan Dokumen</h2>
        <div class="flex items-center gap-gutter w-full justify-end">
            <div class="flex items-center gap-4 text-on-surface-variant">
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            <span class="">Keluar</span>
                        </button>
                    </form>
                @else
                    <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors" onclick="alert('Keluar')">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        <span class="">Keluar</span>
                    </button>
                @endif
            </div>
        </div>
    </header>
    
    <!-- Main Canvas -->
    <main class="flex-grow p-container-padding flex flex-col gap-8 max-w-6xl">
        <!-- Welcome Section -->
        <section class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-pure-white p-8 rounded-xl border border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Selamat datang kembali, {{ $studentName }}</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Berikut ikhtisar permintaan dokumen akademik Anda.</p>
            </div>
        </section>
        
        <!-- Quick Stats -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending -->
            <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-3 bg-primary-fixed rounded-lg text-primary">
                    <span class="material-symbols-outlined text-[28px]" data-icon="pending_actions">pending_actions</span>
                </div>
                <div>
                    <p class="font-label-md text-label-md text-on-surface-variant mb-1">Menunggu</p>
                    <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['pending'] }}</p>
                </div>
            </div>
            
            <!-- Approved -->
            <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-3 rounded-lg bg-green-100 text-green-700">
                    <span class="material-symbols-outlined text-[28px]" data-icon="check_circle">check_circle</span>
                </div>
                <div>
                    <p class="font-label-md text-label-md text-on-surface-variant mb-1">Disetujui</p>
                    <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['approved'] }}</p>
                </div>
            </div>
            
            <!-- Rejected -->
            <div class="bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="p-3 bg-error-container rounded-lg text-error">
                    <span class="material-symbols-outlined text-[28px]" data-icon="cancel">cancel</span>
                </div>
                <div>
                    <p class="font-label-md text-label-md text-on-surface-variant mb-1">Ditolak / Perlu Tindakan</p>
                    <p class="font-display-lg text-display-lg text-deep-black">{{ $stats['rejected'] }}</p>
                </div>
            </div>
        </section>
        
        <!-- Recent Requests Table -->
        <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-sm text-headline-sm text-deep-black">Pengajuan yang Berlangsung</h3>
                <button class="text-primary font-label-md text-label-md hover:underline">
                    <span class="flex items-center gap-1">Lihat Riwayat Pengajuan
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </span>
                </button>
            </div>
            
            @if (count($submissions) > 0)
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-low">
                            <tr>
                                <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium">Jenis Surat</th>
                                <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium">Tanggal Pengajuan</th>
                                <th class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant py-4 px-6 font-medium text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant">
                            @foreach ($submissions as $sub)
                                <tr class="hover:bg-surface-container-low transition-colors duration-200 cursor-pointer" onclick="openStatusModal({{ json_encode($sub) }})">
                                    <td class="py-5 px-6 font-semibold text-deep-black">{{ $sub['type'] }}</td>
                                    <td class="py-5 px-6 text-on-surface-variant">{{ $sub['date'] }}</td>
                                    <td class="py-5 px-6 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-surface-container text-on-surface-variant border border-outline-variant">
                                            {{ $sub['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                    <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center text-on-surface-variant mb-4">
                        <span class="material-symbols-outlined text-4xl">description</span>
                    </div>
                    <h4 class="font-headline-sm text-headline-sm text-deep-black mb-2">Tidak ada pengajuan yang sedang berlangsung</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Semua permintaan dokumen Anda telah selesai diproses atau belum ada pengajuan baru.</p>
                    <a class="text-primary font-label-lg text-label-lg hover:underline flex items-center gap-2" href="#">
                        Lihat Riwayat Pengajuan
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            @endif
        </section>
    </main>
</div>

<!-- Modal Overlay -->
<div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="status-modal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('status-modal').classList.add('hidden')"></div>
    <div class="relative bg-pure-white w-full max-w-lg mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <div class="flex flex-col">
                <h3 class="font-headline-sm text-headline-sm text-deep-black">Status Pengajuan</h3>
                <p class="text-body-sm text-on-surface-variant" id="modal-doc-name">Legalisir Ijazah</p>
            </div>
            <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="document.getElementById('status-modal').classList.add('hidden')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 space-y-6 overflow-y-auto max-h-[60vh]">
            <!-- Content (Top): Status Timeline -->
            <div class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant" id="timeline-container">
                <!-- Timeline items will be populated dynamically -->
            </div>
            
            <!-- Divider -->
            <hr class="border-outline-variant">
            
            <!-- Content (Bottom): Submission Details -->
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-purpose">Syarat Beasiswa</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Dosen Dituju</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-lecturer">Dr. Heri Setyawan, M.Kom. (Dosen Wali)</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-nim">{{ $nim }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-prodi">{{ $prodi }}</p>
                </div>
                
                <div class="col-span-2 space-y-2 mt-2">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Lampiran</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="attachments-container">
                        <!-- Attachments will be populated dynamically -->
                    </div>
                </div>
            </div>
            
            <!-- SLA Info Box -->
            <div class="bg-primary-fixed/30 p-4 rounded-lg border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary">info</span>
                <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat mengirim pengingat.</p>
            </div>
        </div>
        
        <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
            <button class="px-6 py-2 border border-error text-error font-label-md rounded-lg hover:bg-error-container transition-colors" onclick="document.getElementById('cancel-confirm-modal').classList.remove('hidden')">Batalkan Pengajuan</button>
            <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('status-modal').classList.add('hidden')">Tutup</button>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="fixed inset-0 z-[60] flex items-center justify-center hidden" id="cancel-confirm-modal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('cancel-confirm-modal').classList.add('hidden')"></div>
    <div class="relative bg-pure-white w-full max-w-md mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-outline-variant">
            <h3 class="font-headline-sm text-headline-sm text-deep-black">Batalkan Pengajuan?</h3>
        </div>
        <div class="p-6">
            <p class="font-body-md text-body-md text-on-surface-variant">Apakah Anda yakin ingin membatalkan pengajuan surat ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
            <button class="px-6 py-2 border border-error text-error font-label-md rounded-lg hover:bg-error-container transition-colors" onclick="alert('Pengajuan berhasil dibatalkan'); document.getElementById('cancel-confirm-modal').classList.add('hidden'); document.getElementById('status-modal').classList.add('hidden');">Ya, Batalkan</button>
            <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="document.getElementById('cancel-confirm-modal').classList.add('hidden')">Kembali</button>
        </div>
    </div>
</div>

<script>
    function openStatusModal(data) {
        // Update Title & Date
        document.getElementById('modal-doc-name').innerText = data.type;
        
        // Populate the timeline dynamically
        const timelineContainer = document.getElementById('timeline-container');
        timelineContainer.innerHTML = ''; // Clear previous items
        
        data.timeline.forEach((step) => {
            let iconBgClass = '';
            let iconText = '';
            let pulseClass = '';
            let textClass = 'text-deep-black';
            
            if (step.status === 'completed') {
                iconBgClass = 'bg-green-100 text-green-700';
                iconText = 'check';
            } else if (step.status === 'active') {
                iconBgClass = 'bg-secondary-container text-secondary';
                iconText = 'sync';
                pulseClass = 'animate-pulse';
            } else {
                iconBgClass = 'bg-surface-container text-on-surface-variant';
                iconText = 'hourglass_empty';
                textClass = 'text-on-surface-variant';
            }
            
            const stepHtml = `
                <div class="relative">
                    <div class="absolute -left-8 w-6 h-6 rounded-full ${iconBgClass} flex items-center justify-center z-10 ${pulseClass}">
                        <span class="material-symbols-outlined text-sm">${iconText}</span>
                    </div>
                    <div>
                        <p class="font-label-lg text-label-lg ${textClass}">${step.title}</p>
                        <p class="text-body-sm text-on-surface-variant">${step.time}</p>
                    </div>
                </div>
            `;
            timelineContainer.insertAdjacentHTML('beforeend', stepHtml);
        });

        // Update Details
        document.getElementById('modal-purpose').innerText = data.purpose;
        document.getElementById('modal-lecturer').innerText = data.lecturer;

        // Update Attachments
        const attachmentsContainer = document.getElementById('attachments-container');
        attachmentsContainer.innerHTML = '';
        if (data.attachments && data.attachments.length > 0) {
            data.attachments.forEach(file => {
                const fileHtml = `
                    <div class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group">
                        <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div class="overflow-hidden font-body-sm">
                            <p class="text-label-sm text-deep-black truncate font-semibold">${file.name}</p>
                            <p class="text-[10px] text-on-surface-variant">${file.size}</p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant ml-auto opacity-0 group-hover:opacity-100 transition-opacity">download</span>
                    </div>
                `;
                attachmentsContainer.insertAdjacentHTML('beforeend', fileHtml);
            });
        } else {
            attachmentsContainer.innerHTML = '<p class="text-body-sm text-on-surface-variant italic">Tidak ada lampiran</p>';
        }

        // Show Modal
        document.getElementById('status-modal').classList.remove('hidden');
    }
</script>
</body>
</html>
