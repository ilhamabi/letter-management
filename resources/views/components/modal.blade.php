@props([
    'id' => 'modal',
    'title' => '',
    'maxWidth' => 'max-w-2xl',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden">
    <!-- Click backdrop to close -->
    <div class="fixed inset-0 -z-10" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"></div>

    <!-- Modal Content Card -->
    <div class="relative bg-pure-white rounded-2xl max-h-[90vh] w-full {{ $maxWidth }} overflow-hidden flex flex-col shadow-2xl animate-fade-in z-10 my-auto mx-auto">
        <!-- Modal Header -->
        <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-container-low/50">
            <div>
                <h3 class="font-headline-sm text-headline-sm text-deep-black font-bold" id="{{ $id }}-title">{{ $title }}</h3>
                @if (isset($subtitle))
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5" id="{{ $id }}-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
            <button class="text-on-surface-variant hover:text-deep-black p-2 rounded-full hover:bg-surface-container transition-colors" onclick="document.getElementById('{{ $id }}').classList.add('hidden')">
                <x-icon name="close" class="w-5 h-5" />
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto flex-grow space-y-6">
            {{ $slot }}
        </div>

        <!-- Modal Footer -->
        @if (isset($footer))
            <div class="p-6 bg-surface-gray border-t border-outline-variant flex justify-end gap-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
