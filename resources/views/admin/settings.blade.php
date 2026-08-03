@extends('layouts.admin')

@section('title', 'Pengaturan Akun - Layanan Dokumen')

@php
    $adminName = $adminName ?? (auth()->check() ? auth()->user()->name : 'Admin');
    $adminEmail = $adminEmail ?? (auth()->check() ? auth()->user()->email : 'admin@amikom.ac.id');
    $adminPhoto = $adminPhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMizNsImUsAhQ1K0MobwV_I-xE5GJAje3rmApO43UMzs2HSAmf2BVZXm3AyvXCbW0TyVQiGNpGGQH_7zZhKQzgE-socR3g9BJVABx_IEBfzntAvOyZtgMO_tlj8GVxuL_2qNWxXtDetUKHpaysIf0n3dKfPG1eIM9EYmkaKrSEPDLsi_Yib9xlm8vTGmzkww7ib2CoLQf1OUEl8CMPS6G-eIKzYMC5EPlK5uOkKYOSDPufDRy7TRMg';
@endphp

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 m-0">Pengaturan Akun</h2>
            <p class="text-gray-600 mt-2">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>

    <!-- Settings Grid (Bento-style layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (Profile & Photo) -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <!-- Profile Photo Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
                <div class="relative group cursor-pointer">
                    <img class="w-32 h-32 rounded-xl object-cover border border-gray-200 shadow-sm" src="{{ $adminPhoto }}" alt="{{ $adminName }}">
                    <div class="absolute inset-0 bg-gray-900/50 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <x-icon name="photo_camera" class="w-6 h-6 text-white" />
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">{{ $adminName }}</h4>
                </div>
            </div>
            <!-- System Preferences -->
        </div>

        <!-- Right Column (Forms) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900">Informasi Pribadi</h4>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="text-sm font-semibold text-gray-900 py-2">{{ $adminName }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700">Alamat Email</label>
                        <p class="text-sm font-semibold text-gray-900 py-2">{{ $adminEmail }}</p>
                    </div>
                </form>
            </div>

            <!-- Security Card -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="border-b border-gray-200 pb-4">
                    <h4 class="text-lg font-bold text-gray-900">Keamanan Akun</h4>
                    <p class="text-sm text-gray-500 mt-1">Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter.</p>
                </div>
                <form class="flex flex-col gap-4">
                    @csrf
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-amikom-purple focus:ring-1 focus:ring-amikom-purple text-sm bg-white" id="current-password" type="password" placeholder="••••••••">
                            <span class="toggle-password-icon absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-700 flex items-center">
                                <x-icon name="visibility_off" class="w-4 h-4" />
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-amikom-purple focus:ring-1 focus:ring-amikom-purple text-sm bg-white" id="new-password" type="password">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-amikom-purple focus:ring-1 focus:ring-amikom-purple text-sm bg-white" id="confirm-password" type="password">
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button class="px-6 py-2.5 bg-[#410063] text-white rounded-md text-sm font-medium hover:bg-[#30004b] transition-colors shadow-sm" type="button">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function() {
      const toggleIcons = document.querySelectorAll('.toggle-password-icon');
      const eyeSvg = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
      const eyeOffSvg = `<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;

      toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
          const container = this.closest('.relative');
          const input = container.querySelector('input');
          
          if (input) {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            this.innerHTML = isPassword ? eyeSvg : eyeOffSvg;
          }
        });
      });
    })();
</script>
@endpush
