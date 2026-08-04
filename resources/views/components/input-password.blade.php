@props([
    'id' => 'password',
    'name' => 'password',
    'label' => null,
    'placeholder' => '••••••••',
    'value' => '',
    'required' => false,
    'icon' => null,
    'iconClass' => 'w-5 h-5',
    'inputClass' => 'px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm bg-white font-body-sm',
    'labelClass' => 'text-xs font-bold uppercase tracking-wider text-gray-500 font-label-sm',
])

<div x-data="{ show: false }" class="flex flex-col gap-1.5 w-full">
    @if ($label)
        <label for="{{ $id }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif
    <div class="relative w-full">
        @if ($icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                <x-icon :name="$icon" class="{{ $iconClass }}" />
            </span>
        @endif
        
        <input 
            :type="show ? 'text' : 'password'" 
            id="{{ $id }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            placeholder="{{ $placeholder }}" 
            @if($required) required @endif
            {{ $attributes->merge(['class' => $inputClass . ($icon ? ' pl-10 pr-10' : ' pr-10') . ' w-full']) }}
        />

        <button 
            type="button" 
            @click="show = !show" 
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-700 transition-colors focus:outline-none"
            aria-label="Toggle password visibility"
        >
            <x-icon x-show="show" name="visibility" class="{{ $iconClass }}" style="display: none;" />
            <x-icon x-show="!show" name="visibility_off" class="{{ $iconClass }}" />
        </button>
    </div>
</div>
