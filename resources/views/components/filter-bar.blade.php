@props([
    'resetUrl',
    'hasFilters' => false,
    'label' => 'Filter',
])

<div class="flex items-center justify-between border-b border-gray-200/80 pb-3">
    <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
        <x-icon name="filter_list" class="w-5 h-5 text-amikom-purple" />
        <span>{{ $label }}</span>
    </div>
    @if($hasFilters)
        <a href="{{ $resetUrl }}"
            class="text-xs font-semibold text-amikom-purple hover:text-amikom-purple/80 transition-colors flex items-center gap-1 cursor-pointer">
            <x-icon name="restart_alt" class="w-4 h-4" />
            <span>Reset Filter</span>
        </a>
    @else
        <button type="button" onclick="window.location='{{ $resetUrl }}'"
            class="text-xs font-semibold text-gray-500 hover:text-amikom-purple transition-colors flex items-center gap-1 cursor-pointer">
            <x-icon name="restart_alt" class="w-4 h-4 text-gray-400" />
            <span>Reset Filter</span>
        </button>
    @endif
</div>
