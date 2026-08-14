@props([
    'name' => null,
    'id' => null,
    'value' => null,
    'options' => [], // Array of ['value' => '', 'label' => '', 'badge' => '', 'badgeClass' => '']
    'placeholder' => 'Pilih pilihan...',
    'onchange' => null,
    'disabled' => false,
])

@php
    $selectedValue = (string) old($name, $value ?? request($name, ''));
    
    // Find matching option label or fallback to placeholder
    $selectedLabel = $placeholder;
    foreach ($options as $opt) {
        if ((string)($opt['value'] ?? '') === $selectedValue) {
            $selectedLabel = $opt['label'] ?? $placeholder;
            break;
        }
    }
@endphp

<div x-data="{ 
        open: false, 
        selectedValue: '{{ addslashes($selectedValue) }}',
        selectedLabel: '{{ addslashes($selectedLabel) }}',
        selectOption(val, label) {
            this.selectedValue = val;
            this.selectedLabel = label;
            this.open = false;
            $nextTick(() => {
                const hiddenInput = $refs.hiddenInput;
                if (hiddenInput) {
                    hiddenInput.value = val;
                    hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
                @if($onchange)
                    {!! $onchange !!};
                @endif
            });
        }
    }" 
    class="relative w-full"
    @keydown.escape.stop="open = false">

    <!-- Hidden Input for Native GET/POST Form Submit -->
    <input type="hidden" 
           @if($name) name="{{ $name }}" @endif 
           @if($id) id="{{ $id }}" @endif 
           x-ref="hiddenInput" 
           :value="selectedValue">

    <!-- Custom Select Trigger Button -->
    <button type="button" 
            @click="open = !open" 
            {{ $disabled ? 'disabled' : '' }}
            class="w-full bg-surface-container-low border border-outline-variant hover:bg-surface-container/70 hover:border-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary rounded-xl px-4 h-11 text-body-sm text-on-surface cursor-pointer transition-all duration-200 shadow-xs font-medium flex items-center justify-between gap-2">
        <span class="truncate" x-text="selectedLabel || '{{ addslashes($placeholder) }}'">{{ $selectedLabel }}</span>
        <x-icon name="expand_more" class="w-5 h-5 text-on-surface-variant shrink-0 transition-transform duration-200" ::class="open ? 'rotate-180 text-primary' : ''" />
    </button>

    <!-- Custom Dropdown Menu Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
         @click.outside="open = false" 
         class="absolute left-0 right-0 mt-2 z-50 bg-pure-white border border-outline-variant rounded-xl shadow-xl max-h-60 overflow-y-auto p-1.5 space-y-1"
         style="display: none;">
        @foreach ($options as $opt)
            @php
                $optVal = (string)($opt['value'] ?? '');
                $optLabel = $opt['label'] ?? '';
                $optBadge = $opt['badge'] ?? null;
                $optBadgeClass = $opt['badgeClass'] ?? 'bg-surface-container text-on-surface-variant border-outline-variant';
            @endphp
            <div @click="selectOption('{{ addslashes($optVal) }}', '{{ addslashes($optLabel) }}')"
                 class="px-3 py-2.5 rounded-lg flex items-center justify-between text-xs sm:text-sm font-medium cursor-pointer transition-colors duration-150 hover:bg-primary/10 hover:text-primary"
                 :class="selectedValue === '{{ addslashes($optVal) }}' ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface'">
                <div class="flex items-center gap-2 truncate">
                    <span class="truncate">{{ $optLabel }}</span>
                    @if($optBadge)
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full border {{ $optBadgeClass }}">
                            {{ $optBadge }}
                        </span>
                    @endif
                </div>
                <template x-if="selectedValue === '{{ addslashes($optVal) }}'">
                    <x-icon name="check" class="w-4 h-4 text-primary shrink-0 ml-2" />
                </template>
            </div>
        @endforeach
    </div>
</div>
