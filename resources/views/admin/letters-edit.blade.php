@php
    $letter = $letter ?? [
        'name' => 'Jenis Surat Baru',
        'status' => 'Aktif',
        'updated_at' => '-',
        'banner' => '',
        'workflow' => [],
    ];
    $templateName = $templateName ?? $letter['name'];
    $templateStatus = $templateStatus ?? $letter['status'];
    $templateBanner = $templateBanner ?? $letter['banner'];
    $approvalWorkflow = $approvalWorkflow ?? $letter['workflow'];
@endphp

@extends('layouts.admin')

@section('title', 'Edit Template Surat - Layanan Dokumen')

@section('content')
    <!-- Page Navigation Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.letters') }}" class="p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors" title="Kembali ke Daftar Surat">
                <x-icon name="arrow_back" class="w-5 h-5" />
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900 font-headline-lg m-0">{{ $letter['name'] }}</h1>
                    <x-status-badge :status="$letter['status']" size="sm" />
                </div>
                <p class="text-sm text-gray-600 mt-1 font-body-sm">Diedit terakhir: {{ $letter['updated_at'] }}</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2 mb-6">
            <x-icon name="info" class="w-5 h-5" />
            <div>
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Status Banner -->
        <div class="w-full bg-amikom-purple text-white p-4 rounded-xl flex items-center gap-3 text-sm font-medium shadow-sm">
            <x-icon name="info" class="w-5 h-5" />
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
