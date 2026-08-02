@php
    // Default mock data matching files in resources/views/letter
    $letterTypes = $letterTypes ?? [
        [
            'id' => 1,
            'name' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
            'file' => 'surat_persetujuan_non_reguler_ahmad_doni.html',
            'roles' => [
                ['name' => 'Kaprodi', 'class' => 'role-kaprodi', 'style' => 'background-color: rgb(65, 0, 99); color: rgb(255, 255, 255); width: fit-content;'],
                ['name' => 'Dosen Wali', 'class' => 'role-dosen-wali', 'style' => 'background-color: rgb(245, 158, 11); color: rgb(255, 255, 255); width: fit-content;'],
            ],
            'status' => 'Aktif',
        ],
        [
            'id' => 2,
            'name' => 'Surat Rekomendasi Magang',
            'file' => 'surat_rekomendasi_magang - table.html',
            'roles' => [
                ['name' => 'Kaprodi', 'class' => 'role-kaprodi', 'style' => 'background-color: rgb(65, 0, 99); color: rgb(255, 255, 255); width: fit-content;'],
                ['name' => 'Dosen Pembimbing', 'class' => 'role-dosen-pembimbing', 'style' => 'background-color: rgb(0, 107, 94); color: rgb(255, 255, 255); width: fit-content;'],
            ],
            'status' => 'Aktif',
        ],
        [
            'id' => 3,
            'name' => 'Surat Rekomendasi Pendaftaran Pendadaran',
            'file' => 'surat_rekomendasi_pendadaran_taradiva.html',
            'roles' => [
                ['name' => 'Kaprodi', 'class' => 'role-kaprodi', 'style' => 'background-color: rgb(65, 0, 99); color: rgb(255, 255, 255); width: fit-content;'],
                ['name' => 'Dosen Wali', 'class' => 'role-dosen-wali', 'style' => 'background-color: rgb(245, 158, 11); color: rgb(255, 255, 255); width: fit-content;'],
            ],
            'status' => 'Aktif',
        ],
    ];
@endphp

@extends('layouts.admin')

@section('title', 'Daftar Tipe Surat - Layanan Dokumen')



@section('content')
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 font-headline-lg m-0">Daftar Tipe Surat &amp; Peran Persetujuan</h1>
            <p class="text-sm text-gray-600 mt-2 font-body-sm">Konfigurasi jenis dokumen dan alur persetujuan administratif.</p>
        </div>
        <button class="bg-amikom-purple text-white px-6 py-2.5 rounded-lg shadow-sm hover:opacity-90 active:scale-95 transition-all text-sm font-label-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Tipe Surat
        </button>
    </div>

    <!-- Letter Types Data Table Component -->
    <x-admin.letter-types-table :types="$letterTypes" />
@endsection
