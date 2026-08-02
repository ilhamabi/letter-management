@props([
    'steps' => [
        ['number' => 1, 'role' => 'Dosen Wali'],
        ['number' => 2, 'role' => 'Kaprodi'],
    ],
    'modalId' => 'add-role-modal',
])

<section 
    x-data="{ 
        currentSteps: @js(array_map(fn($s) => is_array($s) ? ($s['role'] ?? $s['name'] ?? '') : $s, $steps)) 
    }" 
    @workflow-updated.window="currentSteps = $event.detail"
    {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm overflow-hidden relative']) }}>
    <div class="absolute top-0 left-0 w-full h-1 bg-amikom-gold"></div>
    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6 mt-2">
        <h3 class="text-lg font-bold text-gray-900 m-0">Alur Persetujuan</h3>
        <button class="bg-amikom-purple text-white px-4 py-2 rounded-lg font-medium transition-all hover:opacity-90 active:scale-95 shadow-sm text-sm" onclick="document.getElementById('{{ $modalId }}').classList.remove('hidden')" type="button">Ubah Alur</button>
    </div>
    <div class="flex items-center gap-4 overflow-x-auto pb-4 scrollbar-hide">
        <template x-for="(step, index) in currentSteps" :key="index">
            <div class="flex items-center gap-4 shrink-0">
                <div class="flex items-center gap-2 bg-gray-50 p-2.5 rounded-lg border border-gray-200 group shrink-0 min-w-[200px] hover:border-amikom-purple transition-all">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-sm" x-text="index + 1"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900 m-0" x-text="typeof step === 'object' ? (step.role || step.name) : step"></p>
                    </div>
                </div>
                <div x-show="index < currentSteps.length - 1" class="flex items-center justify-center px-1">
                    <span class="material-symbols-outlined text-amikom-purple font-bold animate-pulse">arrow_forward</span>
                </div>
            </div>
        </template>
    </div>
</section>
