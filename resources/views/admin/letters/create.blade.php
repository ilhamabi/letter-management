@extends('layouts.admin')

@section('title', 'Buat Jenis Surat Baru - Layanan Dokumen')

@section('content')
    <!-- Page Navigation Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.letters.index') }}" class="p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors" title="Kembali ke Daftar Jenis Surat">
                <x-icon name="arrow_back" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 font-headline-lg m-0">Buat Jenis Surat Baru</h1>
                <p class="text-sm text-gray-600 mt-1 font-body-sm">Konfigurasi informasi dasar jenis surat, alur persetujuan, dan template isi dokumen.</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-xl flex items-start gap-3 mb-6 shadow-xs">
            <x-icon name="error_outline" class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
            <div class="space-y-1">
                <p class="font-bold text-sm font-label-md">Gagal menyimpan jenis surat. Mohon periksa inputan berikut:</p>
                <ul class="list-disc list-inside text-xs space-y-0.5 font-body-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Informasi Dasar Jenis Surat -->
            <section class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-amikom-purple"></div>
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 m-0 font-title-lg">Informasi Dasar</h3>
                    <p class="text-xs text-gray-500 mt-0.5 font-body-sm">Isi nama, kode acuan, deskripsi, dan status keaktifan jenis surat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Jenis Surat -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label for="name" class="block text-xs font-bold uppercase text-gray-700 font-label-sm">
                            Nama Jenis Surat <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Contoh: Surat Keterangan Aktif Kuliah" 
                            required 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-amikom-purple focus:border-amikom-purple focus:bg-white transition-all font-body-sm">
                    </div>

                    <!-- Kode Surat -->
                    <div class="space-y-1.5">
                        <label for="code" class="block text-xs font-bold uppercase text-gray-700 font-label-sm">
                            Kode Surat <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code') }}" 
                            placeholder="Contoh: SKA" 
                            required 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-900 uppercase font-mono font-bold focus:ring-2 focus:ring-amikom-purple focus:border-amikom-purple focus:bg-white transition-all">
                        <p class="text-[11px] text-gray-500 font-body-sm">Singkatan unik untuk kode pengarsipan dokumen.</p>
                    </div>

                    <!-- Status Keaktifan -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase text-gray-700 font-label-sm">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-4 pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="text-amikom-purple focus:ring-amikom-purple">
                                <span class="text-sm font-semibold text-gray-800 font-body-sm">Aktif</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="radio" name="is_active" value="0" {{ old('is_active') == '0' ? 'checked' : '' }} class="text-amikom-purple focus:ring-amikom-purple">
                                <span class="text-sm font-semibold text-gray-600 font-body-sm">Tidak Aktif</span>
                            </label>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-1.5 md:col-span-2">
                        <label for="description" class="block text-xs font-bold uppercase text-gray-700 font-label-sm">Deskripsi Jenis Surat</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="3" 
                            placeholder="Jelaskan peruntukan dan tujuan penerbitan jenis surat ini..." 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-amikom-purple focus:border-amikom-purple focus:bg-white transition-all font-body-sm">{{ old('description') }}</textarea>
                    </div>
                </div>
            </section>

            <!-- Section 2: Syarat & Opsi Pengajuan -->
            <section class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm overflow-hidden relative">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 m-0 font-title-lg">Syarat &amp; Opsi Pengajuan</h3>
                    <p class="text-xs text-gray-500 mt-0.5 font-body-sm">Atur kriteria kelayakan akademik dan ketentuan lampiran berkas.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Minimal IPK -->
                    <div class="space-y-1.5">
                        <label for="minimum_gpa" class="block text-xs font-bold uppercase text-gray-700 font-label-sm">Minimal IPK</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0" 
                            max="4.00" 
                            id="minimum_gpa" 
                            name="minimum_gpa" 
                            value="{{ old('minimum_gpa') }}" 
                            placeholder="Contoh: 2.75 (Biarkan kosong jika tanpa syarat)" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-amikom-purple focus:border-amikom-purple focus:bg-white transition-all font-body-sm">
                    </div>

                    <!-- Minimal SKS -->
                    <div class="space-y-1.5">
                        <label for="minimum_credits" class="block text-xs font-bold uppercase text-gray-700 font-label-sm">Minimal Total SKS</label>
                        <input 
                            type="number" 
                            min="0" 
                            id="minimum_credits" 
                            name="minimum_credits" 
                            value="{{ old('minimum_credits') }}" 
                            placeholder="Contoh: 80 (Biarkan kosong jika tanpa syarat)" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-amikom-purple focus:border-amikom-purple focus:bg-white transition-all font-body-sm">
                    </div>

                    <!-- Checkbox Controls -->
                    <div class="md:col-span-2 space-y-3 pt-2">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100/80 transition-colors select-none">
                            <input type="checkbox" name="requires_attachment" value="1" {{ old('requires_attachment') ? 'checked' : '' }} class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple w-4 h-4">
                            <div>
                                <p class="text-sm font-bold text-gray-900 font-label-md">Wajib Mengunggah Lampiran Berkas</p>
                                <p class="text-xs text-gray-500 font-body-sm">Mahasiswa wajib mengunggah file pdf/gambar pendukung saat membuat pengajuan.</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-100/80 transition-colors select-none">
                            <input type="checkbox" name="allow_group_submission" value="1" {{ old('allow_group_submission') ? 'checked' : '' }} class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple w-4 h-4">
                            <div>
                                <p class="text-sm font-bold text-gray-900 font-label-md">Dapat Diajukan Secara Berkelompok / Tim</p>
                                <p class="text-xs text-gray-500 font-body-sm">Mengizinkan pemohon menambahkan anggota mahasiswa lain dalam satu pengajuan surat.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Section 3: Alur Persetujuan (Approval Flow from DB) -->
            <x-admin.approval-workflow-card :flows="$approvalFlows" modalId="change-workflow-modal" />

            <!-- Section 4: Konfigurasi Template Isi Surat (TinyMCE Rich Text Editor) -->
            <x-admin.letter-content-editor-card editorId="letter-template-editor" selectId="placeholder-select" guideModalId="placeholder-guide-modal" />

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.letters.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 border border-gray-300 transition-all font-label-md">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amikom-purple text-white text-sm font-bold rounded-lg hover:opacity-90 active:scale-95 transition-all shadow-md font-label-md inline-flex items-center gap-2">
                    <x-icon name="check_circle" class="w-5 h-5" />
                    <span>Simpan Jenis Surat</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Modals -->
    <x-admin.change-workflow-modal id="change-workflow-modal" :flows="$approvalFlows" />
    <x-admin.placeholder-guide-modal id="placeholder-guide-modal" />
@endsection

@push('scripts')
    <!-- TinyMCE 6 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.initLetterEditor === 'function') {
                window.initLetterEditor('#letter-template-editor', '#placeholder-select');
            }
        });
    </script>
@endpush
