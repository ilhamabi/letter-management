@php
    $letterTypes = $letterTypes ?? [];
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
            <a class="px-4 py-2 bg-[#410063] text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition-all shadow-sm inline-flex items-center gap-2" href="{{ route('admin.letters.create') }}">
                <x-icon name="add" class="w-5 h-5" />
                <span>Buat Jenis Surat Baru</span>
            </a>
    </div>

    <!-- Letter Types Data Table Component -->
    <x-admin.letter-types-table :types="$letterTypes" />
@endsection
