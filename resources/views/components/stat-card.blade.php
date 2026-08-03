@props([
    'icon' => 'folder',
    'iconBg' => 'bg-blue-50',
    'iconColor' => 'text-blue-600',
    'title' => '',
    'value' => '0',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 p-6 rounded-xl flex items-start justify-between shadow-sm hover:shadow-md transition-shadow']) }}>
    <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $title }}</p>
        <h3 class="text-3xl font-bold text-gray-900 m-0">{{ $value }}</h3>
    </div>
    <div class="w-12 h-12 rounded-full {{ $iconBg }} flex items-center justify-center {{ $iconColor }} shrink-0">
        <x-icon :name="$icon" class="w-6 h-6" />
    </div>
</div>
