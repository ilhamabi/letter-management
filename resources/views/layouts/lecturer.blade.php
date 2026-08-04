@php
    // Default mock data in case variables aren't passed from controller or view
    $lecturerName = $lecturerName ?? (auth()->check() ? auth()->user()->name : 'Heri Setyawan, M.Kom.');
    $nidn = $nidn ?? '123456789';
    $lecturerPhoto = $lecturerPhoto ?? 'https://i1.pickpik.com/photos/206/134/327/teacher-lecturer-writer-counselor-626ababd87ee30e9c0eb278ac724ee0a.jpg';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
    ];
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
