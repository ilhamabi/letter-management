@props([
    'id' => 'delete-confirmation-modal',
])

<x-modal :id="$id" :showHeader="false" maxWidth="max-w-md" zIndex="z-[100]">
    <div class="text-center py-2">
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-icon name="warning" class="w-8 h-8 text-red-600" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2 font-title-lg">Hapus Template Surat?</h3>
        <p class="text-sm text-gray-500 leading-relaxed m-0 font-body-sm">Tindakan ini tidak dapat dibatalkan. Mahasiswa tidak akan bisa lagi mengajukan surat menggunakan template ini.</p>
    </div>

    <x-slot:footer>
        <div class="flex justify-center gap-3 w-full">
            <button class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 font-label-md" onclick="closeModal('{{ $id }}')" type="button">Batal</button>
            <button class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold bg-red-600 text-white hover:opacity-90 active:scale-95 transition-all shadow-md font-label-md" type="button">Ya, Hapus</button>
        </div>
    </x-slot:footer>
</x-modal>
