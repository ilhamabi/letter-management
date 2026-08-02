@php
    // Default / Mock data in case variables aren't passed from controller
    $templateName = $templateName ?? 'Surat Keterangan Aktif';
    $templateStatus = $templateStatus ?? 'Aktif';
    $templateBanner = $templateBanner ?? 'Surat Keterangan Mahasiswa Aktif';
    $approvalWorkflow = $approvalWorkflow ?? [
        ['number' => 1, 'role' => 'Dosen Wali'],
        ['number' => 2, 'role' => 'Kaprodi'],
    ];
@endphp

@extends('layouts.admin')

@section('title', 'Edit Template Surat - Layanan Dokumen')



@section('content')
    <!-- Page Navigation Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.letters') }}" class="flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-200/60 text-gray-500 hover:text-amikom-purple transition-colors">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-amikom-purple m-0">Edit Template Surat</h1>
                <p class="text-xs text-gray-500 m-0">Konfigurasi dan sesuaikan format template surat resmi</p>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Status Banner -->
        <div class="w-full bg-amikom-purple text-white p-4 rounded-xl flex items-center gap-3 text-sm font-medium shadow-sm">
            <span class="material-symbols-outlined">info</span>
            <span>Mengedit template: {{ $templateBanner }}</span>
        </div>

        <form class="space-y-8" onsubmit="event.preventDefault();">
            @csrf
            
            <!-- Component 1: Informasi Dasar -->
            <x-admin.letter-basic-info-card :name="$templateName" :status="$templateStatus" />

            <!-- Component 2: Alur Persetujuan -->
            <x-admin.approval-workflow-card :steps="$approvalWorkflow" modalId="add-role-modal" />

            <!-- Component 3: Konfigurasi Template Isi Surat (TinyMCE) -->
            <x-admin.letter-content-editor-card editorId="letter-template-editor" selectId="placeholder-select" />

            <!-- Component 4: Action Bar (Hapus, Batal, Simpan) -->
            <x-admin.letter-editor-actions deleteModalId="delete-confirmation-modal" backRoute="admin.letters" />
        </form>
    </div>

    <!-- Modals -->
    <x-admin.change-workflow-modal id="add-role-modal" />
    <x-admin.delete-template-modal id="delete-confirmation-modal" />
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
