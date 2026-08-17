@props([
    'logoUrl' => null,
])

@php
    $logo = $logoUrl ?? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('letter/images/logo-amikom.png')));
@endphp

<!-- ===== KOP SURAT (HEADER) ===== -->
<div class="letter-header">
    <img src="{{ $logo }}" class="logo-header" alt="Logo Universitas AMIKOM Yogyakarta">
    <div class="divider"></div>
    <div class="prodi-text">
        <b>PROGRAM DOKTORAL:</b> Informatika<br>
        <b>PROGRAM MAGISTER :</b> Informatika, PJJ Informatika<br>
        <b>PROGRAM SARJANA :</b> Informatika&nbsp; (Teknik Informatika), Sistem Informasi, Teknologi Informasi (Animasi), Teknik Komputer (Rekayasa Komputer), Arsitektur, Perencanaan Wilayah dan Kota, Geografi, Kewirausahaan,&nbsp; Ekonomi,&nbsp; Akuntansi,&nbsp; Ilmu Pemerintahan, Ilmu Komunikasi, Hubungan Internasional<br>
        <b>PROGRAM DIPLOMA III</b>: Teknik Informatika, Manajemen Informatika
    </div>
</div>
