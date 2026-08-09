@php
    $user = auth()->user();
    $lecturer = $user?->lecturer;
    $lecturerName = $user?->name ?? 'Dosen';
    $nidn = $lecturer?->national_lecturer_number ?? $user?->username ?? '-';
    $lecturerPhoto = null;
    $roles = $lecturer ? $lecturer->getActiveRoles() : [];
@endphp

<x-layouts.dashboard 
    role="lecturer"
    title="Layanan Dokumen - Dosen"
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
