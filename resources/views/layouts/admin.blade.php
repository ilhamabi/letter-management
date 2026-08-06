@php
    $adminName = auth()->check() ? auth()->user()->name : 'User';
    $adminSubtext = 'Administrator';
    $adminPhoto = null;
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
