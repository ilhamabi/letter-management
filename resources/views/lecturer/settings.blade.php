@php
    // Default / Mock data so the settings page works out of the box even without controller variables
    $lecturerName = $lecturerName ?? 'Heri Setyawan, M.Kom.';
    $nidn = $nidn ?? '123456789';
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
            <h2 class="text-2xl font-bold text-gray-900 m-0 font-headline-md">Pengaturan Akun</h2>
            <p class="text-gray-600 mt-2 font-body-md">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>
    
    <!-- Settings Grid (Restructured to match SCREEN_119) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
                <div class="relative group cursor-pointer">
                    <img alt="{{ $lecturerName }}" class="w-32 h-32 rounded-xl object-cover border border-gray-200 shadow-sm" src="https://lh3.googleusercontent.com/aida/AP1WRLtbZi7_O5yCa33qPpomRGUvdxOhNGHeX4tBG3fVhw7eoDjoUTK1UHlsS26Sz4eKDZYaXRn18sDVQhcl1wsvwfOAwbgkgutKSUZMS2I_Y4yZTwtDiIV0bsawBh1E3Qjm8ppnttz114l_C-u64-rlU63z5BYSPaterX5RfVszRTaRRKll9FTzei8JcbG2Tf0QlQabkaQJaspl7jHqIwa3z8digSlnofpvdT8EVSOVx8hAgNdbo4uPL2USoHk">
                    <div class="absolute inset-0 bg-gray-900/50 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-white">photo_camera</span>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900 font-headline-md">{{ $lecturerName }}</h4>
                    <p class="text-sm text-gray-500 font-body-sm">Dosen Universitas Amikom</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Personal Info & Security -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900 font-headline-md">Informasi Pribadi</h4>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700 font-label-lg">Nama Lengkap</label>
                        <p class="text-sm font-semibold text-gray-900 py-2 font-body-md">{{ $lecturerName }}</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700 font-label-lg">NIDN</label>
                        <p class="text-sm font-semibold text-gray-900 py-2 font-body-md">{{ $nidn }}</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700 font-label-lg">Alamat Email</label>
                        <p class="text-sm font-semibold text-gray-900 py-2 font-body-md">heri.setyawan@amikom.ac.id</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700 font-label-lg">Peran Akademik</label>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($roles as $role)
                                <span class="text-[10px] font-semibold text-white tracking-wider px-2.5 py-1 rounded-full {{ $role['bg'] }}">{{ $role['name'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm" data-purpose="security-settings">
                <div class="border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900 font-headline-md">Keamanan Akun</h4>
                    <p class="text-sm text-gray-500 mt-1 font-body-sm">Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter .</p>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700 font-label-lg" for="current-password">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="current-password" placeholder="••••••••" type="password">
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm cursor-pointer hover:text-primary transition-colors" onclick="const input = this.previousElementSibling; if (input.type === 'password') { input.type = 'text'; this.textContent = 'visibility'; } else { input.type = 'password'; this.textContent = 'visibility_off'; }">visibility_off</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700 font-label-lg" for="new-password">Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="new-password" placeholder="••••••••" type="password">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700 font-label-lg" for="confirm-password">Konfirmasi Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm" id="confirm-password" placeholder="••••••••" type="password">
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button class="px-6 py-2.5 bg-primary text-white rounded-md text-sm font-medium hover:opacity-90 transition-colors shadow-sm font-label-lg" type="button">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
