@extends('layouts.admin')

@section('title', 'Daftar Jenis Surat & Alur Persetujuan - Layanan Dokumen')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 font-headline-lg m-0">Daftar Jenis Surat &amp; Alur Persetujuan</h1>
            <p class="text-sm text-gray-600 mt-2 font-body-sm">Konfigurasi jenis dokumen dan alur persetujuan administratif.</p>
        </div>
        <a class="px-4 py-2.5 bg-amikom-purple text-white rounded-lg text-sm font-bold hover:bg-opacity-90 transition-all shadow-sm inline-flex items-center gap-2 font-label-md" href="{{ route('admin.letters.create') }}">
            <x-icon name="add" class="w-5 h-5" />
            <span>Buat Jenis Surat Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <x-icon name="check_circle" class="w-5 h-5 text-emerald-600" />
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-base">&times;</button>
        </div>
    @endif

    <!-- Letter Types Data Table Component -->
    <x-admin.letter-types-table :types="$letterTypes" />
@endsection
