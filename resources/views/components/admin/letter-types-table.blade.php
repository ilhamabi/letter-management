@props([
    'types' => [],
])

<section {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#F8F9FA] border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider w-16">No</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider">Nama Jenis Surat</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider">Alur Persetujuan</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider">Status</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider text-right w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($types as $type)
                    @php
                        $id = is_object($type) ? $type->id : ($type['id'] ?? 1);
                        $name = is_object($type) ? $type->name : ($type['name'] ?? '-');
                        $code = is_object($type) ? $type->code : ($type['code'] ?? '');
                        $isActive = is_object($type) ? (bool)$type->is_active : (($type['status'] ?? '') === 'Aktif');

                        // Steps formatting
                        $steps = [];
                        if (is_object($type) && $type->approvalFlow && $type->approvalFlow->steps) {
                            $steps = $type->approvalFlow->steps;
                        }
                    @endphp
                    <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                        <td class="px-6 py-4 font-label-md text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-sm text-gray-900 font-label-md">{{ $name }}</div>
                            @if($code)
                                <div class="inline-block mt-0.5 px-2 py-0.5 bg-purple-50 text-amikom-purple text-[11px] font-bold rounded border border-purple-100 uppercase tracking-wide font-label-sm">
                                    {{ $code }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(count($steps) > 0)
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @foreach($steps as $step)
                                        @php
                                            $roleEnum = is_object($step->approval_role) ? $step->approval_role : null;
                                        @endphp
                                        <x-role-badge :role="$roleEnum ?? $step->approval_role" size="sm" />
                                        @if(!$loop->last)
                                            <x-icon name="arrow_forward" class="w-3.5 h-3.5 text-gray-400 shrink-0" />
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum ada alur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-status-badge :status="\App\Enums\LetterTypeStatus::fromBoolean($isActive)" size="sm" />
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.letters.preview', $id) }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors font-label-sm" title="Preview Cetak Surat A4">
                                    <x-icon name="visibility" class="w-4 h-4 mr-1" />
                                    Preview
                                </a>
                                <a href="{{ route('admin.letters.edit', $id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-amikom-purple hover:bg-purple-50 rounded-lg transition-colors font-label-sm">
                                    <x-icon name="edit" class="w-4 h-4 mr-1" />
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center font-body-sm text-sm text-gray-500">
                            Belum ada data jenis surat. Silakan tambahkan jenis surat baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination Info -->
    <div class="px-6 py-4 border-t border-gray-200 bg-[#F8F9FA] flex justify-between items-center">
        <span class="font-body-sm text-xs text-gray-500">Menampilkan {{ count($types) }} jenis surat</span>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-amikom-purple text-white rounded font-label-lg text-xs font-bold">Total: {{ count($types) }}</span>
        </div>
    </div>
</section>
