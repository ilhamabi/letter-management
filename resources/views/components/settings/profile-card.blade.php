@props([
    'name' => '',
    'subtext' => '',
    'photo' => '',
    'badge' => null,
    'roleBadges' => [],
])

<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col items-center text-center gap-4 shadow-sm">
    <div class="mb-1">
        <img class="w-32 h-32 rounded-xl object-cover border border-gray-200 shadow-sm" src="{{ $photo }}" alt="{{ $name }}">
    </div>
    <div class="flex flex-col items-center gap-1">
        <h4 class="text-lg font-bold text-gray-900 font-title-lg">{{ $name }}</h4>
        @if ($subtext)
            <p class="text-sm text-gray-500 font-body-sm mt-0.5">{{ $subtext }}</p>
        @endif
        @if ($badge)
            <div class="bg-secondary-container text-on-secondary-container px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider inline-block mt-2">
                {{ $badge }}
            </div>
        @endif
        @if (!empty($roleBadges))
            <div class="flex flex-wrap justify-center gap-1.5 mt-2">
                @foreach ($roleBadges as $rb)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold text-white {{ $rb['bg'] ?? 'bg-primary' }}">
                        {{ $rb['name'] }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>
