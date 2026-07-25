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
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-outline-variant pb-4 gap-4">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface m-0">Pengaturan Akun</h2>
            <p class="font-body-md text-on-surface-variant mt-2">Kelola profil, keamanan, dan preferensi sistem Anda.</p>
        </div>
    </div>
    
    <!-- Settings Grid (Bento-style layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column (Profile & Photo) -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <!-- Profile Photo Card -->
            <div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
                <div class="relative group cursor-pointer mb-2">
                    <img alt="{{ $studentName }} Profile Picture" class="w-32 h-32 rounded-xl object-cover border border-outline-variant shadow-sm" src="{{ $profilePhoto }}">
                    <div class="absolute inset-0 bg-primary/20 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-white">photo_camera</span>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-1">
                    <h4 class="font-title-lg text-title-lg text-on-surface font-bold">{{ $studentName }}</h4>
                    <p class="font-body-sm text-on-surface-variant">{{ $nim }}</p>
                    <div class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full font-label-sm text-xs font-bold uppercase tracking-wider inline-block mt-2">
                        MAHASISWA
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column (Forms) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- Personal Info Card -->
            <div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-outline-variant pb-4">
                    <h4 class="font-title-lg text-title-lg text-on-surface font-bold">Informasi Pribadi</h4>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-sm text-on-surface-variant font-medium">Nama Lengkap</label>
                            <p class="font-body-md text-on-surface font-semibold py-2">{{ $studentName }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-label-sm text-on-surface-variant font-medium">Alamat Email</label>
                        <p class="font-body-md text-on-surface font-semibold py-2">{{ strtolower(str_replace(' ', '.', $studentName)) }}@students.amikom.ac.id</p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-label-sm text-on-surface-variant font-medium">Program Studi</label>
                        <p class="font-body-md text-on-surface font-semibold py-2">{{ $prodi }}</p>
                    </div>
                </form>
            </div>
            
            <!-- Security Card -->
            <div class="bg-pure-white border border-outline-variant rounded-xl p-6 flex flex-col gap-6 shadow-sm">
                <div class="border-b border-outline-variant pb-4">
                    <h4 class="font-title-lg text-title-lg text-on-surface font-bold">Keamanan Akun</h4>
                    <p class="font-body-sm text-on-surface-variant mt-1">Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter .</p>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-label-sm text-on-surface-variant font-medium">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input class="w-full px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password" value="" placeholder="••••••••">
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm cursor-pointer hover:text-on-surface">visibility</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-sm text-on-surface-variant font-medium">Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-sm text-on-surface-variant font-medium">Konfirmasi Kata Sandi Baru</label>
                            <input class="px-3 py-2 border border-outline-variant rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-sm bg-surface-container-lowest" type="password">
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button class="px-6 py-2.5 bg-primary text-white rounded-md font-label-md hover:bg-primary-container transition-colors shadow-sm" type="button">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function() {
      const toggleIcons = document.querySelectorAll('.material-symbols-outlined.absolute.right-3');
      toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
          const container = this.closest('.relative');
          const input = container.querySelector('input');
          
          if (input) {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            this.textContent = isPassword ? 'visibility' : 'visibility_off';
          }
        });
      });
    })();
</script>
@endpush
