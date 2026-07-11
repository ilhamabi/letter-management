@php
    // Default / Mock data so the settings page works out of the box even without controller variables
    $studentName = $studentName ?? 'Alex Chandra';
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Pengaturan Akun - Layanan Dokumen</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite / Fallback CDN) -->
    @if (Route::has('login'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script id="tailwind-config">
            try {
                tailwind.config = {
                    darkMode: "class",
                    theme: {
                        extend: {
                            "colors": {
                                "tertiary-fixed": "#ffdf96",
                                "tertiary-fixed-dim": "#e1c37d",
                                "on-primary": "#ffffff",
                                "inverse-surface": "#303031",
                                "surface-container-highest": "#e3e2e2",
                                "pure-white": "#FFFFFF",
                                "primary-fixed": "#f5d9ff",
                                "primary-fixed-dim": "#e5b4ff",
                                "outline": "#7e7481",
                                "surface-container-high": "#e9e8e7",
                                "on-secondary-fixed-variant": "#544600",
                                "secondary-fixed": "#ffe16d",
                                "surface-container": "#efeded",
                                "on-tertiary-fixed": "#251a00",
                                "on-error": "#ffffff",
                                "on-primary-fixed-variant": "#642c86",
                                "surface-bright": "#fbf9f9",
                                "on-secondary-container": "#6e5c00",
                                "secondary-container": "#fcd400",
                                "error-container": "#ffdad6",
                                "on-secondary": "#ffffff",
                                "secondary-fixed-dim": "#e9c400",
                                "on-primary-fixed": "#30004b",
                                "on-background": "#1b1c1c",
                                "surface-gray": "#F7F7F7",
                                "tertiary": "#332500",
                                "error": "#ba1a1a",
                                "background": "#fbf9f9",
                                "tertiary-container": "#4d3a00",
                                "surface-variant": "#e3e2e2",
                                "outline-variant": "#cfc2d1",
                                "secondary": "#705d00",
                                "on-secondary-fixed": "#221b00",
                                "on-surface": "#1b1c1c",
                                "surface-container-lowest": "#ffffff",
                                "on-tertiary": "#ffffff",
                                "on-error-container": "#93000a",
                                "surface": "#fbf9f9",
                                "on-tertiary-fixed-variant": "#584409",
                                "on-surface-variant": "#4d4450",
                                "surface-dim": "#dbdad9",
                                "on-primary-container": "#cc8ff0",
                                "deep-black": "#1A1A1A",
                                "surface-container-low": "#f5f3f3",
                                "primary": "#410063",
                                "inverse-primary": "#e5b4ff",
                                "primary-container": "#59207b",
                                "inverse-on-surface": "#f2f0f0",
                                "surface-tint": "#7e45a0"
                            },
                            "borderRadius": {
                                "DEFAULT": "0.125rem",
                                "lg": "0.25rem",
                                "xl": "0.5rem",
                                "full": "0.75rem"
                            },
                            "spacing": {
                                "container-max": "1280px",
                                "gutter": "24px",
                                "margin-mobile": "16px",
                                "base": "8px",
                                "margin-desktop": "48px",
                                "sidebar-width": "280px"
                            },
                            "fontFamily": {
                                "headline-lg-mobile": ["Montserrat"],
                                "label-lg": ["Public Sans"],
                                "headline-lg": ["Montserrat"],
                                "body-md": ["Public Sans"],
                                "headline-md": ["Montserrat"],
                                "body-lg": ["Public Sans"],
                                "title-lg": ["Montserrat"],
                                "display-lg": ["Montserrat"],
                                "body-sm": ["Public Sans"],
                                "label-sm": ["Public Sans"],
                                "headline-sm": ["Montserrat"],
                                "label-md": ["Public Sans"]
                            },
                            "fontSize": {
                                "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                                "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                                "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                                "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                                "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                                "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                                "title-lg": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                                "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                                "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                                "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500" }],
                                "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                                "label-md": ["14px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }]
                            }
                        },
                    },
                }
            } catch (_e) {}
        </script>
    @endif

    <style data-purpose="custom-styles">
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
          width: 8px;
          height: 8px;
        }
        ::-webkit-scrollbar-track {
          background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
          background: #c1c1c1; 
          border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
          background: #a8a8a8; 
        }
    </style>
</head>
<body class="bg-surface-gray text-on-surface min-h-screen flex h-screen overflow-hidden">
<!-- Sidebar -->
<aside class="hidden md:flex flex-col h-screen w-sidebar-width fixed left-0 top-0 bg-pure-white border-r border-outline-variant z-20 pt-8 flex-shrink-0" data-purpose="sidebar">
<!-- Logo Section -->
<div class="px-8 mb-12 flex items-center gap-4">
<img alt="Universitas Amikom Logo" class="w-12 h-12 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs">
<div>
<h1 class="font-display-lg text-title-lg text-primary leading-[1.1] font-bold uppercase tracking-tight">Universitas<br>Amikom</h1>
<p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">Student Services</p>
</div>
</div>
<!-- Navigation Links -->
<nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/student') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">grid_view</span>
<span class="font-label-lg text-label-lg">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/student/submission') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">add_circle</span>
<span class="font-label-lg text-label-lg">Buat Baru</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/student/submission-history') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">history</span>
<span class="font-label-lg text-label-lg">Riwayat Pengajuan</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 bg-primary text-white rounded-lg transition-colors font-bold relative" href="{{ url('/student/settings') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">account_circle</span>
<span class="font-label-lg text-label-lg">Pengaturan Akun</span>
</a>
</nav>
<!-- User Profile (Anchored at Bottom) -->
<div class="p-6 border-t border-outline-variant bg-surface-container-low/30" data-purpose="user-profile">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center shrink-0 overflow-hidden border border-outline-variant">
<img alt="{{ $studentName }}" class="w-full h-full object-cover" src="{{ $profilePhoto }}">
</div>
<div class="overflow-hidden">
<p class="font-label-md text-on-surface truncate font-bold leading-tight">{{ $studentName }}</p>
<p class="font-label-sm text-xs text-on-surface-variant truncate">NIM: {{ $nim }}</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Wrapper -->
<div class="flex-1 md:ml-sidebar-width flex flex-col overflow-hidden bg-surface-gray">
<!-- Top Header -->
<header class="h-16 flex items-center justify-between px-8 bg-pure-white border-b border-outline-variant shrink-0" data-purpose="top-header">
<h2 class="font-headline-sm text-headline-sm text-primary">Layanan Dokumen</h2>
<div class="flex items-center gap-4">
    @if (Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-md text-on-surface-variant bg-pure-white hover:bg-surface-container transition-colors shadow-sm font-label-md">
                <span class="material-symbols-outlined text-sm">logout</span>
                Keluar
            </button>
        </form>
    @else
        <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-md text-on-surface-variant bg-pure-white hover:bg-surface-container transition-colors shadow-sm font-label-md" onclick="alert('Keluar')">
            <span class="material-symbols-outlined text-sm">logout</span>
            Keluar
        </button>
    @endif
</div>
</header>
<!-- Page Content -->
<main class="flex-1 overflow-y-auto p-8 space-y-8" data-purpose="main-content">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-outline-variant pb-4 gap-4">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface m-0">Pengaturan Akun</h2>
<p class="font-body-md text-on-surface-variant mt-2">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
</div>
</div>
<!-- Settings Grid (Bento-style layout) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Left Column (Profile & Photo) -->
<div class="lg:col-span-1 flex flex-col gap-6">
<!-- Profile Photo Card -->
<div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
<div class="relative group cursor-pointer mb-2">
<img alt="{{ $studentName }} Profile Picture" class="w-32 h-32 rounded-xl object-cover border border-outline-variant shadow-sm" src="{{ $profilePhoto }}">
<div class="absolute inset-0 bg-primary/20 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-white">photo_camera</span>
</div>
</div>
<div class="flex flex-col items-center gap-1">
<h4 class="font-title-lg text-title-lg text-on-surface font-bold">{{ $studentName }}</h4>
<p class="font-body-sm text-on-surface-variant">{{ $nim }}</p>
<div class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full font-label-sm text-xs font-bold uppercase tracking-wider inline-block mt-2">
                                MAHASISWA
                            </div>
</div>
</div>
</div>
<!-- Right Column (Forms) -->
<div class="lg:col-span-2 flex flex-col gap-6">
<!-- Personal Info Card -->
<div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col gap-6 shadow-sm">
<div class="flex items-center justify-between border-b border-outline-variant pb-4">
<h4 class="font-title-lg text-title-lg text-on-surface font-bold">Informasi Pribadi</h4>
</div>
<form class="flex flex-col gap-4">
<div class="grid grid-cols-1 gap-4">
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Nama Lengkap</label>
<p class="font-body-md text-on-surface font-semibold py-2">{{ $studentName }}</p>
</div>
</div>
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Alamat Email</label>
<p class="font-body-md text-on-surface font-semibold py-2">{{ strtolower(str_replace(' ', '.', $studentName)) }}@students.amikom.ac.id</p>
</div>
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Program Studi</label>
<p class="font-body-md text-on-surface font-semibold py-2">{{ $prodi }}</p>
</div>
</form>
</div>
<!-- Security Card -->
<div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col gap-6 shadow-sm">
<div class="border-b border-outline-variant pb-4">
<h4 class="font-title-lg text-title-lg text-on-surface font-bold">Keamanan Akun</h4>
<p class="font-body-sm text-on-surface-variant mt-1">Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter .</p>
</div>
<form class="flex flex-col gap-4">
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Kata Sandi Saat Ini</label>
<div class="relative">
<input class="w-full px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password" value="" placeholder="••••••••">
<span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm cursor-pointer hover:text-on-surface">visibility</span>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Kata Sandi Baru</label>
<input class="px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password">
</div>
<div class="flex flex-col gap-1.5">
<label class="font-label-sm text-on-surface-variant font-medium">Konfirmasi Kata Sandi Baru</label>
<input class="px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password">
</div>
</div>
<div class="flex justify-end pt-4">
<button class="px-6 py-2.5 bg-primary text-white rounded-md font-label-md hover:bg-primary-container transition-colors shadow-sm" type="button">Perbarui Kata Sandi</button>
</div>
</form>
</div>
</div>
</div>
</main>
</div>
<script>
    (function() {
      const toggleIcons = document.querySelectorAll('.material-symbols-outlined.absolute.right-3');
      toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
          const container = this.closest('.relative');
          const input = container.querySelector('input');
          
          if (input) {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            this.textContent = isPassword ? 'visibility' : 'visibility_off';
          }
        });
      });
    })();
</script>
</body>
</html>
