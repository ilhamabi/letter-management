@props([
    'id' => 'delete-confirmation-modal',
    'letterType' => null,
])

<x-modal :id="$id" :showHeader="false" maxWidth="max-w-md" zIndex="z-[100]">
    <div class="text-center py-2">
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
            <x-icon name="warning" class="w-8 h-8 text-red-600" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2 font-title-lg">Hapus Jenis Surat?</h3>
        <p class="text-sm text-gray-500 leading-relaxed m-0 font-body-sm">Tindakan ini tidak dapat dibatalkan. Mahasiswa tidak akan bisa lagi mengajukan surat ini.</p>
    </div>

    <x-slot:footer>
        @if($letterType)
            <form action="{{ route('admin.letters.destroy', $letterType->id) }}" method="POST" class="flex justify-center gap-3 w-full">
                @csrf
                @method('DELETE')
                <button class="flex-1 px-6 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 font-label-md" onclick="closeModal('{{ $id }}')" type="button">Batal</button>
                <button class="flex-1 px-6 py-2.5 rounded-lg text-sm font-bold bg-red-600 text-white hover:bg-red-700 active:scale-95 transition-all shadow-md font-label-md" type="submit">Ya, Hapus</button>
            </form>
        @else
            <div class="flex justify-center gap-3 w-full">
                <button class="flex-1 px-6 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 font-label-md" onclick="closeModal('{{ $id }}')" type="button">Batal</button>
            </div>
        @endif
    </x-slot:footer>
</x-modal>
