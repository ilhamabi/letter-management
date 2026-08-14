@props([
    'id' => 'placeholder-guide-modal',
])

@php
    $placeholderService = app(\App\Services\PlaceholderProviderService::class);
    $groupedPlaceholders = $placeholderService->getGroupedPlaceholders();
@endphp

<x-modal :id="$id" title="Panduan Variabel Placeholder Surat" maxWidth="max-w-3xl" zIndex="z-[110]">
    <div class="space-y-6" x-data="{ copiedKey: null }">
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 flex items-start gap-3">
            <x-icon name="info" class="w-5 h-5 text-amikom-purple shrink-0 mt-0.5" />
            <div class="text-xs text-purple-900 space-y-1 font-body-sm">
                <p class="font-bold font-label-md">Petunjuk Penggunaan & Format Template:</p>
                <p>1. <strong>Kop Surat (Header)</strong>, <strong>Footer (Sertifikasi ISO/Colorbar)</strong>, dan <strong>Blok Tanda Tangan (QR Code & Pejabat)</strong> di-render secara <em>otomatis</em> oleh sistem komponen dokumen.</p>
                <p>2. Anda hanya perlu menyusun <strong>Isi Utama Surat (Body Content)</strong> pada editor di atas tanpa perlu menuliskan penutup tanda tangan manual.</p>
                <p>3. Placeholder dapat disisipkan langsung dari dropdown toolbar editor atau menekan tombol <strong>Salin</strong> di bawah.</p>
            </div>
        </div>

        @foreach($groupedPlaceholders as $group)
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider font-label-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amikom-purple inline-block"></span>
                    <span>{{ $group['group'] }}</span>
                </h4>

                <div class="border border-gray-200 rounded-xl overflow-hidden shadow-2xs">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-600 uppercase tracking-wider font-label-sm">
                                <th class="py-2.5 px-4">Placeholder</th>
                                <th class="py-2.5 px-4">Keterangan</th>
                                <th class="py-2.5 px-4">Contoh Output</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-xs font-body-sm">
                            @foreach($group['items'] as $item)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="py-3 px-4 font-mono font-bold text-amikom-purple">
                                        {{ $item['key'] }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-800 font-medium">
                                        {{ $item['label'] }}
                                        <p class="text-[11px] text-gray-500 font-normal mt-0.5">{{ $item['description'] }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600 italic">
                                        "{{ $item['sample'] }}"
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <button 
                                            type="button"
                                            @click="
                                                navigator.clipboard.writeText('{{ $item['key'] }}');
                                                copiedKey = '{{ $item['key'] }}';
                                                setTimeout(() => copiedKey = null, 2000);
                                            "
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 hover:bg-amikom-purple hover:text-white rounded-lg text-gray-700 font-semibold text-[11px] transition-all font-label-sm">
                                            <template x-if="copiedKey === '{{ $item['key'] }}'">
                                                <span class="text-emerald-600 font-bold flex items-center gap-1">
                                                    <x-icon name="check" class="w-3.5 h-3.5" /> Tersalin!
                                                </span>
                                            </template>
                                            <template x-if="copiedKey !== '{{ $item['key'] }}'">
                                                <span class="flex items-center gap-1">
                                                    <x-icon name="content_copy" class="w-3.5 h-3.5" /> Salin
                                                </span>
                                            </template>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    <x-slot:footer>
        <button class="px-6 py-2 rounded-lg text-sm font-bold bg-gray-800 text-white hover:bg-gray-900 transition-colors font-label-md" onclick="closeModal('{{ $id }}')" type="button">
            Tutup Panduan
        </button>
    </x-slot:footer>
</x-modal>
