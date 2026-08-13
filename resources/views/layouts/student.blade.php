@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $profilePhoto = null;
@endphp

<x-layouts.dashboard 
    role="student"
    title="Layanan Dokumen - Mahasiswa"
    headerTitle="Layanan Dokumen"
    :userName="$studentName"
    :userSubtext="'NIM: ' . $nim"
    :userPhoto="$profilePhoto"
    mainPadding="p-8 space-y-8"
>
    @yield('content')
</x-layouts.dashboard>
