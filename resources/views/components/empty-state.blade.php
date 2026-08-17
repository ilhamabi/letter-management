@props([
    'icon',
    'title',
    'subtitle' => null,
    'actionUrl' => null,
    'actionLabel' => null,
    'colspan' => null,
])

@php
    $inner = <<<HTML
    <div class="flex flex-col items-center justify-center py-12 px-6 text-center gap-3">
    HTML;
@endphp

@if($colspan)
    <tr>
        <td colspan="{{ $colspan }}" class="py-4">
@endif

<div class="flex flex-col items-center justify-center py-12 px-6 text-center gap-3">
    <x-icon :name="$icon" class="w-12 h-12 text-gray-300" />
    <div>
        <p class="text-base font-bold text-gray-900">{{ $title }}</p>
        @if($subtitle)
            <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if($actionUrl && $actionLabel)
        <a href="{{ $actionUrl }}"
            class="mt-1 px-4 py-2 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition-colors inline-flex items-center gap-1.5">
            <x-icon name="restart_alt" class="w-4 h-4" />
            <span>{{ $actionLabel }}</span>
        </a>
    @endif
</div>

@if($colspan)
        </td>
    </tr>
@endif
