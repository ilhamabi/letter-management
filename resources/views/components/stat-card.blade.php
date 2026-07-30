@props([
    'icon' => 'folder',
    'iconBg' => 'bg-primary-container',
    'iconColor' => 'text-primary',
    'title' => '',
    'value' => '0',
])

<div {{ $attributes->merge(['class' => 'bg-pure-white p-6 rounded-xl border border-outline-variant flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow']) }}>
    <div class="p-3 rounded-lg {{ $iconBg }} {{ $iconColor }} flex items-center justify-center shrink-0">
        <span class="material-symbols-outlined text-[28px]">{{ $icon }}</span>
    </div>
    <div>
        <p class="font-label-md text-label-md text-on-surface-variant mb-1">{{ $title }}</p>
        <p class="font-display-lg text-display-lg text-deep-black font-bold">{{ $value }}</p>
    </div>
</div>
