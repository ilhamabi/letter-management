@php
    // Default / Mock data so the page works out of the box even without controller variables
    $studentName = $studentName ?? 'Alex Chandra';
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';

    $submissions = $submissions ?? [
        [
            'id' => 1,
            'type' => 'Surat Keterangan Aktif Kuliah',
            'date' => '14 Okt 2023, 09:12',
            'status' => 'Disetujui',
            'purpose' => 'Syarat Beasiswa',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB'],
                ['name' => 'Transkrip_Nilai.pdf', 'size' => '850 KB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '14 Okt 2023, 09:12 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed']
            ]
        ],
        [
            'id' => 2,
            'type' => 'Permohonan Cuti Akademik',
            'date' => '12 Okt 2023, 14:30',
            'status' => 'Disetujui',
            'purpose' => 'Fokus Kerja',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'Surat_Pernyataan_Orang_Tua.pdf', 'size' => '1.5 MB'],
                ['name' => 'Formulir_Cuti.pdf', 'size' => '950 KB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '12 Okt 2023, 14:30 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed']
            ]
        ],
        [
            'id' => 3,
            'type' => 'Transkrip Nilai Sementara',
            'date' => '10 Okt 2023, 11:05',
            'status' => 'Disetujui',
            'purpose' => 'Melamar Magang',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'KTM_Alex.pdf', 'size' => '1.2 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '10 Okt 2023, 11:05 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed']
            ]
        ],
        [
            'id' => 4,
            'type' => 'Surat Izin Penelitian',
            'date' => '08 Okt 2023, 16:45',
            'status' => 'Ditolak',
            'purpose' => 'Tugas Akhir / Skripsi',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'Proposal_Penelitian.pdf', 'size' => '2.4 MB'],
                ['name' => 'Surat_Pengantar_Instansi.pdf', 'size' => '1.1 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '08 Okt 2023, 16:45 WIB', 'status' => 'completed'],
                ['title' => 'Penolakan Dosen Wali', 'time' => 'Ditolak oleh Heri Setyawan, M.Kom. (Alasan: Proposal belum disetujui)', 'status' => 'rejected'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Proses dihentikan', 'status' => 'cancelled']
            ]
        ],
        [
            'id' => 5,
            'type' => 'Surat Pengantar Magang',
            'date' => '05 Okt 2023, 08:20',
            'status' => 'Disetujui',
            'purpose' => 'Persyaratan Magang BUMN',
            'lecturer' => 'Dr. Heri Setyawan, M.Kom. (Dosen Wali)',
            'attachments' => [
                ['name' => 'Proposal_Magang.pdf', 'size' => '1.8 MB']
            ],
            'timeline' => [
                ['title' => 'Pengajuan Terkirim', 'time' => '05 Okt 2023, 08:20 WIB', 'status' => 'completed'],
                ['title' => 'Persetujuan Dosen Wali', 'time' => 'Diverifikasi oleh Heri Setyawan, M.Kom.', 'status' => 'completed'],
                ['title' => 'Verifikasi Program Studi', 'time' => 'Selesai diproses', 'status' => 'completed']
            ]
        ]
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pengajuan - Universitas Amikom</title>
    
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
            },
        }
    </script>
</head>
<body class="bg-surface-gray text-on-surface min-h-screen flex">

<!-- SideNavBar -->
<aside class="hidden md:flex flex-col h-screen w-sidebar-width fixed left-0 top-0 bg-pure-white border-r border-outline-variant z-20 w-[280px] pt-8">
    <div class="px-container-padding mb-12 flex items-center gap-4">
        <img alt="Universitas Amikom Logo" class="w-12 h-12 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs">
        <div>
            <h1 class="font-display-lg text-title-lg text-primary leading-[1.2] font-bold uppercase tracking-tight">Universitas<br>Amikom</h1>
            <p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">Student Services</p>
        </div>
    </div>
    
    <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/student') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">grid_view</span>
            <span class="font-label-lg text-label-lg">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/student/submission') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">add_circle</span>
            <span class="font-label-lg text-label-lg">Buat Baru</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 bg-primary text-white rounded-lg transition-colors font-bold relative" href="{{ url('/student/submission-history') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">history</span>
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
</aside>

<!-- Main Content Wrapper -->
<div class="flex-grow md:ml-sidebar-width flex flex-col min-h-screen md:ml-[280px] pt-0">
    <!-- TopAppBar -->
    <header class="bg-pure-white border-b border-outline-variant flex justify-between items-center px-container-padding sticky top-0 z-10 w-full h-16">
        <h2 class="font-headline-sm text-headline-sm text-primary hidden md:block w-64 whitespace-nowrap">Layanan Dokumen</h2>
        <div class="flex items-center gap-gutter w-full justify-end">
            <div class="flex items-center gap-4 text-on-surface-variant">
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-1.5 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            <span class="">Keluar</span>
                        </button>
                    </form>
                @else
                    <button class="flex items-center gap-2 px-4 py-1.5 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors" onclick="alert('Keluar')">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        <span class="">Keluar</span>
                    </button>
                @endif
            </div>
        </div>
    </header>
    
    <!-- Main Canvas -->
    <main class="flex-grow p-container-padding flex flex-col gap-8 max-w-6xl">
        <!-- Page Title -->
        <section class="flex flex-col gap-2">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Riwayat Pengajuan Saya</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Kelola dan pantau status permohonan dokumen akademik Anda di sini.</p>
        </section>
        
        <!-- Filter Section -->
        <section class="bg-pure-white p-6 rounded-xl border border-outline-variant shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4 w-full">
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <input id="filter-start-date" class="appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer w-40" onblur="(this.type='text')" onfocus="(this.type='date')" placeholder="Mulai Tanggal" type="text">
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[20px]">calendar_today</span>
                    </div>
                    <span class="text-on-surface-variant font-medium">-</span>
                    <div class="relative">
                        <input id="filter-end-date" class="appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer w-40" onblur="(this.type='text')" onfocus="(this.type='date')" placeholder="Sampai Tanggal" type="text">
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-[20px]">calendar_today</span>
                    </div>
                </div>
                
                <div class="relative flex-1 min-w-[200px]">
                    <select id="filter-type" class="w-full appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer">
                        <option value="">Semua Jenis Surat</option>
                        <option value="aktif">Keterangan Aktif</option>
                        <option value="cuti">Cuti Akademik</option>
                        <option value="transkrip">Transkrip Nilai</option>
                        <option value="penelitian">Izin Penelitian</option>
                        <option value="magang">Pengantar Magang</option>
                        <option value="legalisir">Legalisir Ijazah</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
                
                <div class="relative w-48">
                    <select id="filter-status" class="w-full appearance-none bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary rounded-lg pl-4 pr-10 h-12 text-body-sm font-body-sm text-on-surface cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
            </div>
        </section>
        
        <!-- Data Table -->
        <section class="bg-pure-white rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low">
                        <tr>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">No</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">Jenis Surat</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium">Tgl. Pengajuan</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant font-body-sm text-on-surface" id="submission-table-body">
                        @foreach ($submissions as $index => $item)
                            <tr class="submission-row hover:bg-surface-container-low transition-colors duration-200 cursor-pointer" 
                                data-type="{{ $item['type'] }}" 
                                data-status="{{ $item['status'] }}" 
                                data-date="{{ $item['date'] }}"
                                onclick="openDetailModal({{ $item['id'] }})">
                                <td class="px-6 py-5">{{ $index + 1 }}</td>
                                <td class="px-6 py-5 font-semibold text-deep-black">{{ $item['type'] }}</td>
                                <td class="px-6 py-5 text-on-surface-variant">{{ $item['date'] }}</td>
                                <td class="px-6 py-5 text-center">
                                    @if ($item['status'] === 'Disetujui')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 text-[11px] rounded-full font-semibold uppercase tracking-wider">Disetujui</span>
                                    @elseif ($item['status'] === 'Ditolak')
                                        <span class="px-3 py-1 bg-error-container text-error border border-error/20 text-[11px] rounded-full font-semibold uppercase tracking-wider">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 bg-secondary-container text-secondary border border-yellow-200 text-[11px] rounded-full font-semibold uppercase tracking-wider">{{ $item['status'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-surface-container-low flex items-center justify-between border-t border-outline-variant">
                <p class="text-body-sm text-on-surface-variant font-medium">Menampilkan 1-5 dari {{ count($submissions) }} pengajuan</p>
                <div class="flex gap-2">
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </button>
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary text-on-primary font-bold">1</button>
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">2</button>
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">3</button>
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-outline-variant bg-pure-white text-on-surface-variant hover:border-primary hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Status Detail Modal -->
<div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="status-detail-modal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm animate-fade-in" onclick="closeModal()"></div>
    <div class="relative bg-pure-white w-full max-w-lg mx-4 rounded-xl shadow-xl overflow-hidden flex flex-col animate-scale-up">
        <!-- Modal Header -->
        <div class="p-6 border-b border-outline-variant flex justify-between items-center">
            <div class="flex flex-col">
                <h3 class="font-headline-sm text-headline-sm text-deep-black">Status Pengajuan</h3>
                <p class="text-body-sm text-on-surface-variant" id="modal-title">-</p>
            </div>
            <button class="p-2 hover:bg-surface-container rounded-full transition-colors" onclick="closeModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-6 overflow-y-auto max-h-[70vh]">
            <!-- Timeline -->
            <div id="modal-timeline" class="relative pl-8 space-y-8 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant">
                <!-- Dynamic Timeline Items -->
            </div>
            
            <hr class="border-outline-variant">
            
            <!-- Details Grid -->
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                    <p id="modal-purpose" class="font-label-lg text-label-lg text-deep-black font-bold">-</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Dosen Dituju</p>
                    <p id="modal-lecturer" class="font-label-lg text-label-lg text-deep-black font-bold">-</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                    <p id="modal-nim" class="font-label-lg text-label-lg text-deep-black font-bold">{{ $nim }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                    <p id="modal-prodi" class="font-label-lg text-label-lg text-deep-black font-bold">{{ $prodi }}</p>
                </div>
            </div>
            
            <!-- Lampiran -->
            <div class="space-y-2 mt-4">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Lampiran</p>
                <div id="modal-attachments" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Dynamic Attachments -->
                </div>
            </div>
            
            <!-- SLA Info Box -->
            <div class="bg-primary-fixed/30 p-4 rounded-lg border border-primary/10 flex gap-3">
                <span class="material-symbols-outlined text-primary">info</span>
                <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat menghubungi bagian Akademik.</p>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
            <button class="px-6 py-2 border border-primary text-primary font-label-md rounded-lg hover:bg-primary-fixed/20 transition-colors flex items-center gap-2" id="download-btn">
                <span class="material-symbols-outlined text-sm">download</span>
                Unduh Dokumen
            </button>
            <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    // Dump dynamic PHP data to javascript variable
    const submissionsData = @json($submissions);

    function openDetailModal(id) {
        const submission = submissionsData.find(item => item.id == id);
        if (!submission) return;

        // Set title and details
        document.getElementById('modal-title').innerText = submission.type;
        document.getElementById('modal-purpose').innerText = submission.purpose;
        document.getElementById('modal-lecturer').innerText = submission.lecturer;
        
        // Toggle download button visibility based on status
        const downloadBtn = document.getElementById('download-btn');
        if (submission.status === 'Disetujui') {
            downloadBtn.classList.remove('hidden');
        } else {
            downloadBtn.classList.add('hidden');
        }

        // Render Dynamic Attachments
        let attachmentsHtml = '';
        if (submission.attachments && submission.attachments.length > 0) {
            submission.attachments.forEach(file => {
                attachmentsHtml += `
                <div class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group">
                    <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error shrink-0">
                        <span class="material-symbols-outlined">picture_as_pdf</span>
                    </div>
                    <div class="overflow-hidden flex-grow min-w-0">
                        <p class="text-label-sm text-deep-black truncate font-semibold">${file.name}</p>
                        <p class="text-[10px] text-on-surface-variant">${file.size}</p>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant ml-auto opacity-0 group-hover:opacity-100 transition-opacity shrink-0">download</span>
                </div>`;
            });
        } else {
            attachmentsHtml = '<p class="text-body-sm text-on-surface-variant italic col-span-2">Tidak ada lampiran</p>';
        }
        document.getElementById('modal-attachments').innerHTML = attachmentsHtml;

        // Render Dynamic Timeline
        let timelineHtml = '';
        if (submission.timeline && submission.timeline.length > 0) {
            submission.timeline.forEach(step => {
                let icon = 'check';
                let iconClass = 'bg-green-100 text-green-700';
                
                if (step.status === 'rejected') {
                    icon = 'close';
                    iconClass = 'bg-error-container text-error';
                } else if (step.status === 'pending' || step.status === 'active') {
                    icon = 'sync';
                    iconClass = 'bg-secondary-container text-secondary';
                } else if (step.status === 'upcoming' || step.status === 'cancelled') {
                    icon = step.status === 'cancelled' ? 'block' : 'schedule';
                    iconClass = 'bg-surface-container-high text-on-surface-variant';
                }
                
                timelineHtml += `
                <div class="relative">
                    <div class="absolute -left-8 w-6 h-6 rounded-full ${iconClass} flex items-center justify-center z-10">
                        <span class="material-symbols-outlined text-sm font-bold">${icon}</span>
                    </div>
                    <div>
                        <p class="font-label-lg text-label-lg text-deep-black">${step.title}</p>
                        <p class="text-body-sm text-on-surface-variant">${step.time}</p>
                    </div>
                </div>`;
            });
        }
        document.getElementById('modal-timeline').innerHTML = timelineHtml;

        // Show Modal
        document.getElementById('status-detail-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('status-detail-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Client-side filtering logic
    const filterType = document.getElementById('filter-type');
    const filterStatus = document.getElementById('filter-status');
    const startDateInput = document.getElementById('filter-start-date');
    const endDateInput = document.getElementById('filter-end-date');
    const rows = document.querySelectorAll('.submission-row');

    function filterTable() {
        const selectedType = filterType.value.toLowerCase();
        const selectedStatus = filterStatus.value.toLowerCase();
        const startDateVal = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDateVal = endDateInput.value ? new Date(endDateInput.value) : null;

        rows.forEach(row => {
            const type = row.getAttribute('data-type').toLowerCase();
            const status = row.getAttribute('data-status').toLowerCase();
            const dateStr = row.getAttribute('data-date'); // e.g., "14 Okt 2023, 09:12"
            
            let show = true;
            
            // Type filter
            if (selectedType && !type.includes(selectedType)) {
                show = false;
            }
            
            // Status filter
            if (selectedStatus && !status.includes(selectedStatus)) {
                show = false;
            }
            
            // Date range filter
            if (show && (startDateVal || endDateVal)) {
                const rowDate = parseIndonesianDate(dateStr);
                if (rowDate) {
                    if (startDateVal) {
                        // strip hours for date comparison
                        const start = new Date(startDateVal.getFullYear(), startDateVal.getMonth(), startDateVal.getDate());
                        const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                        if (current < start) show = false;
                    }
                    if (endDateVal) {
                        const end = new Date(endDateVal.getFullYear(), endDateVal.getMonth(), endDateVal.getDate());
                        const current = new Date(rowDate.getFullYear(), rowDate.getMonth(), rowDate.getDate());
                        if (current > end) show = false;
                    }
                }
            }

            row.style.display = show ? '' : 'none';
        });
    }

    // Helper function to parse dates formatted as "14 Okt 2023, 09:12"
    function parseIndonesianDate(dateStr) {
        const months = {
            'jan': 0, 'feb': 1, 'mar': 2, 'apr': 3, 'mei': 4, 'jun': 5,
            'jul': 6, 'agu': 7, 'sep': 8, 'okt': 9, 'nov': 10, 'des': 11
        };
        try {
            const datePart = dateStr.split(',')[0].trim();
            const parts = datePart.split(' ');
            if (parts.length === 3) {
                const day = parseInt(parts[0]);
                const monthName = parts[1].toLowerCase();
                const year = parseInt(parts[2]);
                const month = months[monthName] !== undefined ? months[monthName] : 0;
                return new Date(year, month, day);
            }
        } catch (e) {
            console.error('Failed to parse date:', dateStr, e);
        }
        return null;
    }

    if (filterType) filterType.addEventListener('change', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
    if (startDateInput) startDateInput.addEventListener('change', filterTable);
    if (endDateInput) endDateInput.addEventListener('change', filterTable);
</script>
</body>
</html>
