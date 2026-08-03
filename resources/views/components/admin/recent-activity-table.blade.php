@props([
    'activities' => [],
    'title' => 'Aktivitas Terbaru',
    'actionText' => 'Lihat Semua',
    'actionUrl' => '#',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm']) }}>
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-[#F8F9FA]">
        <h3 class="text-lg font-bold text-gray-900 m-0 font-title-lg">{{ $title }}</h3>
        @if($actionText)
            <a href="{{ $actionUrl }}" class="text-sm font-medium text-amikom-purple hover:underline font-label-md">{{ $actionText }}</a>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-[#F8F9FA] border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider">Jenis Surat</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 font-label-sm text-xs font-bold uppercase text-gray-500 tracking-wider w-32">Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($activities as $activity)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900 text-sm font-body-sm">{{ $activity['letter_type'] ?? $activity['type'] ?? '' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm whitespace-nowrap font-body-sm">{{ $activity['date'] ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border font-label-sm {{ $activity['badge_class'] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $activity['change'] ?? '' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm font-body-sm">
                            Tidak ada aktivitas terbaru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
