@php
    // Default mock data for admin user profile if not passed
    $adminName = $adminName ?? (auth()->check() ? auth()->user()->name : 'Admin');
    $adminSubtext = $adminSubtext ?? 'Administrator';
    $adminPhoto = $adminPhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMizNsImUsAhQ1K0MobwV_I-xE5GJAje3rmApO43UMzs2HSAmf2BVZXm3AyvXCbW0TyVQiGNpGGQH_7zZhKQzgE-socR3g9BJVABx_IEBfzntAvOyZtgMO_tlj8GVxuL_2qNWxXtDetUKHpaysIf0n3dKfPG1eIM9EYmkaKrSEPDLsi_Yib9xlm8vTGmzkww7ib2CoLQf1OUEl8CMPS6G-eIKzYMC5EPlK5uOkKYOSDPufDRy7TRMg';
@endphp

<x-layouts.app 
    title="@yield('title', 'Admin Dashboard - Amikom Document Services')" 
    bodyClass="flex h-screen overflow-hidden text-sm bg-[#FAFAFA]"
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
        role="admin" 
        :userName="$adminName" 
        :userSubtext="$adminSubtext" 
        :userPhoto="$adminPhoto" 
    />

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-[#FAFAFA]" data-purpose="main-content">
        <!-- Header Component -->
        <x-header role="admin" title="Layanan Dokumen" />

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            @yield('content')
        </div>
    </main>
</x-layouts.app>
