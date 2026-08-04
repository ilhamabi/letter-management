@extends('layouts.student')

@section('title', 'Pengaturan Akun - Layanan Dokumen')

@php
    // Default / Mock data so the settings page works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'D3 Teknik Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
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
                        <p class="text-sm text-on-surface font-semibold py-2">{{ strtolower(str_replace(' ', '.', $studentName)) }}@students.amikom.ac.id</p>
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
