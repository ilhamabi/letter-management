@props([
    'id' => 'delete-confirmation-modal',
    'letterType' => null,
])

@php
    $isActive = $letterType ? (bool) $letterType->is_active : true;
    $submissionsCount = 0;
    $hasSubmissions = false;
    
    if ($letterType) {
        $submissionsCount = isset($letterType->submissions_count) 
            ? $letterType->submissions_count 
            : $letterType->submissions()->count();
        $hasSubmissions = $submissionsCount > 0;
    }
    
    if (!$isActive) {
        $mode = 'activate';
    } elseif ($hasSubmissions) {
        $mode = 'deactivate';
    } else {
        $mode = 'delete';
    }
@endphp

<x-modal :id="$id" :showHeader="false" maxWidth="max-w-md" zIndex="z-[100]">
    <div class="text-center py-2">
        <div id="{{ $id }}-icon-container" class="w-16 h-16 {{ $mode === 'activate' ? 'bg-emerald-50 border-emerald-100' : ($mode === 'deactivate' ? 'bg-amber-50 border-amber-100' : 'bg-red-50 border-red-100') }} rounded-full flex items-center justify-center mx-auto mb-4 border">
            <x-icon id="{{ $id }}-icon-emerald" name="check_circle" class="w-8 h-8 text-emerald-600 {{ $mode === 'activate' ? '' : 'hidden' }}" />
            <x-icon id="{{ $id }}-icon-amber" name="warning" class="w-8 h-8 text-amber-600 {{ $mode === 'deactivate' ? '' : 'hidden' }}" />
            <x-icon id="{{ $id }}-icon-red" name="delete_forever" class="w-8 h-8 text-red-600 {{ $mode === 'delete' ? '' : 'hidden' }}" />
        </div>
        
        <h3 id="{{ $id }}-title" class="text-xl font-bold text-gray-900 mb-2 font-title-lg">
            @if($mode === 'activate')
                Aktifkan Jenis Surat?
            @elseif($mode === 'deactivate')
                Nonaktifkan Jenis Surat?
            @else
                Hapus Jenis Surat?
            @endif
        </h3>
        
        <p id="{{ $id }}-description" class="text-sm text-gray-600 leading-relaxed m-0 font-body-sm">
            @if($mode === 'activate')
                Jenis Surat ini akan diaktifkan kembali sehingga mahasiswa dapat melihat dan mengajukan surat jenis ini.
            @elseif($mode === 'deactivate')
                Jenis Surat ini sudah memiliki {{ $submissionsCount }} riwayat pengajuan. Jenis surat tidak dapat dihapus permanen agar data pengajuan tetap tersimpan, namun statusnya akan diubah menjadi <span class="font-bold text-amber-700">Nonaktif</span>.
            @else
                Tindakan ini tidak dapat dibatalkan. Data jenis surat akan dihapus secara permanen dari sistem.
            @endif
        </p>
    </div>

    <x-slot:footer>
        @php
            $actionUrl = '#';
            $method = 'DELETE';
            if ($letterType) {
                if ($mode === 'activate') {
                    $actionUrl = route('admin.letters.toggle-status', $letterType->id);
                    $method = 'PATCH';
                } else {
                    $actionUrl = route('admin.letters.destroy', $letterType->id);
                    $method = 'DELETE';
                }
            }
        @endphp
        <form id="{{ $id }}-form" action="{{ $actionUrl }}" method="POST" class="flex justify-center gap-3 w-full">
            @csrf
            @method($method)
            <button class="flex-1 px-6 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 font-label-md" onclick="closeModal('{{ $id }}')" type="button">
                Batal
            </button>
            <button id="{{ $id }}-submit-btn" class="flex-1 px-6 py-2.5 rounded-lg text-sm font-bold text-white transition-all shadow-md font-label-md {{ $mode === 'activate' ? 'bg-emerald-600 hover:bg-emerald-700' : ($mode === 'deactivate' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-red-600 hover:bg-red-700') }}" type="submit">
                @if($mode === 'activate')
                    Ya, Aktifkan
                @elseif($mode === 'deactivate')
                    Ya, Nonaktifkan
                @else
                    Ya, Hapus
                @endif
            </button>
        </form>
    </x-slot:footer>
</x-modal>
