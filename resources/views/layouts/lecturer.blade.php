@php
    $user = auth()->user();
    $lecturerName = $user?->name ?? 'User';
    $nidn = $user?->lecturer?->national_lecturer_number ?? $user?->username ?? '-';
    $lecturerPhoto = null;
    $roles = [];
@endphp

<x-layouts.dashboard 
    role="lecturer"
    title="Layanan Dokumen"
    headerTitle="Layanan Dokumen"
    customCss="css/dosen-dashboard.css"
    :userName="$lecturerName"
    :userSubtext="'NIDN: ' . $nidn"
    :userPhoto="$lecturerPhoto"
    :roles="$roles"
    mainPadding="p-8"
>
    @yield('content')
</x-layouts.dashboard>
