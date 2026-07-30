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

<x-layouts.app 
    title="Sistem Layanan Surat D3 Teknik Informatika – Universitas Amikom" 
    customCss="css/dosen-dashboard.css" 
    bodyClass="flex h-screen overflow-hidden text-sm"
    x-data="{ sidebarOpen: false }"
>
    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:opacity
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm md:hidden" 
         style="display: none;"></div>

    <!-- Sidebar Component -->
    <x-sidebar 
        role="lecturer" 
        :userName="$lecturerName" 
        :userSubtext="'NIDN: ' . $nidn" 
        :userPhoto="$lecturerPhoto" 
        :roles="$roles" 
    />

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-[#FAFAFA]" data-purpose="main-content">
        <!-- Header Component -->
        <x-header role="lecturer" title="Layanan Dokumen" />

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>
</x-layouts.app>
