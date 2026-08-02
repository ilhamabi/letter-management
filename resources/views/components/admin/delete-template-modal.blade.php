@props([
    'id' => 'delete-confirmation-modal',
])

<div class="fixed inset-0 z-[100] hidden" id="{{ $id }}">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden z-10">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-600 text-3xl">warning</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Template Surat?</h3>
                <p class="text-sm text-gray-500 leading-relaxed m-0">Tindakan ini tidak dapat dibatalkan. Mahasiswa tidak akan bisa lagi mengajukan surat menggunakan template ini.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-center gap-3 border-t border-gray-100">
                <button class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" type="button">Batal</button>
                <button class="flex-1 px-6 py-2.5 rounded-md text-sm font-bold bg-red-600 text-white hover:opacity-90 active:scale-95 transition-all shadow-md" type="button">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>
