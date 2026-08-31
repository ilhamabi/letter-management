@extends('layouts.student')

@section('title', 'Pengaturan Akun - Layanan Dokumen')

@php
    $user = auth()->user();
    $studentName = $user?->name ?? 'User';
    $nim = $user?->student?->student_number ?? $user?->username ?? '-';
    $prodi = $user?->student?->department ?? 'D3 Teknik Informatika';
    $studentEmail = $user?->email ?? '-';
    $profilePhoto = null;
@endphp

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-outline-variant pb-4 gap-4 mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-on-surface m-0">Pengaturan Akun</h2>
            <p class="text-sm md:text-base text-on-surface-variant mt-1">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>
    
    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <x-settings.profile-card 
                :name="$studentName" 
                :subtext="$nim" 
                :photo="$profilePhoto" 
                badge="MAHASISWA"
            />
        </div>
        
        <!-- Right Column: Personal Info & Security -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-outline-variant pb-4">
                    <h4 class="text-lg font-bold text-on-surface">Informasi Pribadi</h4>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Nama Lengkap</label>
                            <p class="text-sm text-on-surface font-semibold py-2">{{ $studentName }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Alamat Email</label>
                        <p class="text-sm text-on-surface font-semibold py-2">{{ $studentEmail }}</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Program Studi</label>
                        <p class="text-sm text-on-surface font-semibold py-2">{{ $prodi }}</p>
                    </div>
                </form>
            </div>
            
            <!-- Security Card -->
            <x-settings.security-card />
        </div>
    </div>
@endsection
