@php
    // Default / Mock data in case variables aren't passed from controller or view
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
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
    <title>@yield('title', 'Universitas Amikom')</title>
    
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
        try {
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
            };
        } catch (e) {
            // Tailwind CDN is not loaded, styled via compiled Vite CSS assets
        }
    </script>
    @stack('styles')
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
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('student') ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ url('/student') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->is('student') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">grid_view</span>
            <span class="font-label-lg text-label-lg">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('student/submission') ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ url('/student/submission') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->is('student/submission') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">add_circle</span>
            <span class="font-label-lg text-label-lg">Buat Baru</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('student/submission-history') ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ url('/student/submission-history') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->is('student/submission-history') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">history</span>
            <span class="font-label-lg text-label-lg">Riwayat Pengajuan</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('student/settings') ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ url('/student/settings') }}">
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->is('student/settings') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">account_circle</span>
            <span class="font-label-lg text-label-lg">Pengaturan Akun</span>
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
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
