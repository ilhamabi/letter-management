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
        <p class="text-sm font-medium text-on-surface-variant mb-0.5">{{ $title }}</p>
        <p class="text-3xl font-bold tracking-tight text-deep-black">{{ $value }}</p>
    </div>
</div>
