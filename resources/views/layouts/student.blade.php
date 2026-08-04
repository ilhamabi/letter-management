@php
    // Default / Mock data in case variables aren't passed from controller or view
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

<x-layouts.app 
    title="Layanan Dokumen" 
    customCss="css/mahasiswa-dashboard.css" 
    bodyClass="bg-surface-gray text-on-surface min-h-screen flex"
>
    <!-- SideNavBar Component -->
    <x-sidebar 
        role="student" 
        :userName="$studentName" 
        :userSubtext="'NIM: ' . $nim" 
        :userPhoto="$profilePhoto" 
    />

    <!-- Main Content Wrapper -->
    <div class="flex-grow md:ml-sidebar-width flex flex-col min-h-screen md:ml-[280px] pt-0">
        <!-- Header Component -->
        <x-header role="student" title="Layanan Dokumen" />
        
        <!-- Main Canvas -->
        <main class="flex-grow p-container-padding flex flex-col gap-8 w-full">
            @yield('content')
        </main>
    </div>
</x-layouts.app>
