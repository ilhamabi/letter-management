@php
    $user = auth()->user();
    $lecturer = $user?->lecturer;
    $lecturerName = $user?->name ?? 'Dosen';
    $nik = $lecturer?->employee_number ?? $user?->username ?? '-';
    $lecturerPhoto = null;
    $roles = $lecturer ? $lecturer->getActiveRoles() : [];
@endphp

<x-layouts.dashboard 
    role="lecturer"
    title="Layanan Dokumen - Dosen"
    headerTitle="Layanan Dokumen"
    customCss="css/dosen-dashboard.css"
    :userName="$lecturerName"
    :userSubtext="'NIK: ' . $nik"
    :userPhoto="$lecturerPhoto"
    :roles="$roles"
    mainPadding="p-8"
>
    @yield('content')
</x-layouts.dashboard>
