@php
    // Default / Mock data in case variables aren't passed from controller or view
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Universitas Amikom')</title>
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet">
    
    <!-- Separated Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/mahasiswa-dashboard.css') }}">


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
            <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->is('student/settings') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">settings</span>
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
    <main class="flex-grow p-container-padding flex flex-col gap-8 w-full">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
