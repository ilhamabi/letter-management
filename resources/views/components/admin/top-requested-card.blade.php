@props([
    'items' => [],
    'title' => 'Paling Sering Diajukan',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm relative overflow-hidden']) }}>
    <!-- Decorative background element -->
    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amikom-purple-light opacity-50 rounded-full blur-2xl"></div>
    <h3 class="text-lg font-bold text-gray-900 mb-6 relative z-10 m-0">{{ $title }}</h3>
    <div class="flex flex-col gap-4 relative z-10">
        @forelse ($items as $item)
            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $item['rank_bg'] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $item['rank'] ?? $loop->iteration }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate" title="{{ $item['name'] }}">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $item['count'] }}</p>
                    </div>
                </div>
                <div class="h-1.5 w-16 bg-gray-100 rounded-full overflow-hidden shrink-0 ml-3">
                    <div class="h-full {{ $item['color'] ?? 'bg-amikom-purple' }}" style="width: {{ $item['percentage'] ?? 50 }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-xs text-gray-500 text-center py-4">Belum ada data pengajuan.</p>
        @endforelse
    </div>
</div>
