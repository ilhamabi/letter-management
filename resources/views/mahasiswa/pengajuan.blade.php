@php
    // Default / Mock data so the page works out of the box even without controller variables
    $studentName = $studentName ?? 'Alex Chandra';
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Permintaan Baru - Universitas Amikom</title>
    
    <!-- Tailwind CSS (Vite / Fallback CDN) -->
    @if (Route::has('login'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    
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
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-surface-gray text-on-surface h-screen overflow-hidden flex">
<!-- SideNavBar -->
<aside class="hidden md:flex flex-col h-screen w-sidebar-width fixed left-0 top-0 bg-pure-white border-r border-outline-variant z-20 w-[280px] pt-8">
    <div class="px-container-padding mb-12 flex items-center gap-4">
        <img alt="Universitas Amikom Logo" class="w-12 h-12 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs"/>
        <div>
            <h1 class="font-display-lg text-title-lg text-primary leading-[1.2] font-bold uppercase tracking-tight">Universitas<br/>Amikom</h1>
            <p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">Student Services</p>
        </div>
    </div>
    <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/dashboard-mahasiswa') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">grid_view</span>
            <span class="font-label-lg text-label-lg">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 bg-primary text-white rounded-lg transition-colors font-bold relative" href="{{ url('/pengajuan') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">add_circle</span>
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
                <img alt="{{ $studentName }}" class="w-12 h-12 rounded-full object-cover shrink-0" src="{{ $profilePhoto }}"/>
            </div>
            <div class="overflow-hidden">
                <p class="font-label-md text-body-md text-on-surface truncate font-semibold">{{ $studentName }}</p>
                <p class="font-label-sm text-xs text-on-surface-variant">NIM: {{ $nim }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="flex-grow md:ml-sidebar-width flex flex-col h-screen overflow-y-auto pt-0 md:ml-[280px]">
    <!-- TopAppBar -->
    <header class="h-16 shrink-0 bg-pure-white border-b border-outline-variant flex justify-between items-center px-container-padding sticky top-0 z-10 w-full">
        <h2 class="font-headline-sm text-[18px] text-primary hidden md:block w-auto whitespace-nowrap">Layanan Dokumen</h2>
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
        <nav class="flex items-center gap-2 text-on-surface-variant font-label-sm">
            <a class="hover:text-primary transition-colors" href="#">Portal</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="#">Layanan Dokumen</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-semibold">Buat Permintaan Baru</span>
        </nav>
        
        <header>
            <h3 class="font-headline-lg text-[32px] text-on-surface font-bold mb-3">Buat Permintaan Baru</h3>
            <p class="font-body-md text-on-surface-variant max-w-3xl leading-relaxed">
                Silakan lengkapi formulir di bawah ini untuk mengajukan permintaan dokumen akademik. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.
            </p>
        </header>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8 bg-pure-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="p-8">
                    <form class="space-y-8" id="request-form">
                        @csrf
                        <div class="space-y-2">
                            <label class="block font-label-lg text-on-surface mb-1" for="jenis_surat">Jenis Surat</label>
                            <div class="relative">
                                <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 appearance-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md" id="jenis_surat">
                                    <option disabled="" selected="" value="">Pilih jenis surat...</option>
                                    <option value="transkrip">Transkrip Resmi (Official Transcript)</option>
                                    <option value="keterangan_aktif">Surat Keterangan Aktif Kuliah</option>
                                    <option value="sertifikat_lulus">Sertifikat Kelulusan (SKL)</option>
                                    <option value="legalisir">Legalisir Ijazah/Transkrip</option>
                                    <option value="pengantar_magang">Surat Pengantar Magang</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block font-label-lg text-on-surface mb-1" for="keperluan">Keperluan</label>
                            <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md resize-none" id="keperluan" placeholder="Contoh: Pengajuan Beasiswa PPA, Persyaratan Magang di PT. Telkom..." rows="3"></textarea>
                            <p class="text-[12px] text-on-surface-variant">Jelaskan secara singkat tujuan penggunaan dokumen ini.</p>
                        </div>
                        <div class="space-y-2">
                            <label class="block font-label-lg text-on-surface mb-1" for="catatan">Catatan Tambahan <span class="text-on-surface-variant font-normal text-sm ml-1">(Opsional)</span></label>
                            <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md resize-none" id="catatan" placeholder="Tambahkan informasi tambahan jika diperlukan..." rows="4"></textarea>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block font-label-lg text-on-surface mb-1">Lampiran Pendukung</label>
                                <p class="text-[12px] text-on-surface-variant mb-3">Unggah dokumen pendukung (KTM, Transkrip, atau Bukti Bayar) dalam format PDF (Maks. 2MB)</p>
                            </div>
                            <div class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-surface-container-low/30 hover:bg-surface-container-low transition-colors cursor-pointer group">
                                <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">upload_file</span>
                                </div>
                                <div class="text-center">
                                    <p class="font-medium text-on-surface">Tarik dan lepas berkas di sini</p>
                                    <p class="text-xs text-on-surface-variant mt-1">atau</p>
                                </div>
                                <button class="px-6 py-2 bg-pure-white border border-outline-variant rounded-lg text-primary font-label-md hover:bg-primary hover:text-on-primary transition-all" type="button">Pilih Berkas</button>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-3 bg-surface-container-lowest border border-outline-variant rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-error/10 flex items-center justify-center text-error">
                                            <span class="material-symbols-outlined">picture_as_pdf</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-on-surface">KTM_Alex_Chandra.pdf</p>
                                            <p class="text-[10px] text-on-surface-variant">1.2 MB</p>
                                        </div>
                                    </div>
                                    <button class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" type="button">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-outline-variant">
                            <button class="w-full bg-primary text-on-primary font-label-lg py-4 px-6 rounded-xl hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/10 flex items-center justify-center gap-2" id="submit-request-btn" type="button">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'wght' 600;">send</span>
                                Ajukan Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-primary-container text-on-primary-container p-6 rounded-xl border border-primary/10">
                    <h4 class="font-title-lg text-[18px] font-bold mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">info</span>
                        Informasi Penting
                    </h4>
                    <ul class="space-y-4 text-[13px] leading-relaxed">
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">timer</span>
                            <span class="">Proses pengerjaan dokumen membutuhkan waktu <strong>2-3 hari kerja</strong>.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">mail</span>
                            <span class="">Notifikasi akan dikirimkan melalui email dan dashboard portal.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">download</span>
                            <span class="">Dokumen digital dapat diunduh langsung setelah status <strong>"Selesai"</strong>.</span>
                        </li>
                    </ul>
                </div>
                
                <div class="relative bg-secondary-container rounded-xl border border-secondary/20 overflow-hidden group">
                    <div class="relative p-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="font-title-lg text-[18px] font-bold text-on-secondary-container">Informasi Mahasiswa</h4>
                            <span class="px-2 py-1 bg-pure-white/50 rounded-full text-[10px] font-bold text-secondary uppercase tracking-wider border border-secondary/20">Identity Verified</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pure-white flex items-center justify-center text-secondary shadow-sm">
                                    <span class="material-symbols-outlined text-[24px]">school</span>
                                </div>
                                <div>
                                    <p class="text-[12px] text-on-secondary-container/70 font-medium">Status Akademik</p>
                                    <p class="font-bold text-on-secondary-container">Aktif Kuliah</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                    <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">Total SKS</p>
                                    <p class="text-[18px] font-bold text-on-secondary-container">112</p>
                                </div>
                                <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                    <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">IPK</p>
                                    <p class="text-[18px] font-bold text-on-secondary-container">3.85</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Dosen Wali</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">person_4</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">Heri Setyawan, M.Kom.</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: 123456789</p>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-secondary/10 mt-4">
                                    <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Ketua Program Studi</p>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">person_3</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-on-secondary-container text-[14px]">Dr. Andi Wijaya, M.T.</p>
                                            <p class="text-[12px] text-on-secondary-container/70">NIDN: 061234567</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-secondary/10 mt-4">
                                    <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Dosen Pembimbing</p>
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">person_2</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-on-secondary-container text-[14px]">Siti Aminah, S.Kom., M.Cs.</p>
                                            <p class="text-[12px] text-on-secondary-container/70">NIDN: 069876543</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Confirmation Modal -->
<div class="fixed inset-0 z-[100] hidden" id="confirmation-modal">
    <div class="absolute inset-0 bg-deep-black/60 backdrop-blur-sm animate-fade-in" id="modal-backdrop"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-pure-white w-full max-w-md rounded-xl shadow-xl overflow-hidden transform animate-scale-up border border-outline-variant">
            <div class="p-8">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'wght' 500;">help</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-[20px] font-bold text-on-surface leading-tight">Konfirmasi Pengajuan</h3>
                        <p class="text-on-surface-variant text-[12px] font-medium tracking-wide uppercase mt-0.5">Permintaan Dokumen</p>
                    </div>
                </div>
                <p class="text-on-surface-variant text-body-md mb-8 leading-relaxed">
                    Apakah Anda yakin data yang dimasukkan sudah benar? Permintaan yang sudah dikirim <span class="font-bold text-on-surface">tidak dapat diubah kembali</span>.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="flex-1 order-2 sm:order-1 py-3.5 px-4 rounded-xl border border-outline-variant text-on-surface font-label-lg hover:bg-surface-container-low transition-all active:scale-[0.98]" id="close-modal-btn">
                        Batal
                    </button>
                    <button class="flex-1 order-1 sm:order-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2" id="confirm-submit-btn">
                        <span>Ya, Ajukan</span>
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('confirmation-modal');
    const openBtn = document.getElementById('submit-request-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const backdrop = document.getElementById('modal-backdrop');
    const confirmBtn = document.getElementById('confirm-submit-btn');

    const toggleModal = (show) => {
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

    openBtn.addEventListener('click', () => toggleModal(true));
    closeBtn.addEventListener('click', () => toggleModal(false));
    backdrop.addEventListener('click', () => toggleModal(false));
    
    confirmBtn.addEventListener('click', () => {
        confirmBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span><span>Memproses...</span>';
        setTimeout(() => {
            toggleModal(false);
            confirmBtn.innerHTML = '<span>Ya, Ajukan</span><span class="material-symbols-outlined text-[18px]">check_circle</span>';
            alert('Permintaan Anda telah berhasil dikirim!');
        }, 1500);
    });
</script>
</body>
</html>
