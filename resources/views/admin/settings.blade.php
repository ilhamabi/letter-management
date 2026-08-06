@extends('layouts.admin')

@section('title', 'Pengaturan Akun - Layanan Dokumen')

@php
    $adminName = auth()->check() ? auth()->user()->name : 'User';
    $adminEmail = auth()->check() ? auth()->user()->email : '-';
    $adminPhoto = null;
@endphp

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 m-0 font-headline-md">Pengaturan Akun</h2>
            <p class="text-sm text-gray-600 mt-1 font-body-sm">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <x-settings.profile-card 
                :name="$adminName" 
                subtext="Administrator" 
                :photo="$adminPhoto" 
            />
        </div>

        <!-- Right Column: Personal Info & Security -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900 font-title-lg">Informasi Pribadi</h4>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 font-label-sm">Nama Lengkap</label>
                            <p class="text-sm font-semibold text-gray-900 py-2 font-body-sm">{{ $adminName }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 font-label-sm">Alamat Email</label>
                        <p class="text-sm font-semibold text-gray-900 py-2 font-body-sm">{{ $adminEmail }}</p>
                    </div>
                </form>
            </div>

            <!-- Security Card -->
            <x-settings.security-card />
        </div>
    </div>
@endsection
