@php
    $adminName = $adminName ?? (auth()->check() ? auth()->user()->name : 'Admin');
    $adminSubtext = $adminSubtext ?? 'Administrator';
    $adminPhoto = $adminPhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMizNsImUsAhQ1K0MobwV_I-xE5GJAje3rmApO43UMzs2HSAmf2BVZXm3AyvXCbW0TyVQiGNpGGQH_7zZhKQzgE-socR3g9BJVABx_IEBfzntAvOyZtgMO_tlj8GVxuL_2qNWxXtDetUKHpaysIf0n3dKfPG1eIM9EYmkaKrSEPDLsi_Yib9xlm8vTGmzkww7ib2CoLQf1OUEl8CMPS6G-eIKzYMC5EPlK5uOkKYOSDPufDRy7TRMg';
@endphp

<x-layouts.dashboard 
    role="admin"
    title="Layanan Dokumen"
    headerTitle="Layanan Dokumen"
    :userName="$adminName"
    :userSubtext="$adminSubtext"
    :userPhoto="$adminPhoto"
    mainPadding="p-8 space-y-8"
>
    @yield('content')
</x-layouts.dashboard>
