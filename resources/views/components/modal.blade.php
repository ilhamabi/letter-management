@props([
    'id' => 'modal',
    'title' => '',
    'subtitle' => null,
    'maxWidth' => 'max-w-2xl',
    'zIndex' => 'z-50',
    'showHeader' => true,
    'showClose' => true,
    'padding' => 'p-6',
    'backdropClickClose' => true,
])

<div id="{{ $id }}" 
     class="fixed inset-0 {{ $zIndex }} flex items-center justify-center p-4 bg-deep-black/60 backdrop-blur-sm hidden animate-fade-in" 
     @if($backdropClickClose) 
        onclick="if (event.target === this) (typeof closeModal === 'function' ? closeModal('{{ $id }}') : this.classList.add('hidden'))" 
     @endif
     {{ $attributes }}>

    <!-- Modal Content Card -->
    <div class="relative bg-pure-white rounded-2xl max-h-[90vh] w-full {{ $maxWidth }} overflow-hidden flex flex-col shadow-2xl animate-scale-up z-10 my-auto mx-auto border border-outline-variant" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        @if ($showHeader)
            <div class="{{ $padding }} border-b border-outline-variant flex justify-between items-center bg-surface-container-low/50">
                <div>
                    @if ($title)
                        <h3 class="font-headline-sm text-headline-sm text-deep-black font-bold" id="{{ $id }}-title">{{ $title }}</h3>
                    @endif
                    @if (isset($subtitle) || $subtitle)
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5" id="{{ $id }}-subtitle">{{ $subtitle }}</p>
                    @endif
                </div>
                @if ($showClose)
                    <button type="button" 
                            class="text-on-surface-variant hover:text-deep-black p-2 rounded-full hover:bg-surface-container transition-colors cursor-pointer" 
                            onclick="typeof closeModal === 'function' ? closeModal('{{ $id }}') : document.getElementById('{{ $id }}').classList.add('hidden')">
                        <x-icon name="close" class="w-5 h-5 pointer-events-none" />
                    </button>
                @endif
            </div>
        @endif

        <!-- Modal Body -->
        <div class="{{ $padding }} overflow-y-auto flex-grow space-y-6" id="{{ $id }}-body">
            {{ $slot }}
        </div>

        <!-- Modal Footer -->
        @if (isset($footer))
            <div class="{{ $padding }} bg-surface-gray border-t border-outline-variant flex justify-end gap-3" id="{{ $id }}-footer">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
