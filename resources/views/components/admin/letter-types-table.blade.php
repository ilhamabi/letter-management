@props([
    'types' => [],
])

<section {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#F8F9FA] border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-label-sm text-xs font-semibold uppercase text-gray-500 tracking-wider w-16">No</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-semibold uppercase text-gray-500 tracking-wider">Tipe Surat</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-semibold uppercase text-gray-500 tracking-wider">Peran yang Diperlukan</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-semibold uppercase text-gray-500 tracking-wider text-right w-64">STATUS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($types as $type)
                    @php
                        $isInactive = ($type['status'] ?? '') === 'Non-Aktif';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-200 group cursor-pointer {{ $isInactive ? 'bg-gray-50' : '' }}" onclick="window.location.href='{{ route('admin.letters.edit') }}'">
                        <td class="px-6 py-4 font-label-md text-sm {{ $isInactive ? 'text-gray-500' : 'text-gray-900' }}">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 {{ $isInactive ? 'opacity-80' : '' }}">
                            <div class="font-label-md text-sm font-semibold text-gray-900">{{ $type['name'] }}</div>
                        </td>
                        <td class="px-6 py-4 {{ $isInactive ? 'opacity-80' : '' }}">
                            <div class="flex flex-wrap gap-2 flex-col items-start">
                                @foreach($type['roles'] as $role)
                                    @if(is_array($role))
                                        <span class="{{ $role['class'] ?? '' }} px-2.5 py-1 rounded-full font-label-sm text-[10px] font-bold tracking-wider flex items-center gap-1 {{ $isInactive ? 'opacity-70' : '' }}" style="{{ $role['style'] ?? 'width: fit-content;' }}">
                                            {{ $role['name'] }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full font-label-sm text-[10px] font-bold tracking-wider flex items-center gap-1 bg-amikom-purple text-white {{ $isInactive ? 'opacity-70' : '' }}" style="width: fit-content;">
                                            {{ $role }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <x-status-badge :status="$type['status'] ?? 'Aktif'" size="sm" class="font-label-sm">
                                <x-icon :name="$isInactive ? 'cancel' : 'check_circle'" class="w-3.5 h-3.5 inline mr-1" />
                                {{ $type['status'] ?? 'Aktif' }}
                            </x-status-badge>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center font-body-sm text-sm text-gray-500">
                            Belum ada data tipe surat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Table Footer / Pagination Placeholder -->
    <div class="px-6 py-4 border-t border-gray-200 bg-[#F8F9FA] flex justify-between items-center">
        <span class="font-body-sm text-xs text-gray-500">Menampilkan {{ count($types) }} dari {{ count($types) }} tipe surat</span>
        <div class="flex gap-2">
            <button class="w-8 h-8 flex items-center justify-center bg-amikom-purple text-white rounded font-label-lg text-xs font-bold">1</button>
            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-600 font-label-lg text-xs hover:bg-gray-100">2</button>
            <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded text-gray-600 font-label-lg text-xs hover:bg-gray-100">3</button>
        </div>
    </div>
</section>
