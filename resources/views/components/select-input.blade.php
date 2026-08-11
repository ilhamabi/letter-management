@props([
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'options' => [],
    'value' => null,
    'selected' => null,
])

@php
    $selectedValue = $value ?? $selected ?? (request($name) ?? old($name) ?? '');
    $selectId = $id ?? $name;
@endphp

<div class="relative w-full">
    <select 
        @if($selectId) id="{{ $selectId }}" @endif
        @if($name) name="{{ $name }}" @endif
        {{ $attributes->merge(['class' => 'w-full bg-surface-container-low border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-lg px-4 h-11 text-body-sm font-body-sm text-on-surface transition-all cursor-pointer appearance-none pr-10']) }}
    >
        @if ($placeholder)
            <option value="" @selected((string)$selectedValue === '')>{{ $placeholder }}</option>
        @endif

        @foreach ($options as $option)
            @php
                if (is_array($option)) {
                    $optValue = (string) ($option['value'] ?? '');
                    $optLabel = $option['label'] ?? $optValue;
                } else {
                    $optValue = (string) $option;
                    $optLabel = (string) $option;
                }
            @endphp
            @if ($placeholder && $optValue === '')
                @continue
            @endif
            <option value="{{ $optValue }}" @selected((string)$selectedValue === $optValue)>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>
    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant flex items-center">
        <x-icon name="expand_more" class="w-5 h-5" />
    </div>
</div>
