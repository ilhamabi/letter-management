@props([
    'type' => 'success',
    'message',
])

@php
    $isSuccess = $type === 'success';
    $containerClass = $isSuccess
        ? 'p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center justify-between shadow-sm animate-fade-in'
        : 'p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center justify-between shadow-sm animate-fade-in';
    $iconName = $isSuccess ? 'check_circle' : 'error';
    $iconClass = $isSuccess ? 'w-5 h-5 text-green-600 shrink-0' : 'w-5 h-5 text-red-600 shrink-0';
    $closeClass = $isSuccess ? 'text-green-600 hover:text-green-900 p-1 cursor-pointer' : 'text-red-600 hover:text-red-900 p-1 cursor-pointer';
@endphp

<div class="{{ $containerClass }}">
    <div class="flex items-center gap-3">
        <x-icon :name="$iconName" :class="$iconClass" />
        <span class="text-sm font-semibold">{{ $message }}</span>
    </div>
    <button type="button" onclick="this.parentElement.remove()" class="{{ $closeClass }}">
        <x-icon name="close" class="w-4 h-4" />
    </button>
</div>
