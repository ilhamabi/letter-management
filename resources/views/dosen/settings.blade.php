@php
    // Default / Mock data so the settings page works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-primary'],
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
    
    <title>Pengaturan Akun - Universitas Amikom</title>

    <!-- Tailwind CSS (Vite / Fallback CDN) -->
    @if (Route::has('login'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                "colors": {
                        "on-secondary-fixed": "#221b00",
                        "inverse-primary": "#e5b4ff",
                        "surface-variant": "#e3e2e2",
                        "surface": "#fbf9f9",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "tertiary-fixed": "#ffdf96",
                        "tertiary-container": "#4d3a00",
                        "on-primary-fixed-variant": "#642c86",
                        "error": "#ba1a1a",
                        "surface-container-high": "#e9e8e7",
                        "on-surface": "#1b1c1c",
                        "primary-fixed": "#f5d9ff",
                        "on-tertiary-container": "#c0a461",
                        "deep-black": "#1A1A1A",
                        "surface-container-highest": "#e3e2e2",
                        "surface-bright": "#fbf9f9",
                        "secondary-fixed-dim": "#e9c400",
                        "on-secondary-container": "#6e5c00",
                        "surface-gray": "#F7F7F7",
                        "tertiary": "#332500",
                        "primary-fixed-dim": "#e5b4ff",
                        "on-surface-variant": "#4d4450",
                        "on-tertiary-fixed": "#251a00",
                        "background": "#fbf9f9",
                        "on-primary-container": "#cc8ff0",
                        "on-secondary-fixed-variant": "#544600",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#dbdad9",
                        "on-primary-fixed": "#30004b",
                        "secondary": "#705d00",
                        "primary": "#410063",
                        "outline": "#7e7481",
                        "surface-container": "#efeded",
                        "on-error": "#ffffff",
                        "surface-container-low": "#f5f3f3",
                        "surface-tint": "#7e45a0",
                        "secondary-container": "#fcd400",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#e1c37d",
                        "pure-white": "#FFFFFF",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#584409",
                        "secondary-fixed": "#ffe16d",
                        "on-error-container": "#93000a",
                        "primary-container": "#59207b",
                        "on-background": "#1b1c1c",
                        "inverse-surface": "#303031",
                        "outline-variant": "#cfc2d1",
                        "inverse-on-surface": "#f2f0f0"
                },
                "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                },
                "spacing": {
                        "margin-desktop": "48px",
                        "base": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "container-max": "1280px"
                },
                "fontFamily": {
                        "headline-lg-mobile": ["Montserrat"],
                        "body-sm": ["Public Sans"],
                        "headline-lg": ["Montserrat"],
                        "display-lg": ["Montserrat"],
                        "label-sm": ["Public Sans"],
                        "body-md": ["Public Sans"],
                        "label-lg": ["Public Sans"],
                        "headline-md": ["Montserrat"],
                        "body-lg": ["Public Sans"],
                        "title-lg": ["Montserrat"]
                },
                "fontSize": {
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "600"}]
                }
              },
            },
          }
        </script>
    @endif

    <style data-purpose="custom-styles">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Public+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap');
        
        body {
          font-family: 'Public Sans', sans-serif;
          background-color: #FAFAFA;
          color: #333333;
        }
    
        .bg-amikom-gold { background-color: #E28800; }
        .bg-amikom-green { background-color: #0E7452; }
        .bg-amikom-purple { background-color: #410063; }
    
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
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
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
<h1 class="font-headline-lg text-[18px] leading-[1.1] text-primary font-bold">
            UNIVERSITAS<br>AMIKOM
        </h1>
<p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-medium">Student Services</p>
</div>
</div>
</div>
<!-- Navigation -->
<nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/lecturer') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">grid_view</span>
<span class="font-label-lg text-label-lg">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/lecturer/approval') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">description</span>
<span class="font-label-lg text-label-lg">Persetujuan Dokumen</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" href="{{ url('/lecturer/approval-history') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center">history</span>
<span class="font-label-lg text-label-lg">Riwayat</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 bg-primary text-white rounded-lg transition-colors" href="{{ url('/lecturer/settings') }}">
<span class="material-symbols-outlined w-6 h-6 flex items-center justify-center" style="font-variation-settings: 'FILL' 1;">settings</span>
<span class="font-label-lg text-label-lg">Pengaturan Akun</span>
</a>
</nav>
</div>
<!-- Bottom Section: User Profile -->
<div class="p-6 border-t border-gray-200 bg-white mt-auto" data-purpose="user-profile">
<div class="flex flex-col gap-4 px-2">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center overflow-hidden border border-outline-variant">
<img alt="{{ $lecturerName }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLtbZi7_O5yCa33qPpomRGUvdxOhNGHeX4tBG3fVhw7eoDjoUTK1UHlsS26Sz4eKDZYaXRn18sDVQhcl1wsvwfOAwbgkgutKSUZMS2I_Y4yZTwtDiIV0bsawBh1E3Qjm8ppnttz114l_C-u64-rlU63z5BYSPaterX5RfVszRTaRRKll9FTzei8JcbG2Tf0QlQabkaQJaspl7jHqIwa3z8digSlnofpvdT8EVSOVx8hAgNdbo4uPL2USoHk">
</div>
<div class="flex-1">
<p class="text-body-md font-headline-lg text-on-surface leading-tight font-bold">{{ $lecturerName }}</p>
<p class="text-xs text-on-surface-variant truncate mt-0.5">NIDN: {{ $nidn }}</p>
</div>
</div>
<div class="flex flex-wrap gap-1.5">
@foreach ($roles as $role)
<span class="text-[10px] font-semibold text-white tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
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
<h2 class="text-xl font-semibold text-primary">Layanan Dokumen</h2>

        <!-- Logout Button -->
        @if (Route::has('logout'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium">
                    <span class="material-symbols-outlined text-lg mr-2">logout</span>
                    Logout
                </button>
            </form>
        @else
            <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm text-sm font-medium" onclick="alert('Logout action placeholder')">
                <span class="material-symbols-outlined text-lg mr-2">logout</span>
                Logout
            </button>
        @endif
</header>
<!-- END: Header -->
<!-- BEGIN: Page Content -->
<div class="flex-1 overflow-y-auto p-8 space-y-8">
<!-- Page Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4">
<div>
<h2 class="text-2xl font-bold text-gray-900 m-0 font-headline-md">Pengaturan Akun</h2>
<p class="text-gray-600 mt-2 font-body-md">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
</div>
</div>
<!-- Settings Grid (Restructured to match SCREEN_119) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Left Column: Profile Card -->
<div class="lg:col-span-1 flex flex-col gap-6">
<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
<div class="relative group cursor-pointer">
<img alt="{{ $lecturerName }}" class="w-32 h-32 rounded-xl object-cover border border-gray-200 shadow-sm" src="https://lh3.googleusercontent.com/aida/AP1WRLtbZi7_O5yCa33qPpomRGUvdxOhNGHeX4tBG3fVhw7eoDjoUTK1UHlsS26Sz4eKDZYaXRn18sDVQhcl1wsvwfOAwbgkgutKSUZMS2I_Y4yZTwtDiIV0bsawBh1E3Qjm8ppnttz114l_C-u64-rlU63z5BYSPaterX5RfVszRTaRRKll9FTzei8JcbG2Tf0QlQabkaQJaspl7jHqIwa3z8digSlnofpvdT8EVSOVx8hAgNdbo4uPL2USoHk">
<div class="absolute inset-0 bg-gray-900/50 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-white">photo_camera</span>
</div>
</div>
<div>
<h4 class="text-lg font-bold text-gray-900 font-headline-md">{{ $lecturerName }}</h4>
<p class="text-sm text-gray-500 font-body-sm">Dosen Universitas Amikom</p>
</div>
</div>
</div>
<!-- Right Column: Personal Info & Security -->
<div class="lg:col-span-2 flex flex-col gap-6">
<!-- Personal Info Card -->
<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
<div class="flex items-center justify-between border-b border-gray-200 pb-4">
<h4 class="text-lg font-bold text-gray-900 font-headline-md">Informasi Pribadi</h4>
</div>
<div class="flex flex-col gap-4">
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg">Nama Lengkap</label>
<p class="text-sm font-semibold text-gray-900 py-2 font-body-md">{{ $lecturerName }}</p>
</div>
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg">NIDN</label>
<p class="text-sm font-semibold text-gray-900 py-2 font-body-md">{{ $nidn }}</p>
</div>
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg">Alamat Email</label>
<p class="text-sm font-semibold text-gray-900 py-2 font-body-md">heri.setyawan@amikom.ac.id</p>
</div>
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg">Peran Akademik</label>
<div class="flex flex-wrap gap-2 mt-1">
@foreach ($roles as $role)
<span class="text-[10px] font-semibold text-white tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
@endforeach
</div>
</div>
</div>
</div>
<!-- Security Card -->
<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm" data-purpose="security-settings">
<div class="border-b border-gray-200 pb-4">
<h4 class="text-lg font-bold text-gray-900 font-headline-md">Keamanan Akun</h4>
<p class="text-sm text-gray-500 mt-1 font-body-sm">Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter .</p>
</div>
<form class="flex flex-col gap-4">
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg" for="current-password">Kata Sandi Saat Ini</label>
<div class="relative">
<input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="current-password" placeholder="••••••••" type="password">
<span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm cursor-pointer hover:text-primary transition-colors" onclick="const input = this.previousElementSibling; if (input.type === 'password') { input.type = 'text'; this.textContent = 'visibility'; } else { input.type = 'password'; this.textContent = 'visibility_off'; }">visibility_off</span>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg" for="new-password">Kata Sandi Baru</label>
<input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="new-password" placeholder="••••••••" type="password">
</div>
<div class="flex flex-col gap-1.5">
<label class="text-sm font-medium text-gray-700 font-label-lg" for="confirm-password">Konfirmasi Kata Sandi Baru</label>
<input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="confirm-password" placeholder="••••••••" type="password">
</div>
</div>
<div class="flex justify-end pt-4">
<button class="px-6 py-2.5 bg-primary text-white rounded-md text-sm font-medium hover:opacity-90 transition-colors shadow-sm font-label-lg" type="button">Perbarui Kata Sandi</button>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- END: Page Content -->
</main>
<!-- END: Main Content -->
</body>
</html>
