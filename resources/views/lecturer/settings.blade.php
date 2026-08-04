@php
    // Default / Mock data so the settings page works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
    $lecturerPhoto = $lecturerPhoto ?? 'https://i1.pickpik.com/photos/206/134/327/teacher-lecturer-writer-counselor-626ababd87ee30e9c0eb278ac724ee0a.jpg';
    $roles = $roles ?? [
        ['name' => 'Kaprodi', 'bg' => 'bg-primary'],
        ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
        ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
    ];
@endphp

@extends('layouts.lecturer')

@section('title', 'Pengaturan Akun - Universitas Amikom')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 m-0">Pengaturan Akun</h2>
            <p class="text-gray-600 text-sm mt-1">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>
    
    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <x-settings.profile-card 
                :name="$lecturerName" 
                subtext="Dosen Universitas Amikom" 
                :photo="$lecturerPhoto" 
            />
        </div>

        <!-- Right Column: Personal Info & Security -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900">Informasi Pribadi</h4>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500">Nama Lengkap</label>
                        <p class="text-sm font-semibold text-gray-900 py-2">{{ $lecturerName }}</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500">NIDN</label>
                        <p class="text-sm font-semibold text-gray-900 py-2">{{ $nidn }}</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500">Alamat Email</label>
                        <p class="text-sm font-semibold text-gray-900 py-2">heri.setyawan@amikom.ac.id</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500">Peran Akademik</label>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($roles as $role)
                                <span class="text-[10px] font-semibold text-white tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Card -->
            <x-settings.security-card />
        </div>
    </div>
</div>
@endsection
