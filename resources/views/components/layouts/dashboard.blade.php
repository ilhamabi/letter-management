@props([
    'role' => 'student',
    'title' => 'Layanan Dokumen',
    'headerTitle' => 'Layanan Dokumen',
    'userName' => null,
    'userSubtext' => null,
    'userPhoto' => null,
    'roles' => [],
    'customCss' => null,
    'bodyClass' => 'flex h-screen overflow-hidden text-sm bg-[#FAFAFA]',
    'mainPadding' => 'p-8',
])

<x-layouts.app 
    :title="$title" 
    :customCss="$customCss" 
    :bodyClass="$bodyClass"
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
        :role="$role" 
        :userName="$userName" 
        :userSubtext="$userSubtext" 
        :userPhoto="$userPhoto" 
        :roles="$roles" 
    />

    <!-- Main Content Shell -->
    <main class="flex-1 flex flex-col overflow-hidden bg-[#FAFAFA]" data-purpose="main-content">
        <!-- Header Component -->
        <x-header :role="$role" :title="$headerTitle" />

        <!-- Inner Content Area -->
        <div class="flex-1 overflow-y-auto {{ $mainPadding }}">
            {{ $slot }}
        </div>
    </main>
</x-layouts.app>
