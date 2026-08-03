@props([
    'deleteModalId' => 'delete-confirmation-modal',
    'backRoute' => 'admin.letters',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-4 flex justify-end gap-3 shadow-sm items-center']) }}>
    <button class="mr-auto px-6 py-2.5 rounded-lg text-sm font-bold text-red-600 border border-red-600 hover:bg-red-50 transition-colors flex items-center gap-2" onclick="document.getElementById('{{ $deleteModalId }}').classList.remove('hidden')" type="button">
        <x-icon name="delete" class="w-5 h-5" />
        Hapus Template
    </button>
    <a href="{{ route($backRoute) }}" class="px-8 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 flex items-center justify-center decoration-0">
        Batal
    </a>
    <button class="px-8 py-2.5 rounded-lg text-sm font-bold bg-amikom-purple text-white hover:opacity-90 active:scale-95 transition-all shadow-md" type="submit">
        Simpan Template
    </button>
</div>
