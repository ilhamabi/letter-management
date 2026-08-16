@props([
    'type' => 'success',
    'message' => '',
])

@php
    $schemes = [
        'success' => [
            'bg'     => 'bg-notification-success-bg',
            'border' => 'border-notification-success-border',
            'text'   => 'text-notification-success-text',
            'icon'   => 'check_circle'
        ],
        'error' => [
            'bg'     => 'bg-notification-error-bg',
            'border' => 'border-notification-error-border',
            'text'   => 'text-notification-error-text',
            'icon'   => 'cancel'
        ],
        'warning' => [
            'bg'     => 'bg-notification-warning-bg',
            'border' => 'border-notification-warning-border',
            'text'   => 'text-notification-warning-text',
            'icon'   => 'warning'
        ],
        'info' => [
            'bg'     => 'bg-notification-info-bg',
            'border' => 'border-notification-info-border',
            'text'   => 'text-notification-info-text',
            'icon'   => 'info'
        ],
    ][$type] ?? [
        'bg'     => 'bg-notification-success-bg',
        'border' => 'border-notification-success-border',
        'text'   => 'text-notification-success-text',
        'icon'   => 'check_circle'
    ];
@endphp

<div x-data="{ show: true, init() { setTimeout(() => { this.show = false; }, 4000); } }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-[-10px] scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-[-10px] scale-95"
     class="fixed top-6 right-6 z-[100] border {{ $schemes['border'] }} {{ $schemes['bg'] }} {{ $schemes['text'] }} rounded-xl shadow-lg px-4 py-3 flex items-center gap-3 min-w-[300px]"
     style="max-width: 90vw;">
    
    <x-icon :name="$schemes['icon']" class="w-5 h-5 shrink-0" />
    
    <span class="text-sm font-medium">{{ $message }}</span>
    
    <button @click="show = false" type="button" class="ml-auto opacity-70 hover:opacity-100 transition-opacity">
        <x-icon name="close" class="w-5 h-5" />
    </button>
</div>
