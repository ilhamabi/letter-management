@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $profilePhoto = null;
@endphp

<x-layouts.app 
    title="Layanan Dokumen" 
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
