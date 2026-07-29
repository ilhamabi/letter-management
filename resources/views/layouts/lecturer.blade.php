@php
    // Default mock data in case variables aren't passed from controller or view
    $lecturerName = $lecturerName ?? (auth()->check() ? auth()->user()->name : 'Heri Setyawan, M.Kom.');
    $nidn = $nidn ?? '123456789';
    $lecturerPhoto = $lecturerPhoto ?? 'https://i1.pickpik.com/photos/206/134/327/teacher-lecturer-writer-counselor-626ababd87ee30e9c0eb278ac724ee0a.jpg';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Sistem Layanan Surat D3 Teknik Informatika – Universitas Amikom</title>

    <!-- Tailwind CSS & JS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Separated Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dosen-dashboard.css') }}">
    
    <!-- Material Symbols & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Public+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen overflow-hidden text-sm" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:opacity
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm md:hidden" 
         style="display: none;"></div>

    <!-- BEGIN: Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col justify-between transition-transform duration-300 ease-in-out md:static md:translate-x-0"
           data-purpose="sidebar">
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
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('lecturer.dashboard') || request()->is('lecturer/dashboard') ? 'bg-amikom-purple text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}" href="{{ route('lecturer.dashboard') }}">
                    <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ (request()->routeIs('lecturer.dashboard') || request()->is('lecturer/dashboard')) ? 'font-variation-settings: \'FILL\' 1;' : '' }}">grid_view</span>
                    <span class="font-label-lg text-label-lg">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ (request()->routeIs('lecturer.approval*') || request()->is('lecturer/approval*')) ? 'bg-amikom-purple text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}" href="{{ route('lecturer.approval') }}">
                    <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ (request()->routeIs('lecturer.approval*') || request()->is('lecturer/approval*')) ? 'font-variation-settings: \'FILL\' 1;' : '' }}">description</span>
                    <span class="font-label-lg text-label-lg">Persetujuan Dokumen</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('lecturer.approval-history*') || request()->is('lecturer/approval-history*') ? 'bg-amikom-purple text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}" href="{{ route('lecturer.approval-history') }}">
                    <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->routeIs('lecturer.approval-history*') || request()->is('lecturer/approval-history*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">history</span>
                    <span class="font-label-lg text-label-lg">Riwayat Persetujuan</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('lecturer.settings*') || request()->is('lecturer/settings*') ? 'bg-amikom-purple text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}" href="{{ route('lecturer.settings') }}">
                    <span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="{{ request()->routeIs('lecturer.settings*') || request()->is('lecturer/settings*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">settings</span>
                    <span class="font-label-lg text-label-lg">Pengaturan Akun</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Section: User Profile -->
        <div class="p-6 border-t border-gray-200 bg-white" data-purpose="user-profile">
            <div class="flex flex-col gap-4 px-2">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                        <img alt="{{ $lecturerName }}" class="w-full h-full object-cover" src="{{ $lecturerPhoto }}">
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
    <main class="flex-1 flex flex-col overflow-hidden bg-[#FAFAFA]" data-purpose="main-content">
        
        <!-- BEGIN: Header -->
        <header class="h-16 flex items-center justify-between px-8 bg-white border-b border-gray-200 shrink-0 sticky top-0 z-20 backdrop-blur-md bg-white/80" data-purpose="top-header">
            <div class="flex items-center">
                <!-- Hamburger Button for Mobile -->
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-gray-600 hover:text-gray-900 focus:outline-none">
                    <span class="material-symbols-outlined text-2xl flex items-center justify-center">menu</span>
                </button>
                <h2 class="text-xl font-semibold text-amikom-purple">Layanan Dokumen</h2>
            </div>
            
            <!-- Logout Button -->
            @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm text-sm font-medium" onclick="alert('Logout action placeholder')">
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
            @yield('content')
        </div>
        <!-- END: Page Content -->
        
    </main>
    <!-- END: Main Content -->

</body>
</html>
