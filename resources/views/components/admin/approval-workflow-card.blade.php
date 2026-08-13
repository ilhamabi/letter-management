@props([
    'flows' => [],
    'defaultFlow' => null,
    'modalId' => 'change-workflow-modal',
])

@php
    use App\Enums\ApprovalRole;

    $formattedDefault = null;
    if ($defaultFlow) {
        $steps = collect($defaultFlow->steps ?? [])->map(function ($step) {
            $roleEnum = is_object($step->approval_role) 
                ? $step->approval_role 
                : ApprovalRole::tryFrom($step->approval_role);

            return [
                'id' => $step->id,
                'name' => $step->name,
                'role_label' => $roleEnum ? $roleEnum->shortLabel() : $step->name,
                'bg' => $roleEnum ? $roleEnum->bg() : 'bg-gray-600',
            ];
        })->values()->toArray();

        $formattedDefault = [
            'id' => $defaultFlow->id,
            'name' => $defaultFlow->name,
            'steps_count' => count($steps),
            'steps' => $steps,
        ];
    } elseif (count($flows) > 0) {
        $first = $flows[0];
        $steps = collect($first->steps ?? [])->map(function ($step) {
            $roleEnum = is_object($step->approval_role) 
                ? $step->approval_role 
                : ApprovalRole::tryFrom($step->approval_role);

            return [
                'id' => $step->id,
                'name' => $step->name,
                'role_label' => $roleEnum ? $roleEnum->shortLabel() : $step->name,
                'bg' => $roleEnum ? $roleEnum->bg() : 'bg-gray-600',
            ];
        })->values()->toArray();

        $formattedDefault = [
            'id' => $first->id,
            'name' => $first->name,
            'steps_count' => count($steps),
            'steps' => $steps,
        ];
    }
@endphp

<script>
    window.defaultApprovalFlow = @json($formattedDefault);
</script>

<section 
    x-data="{ 
        selectedFlow: window.defaultApprovalFlow || null 
    }" 
    @flow-selected.window="selectedFlow = $event.detail"
    {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm overflow-hidden relative']) }}>
    
    <!-- Hidden form field storing selected approval_flow_id -->
    <input type="hidden" name="approval_flow_id" :value="selectedFlow ? selectedFlow.id : ''" required>

    <div class="absolute top-0 left-0 w-full h-1 bg-amikom-gold"></div>
    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900 m-0 font-title-lg">Alur Persetujuan</h3>
            <p class="text-xs text-gray-500 mt-0.5 font-body-sm">Pilih alur bertingkat yang akan digunakan oleh jenis surat ini.</p>
        </div>
        <button 
            class="bg-amikom-purple text-white px-4 py-2 rounded-lg font-bold transition-all hover:opacity-90 active:scale-95 shadow-sm text-xs inline-flex items-center gap-1.5 font-label-md" 
            onclick="openModal('{{ $modalId }}')" 
            type="button">
            <x-icon name="swap_horiz" class="w-4 h-4" />
            <span>Ubah Alur</span>
        </button>
    </div>

    <!-- Active Selected Flow Display -->
    <template x-if="selectedFlow">
        <div class="space-y-4">
            <div class="flex items-center justify-between bg-purple-50/50 p-3 rounded-lg border border-purple-100">
                <div class="flex items-center gap-2">
                    <x-icon name="account_tree" class="w-5 h-5 text-amikom-purple" />
                    <span class="font-bold text-sm text-gray-900 font-label-md" x-text="selectedFlow.name"></span>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-white text-amikom-purple border border-purple-200 rounded-full font-label-sm" x-text="selectedFlow.steps_count + ' Tahap Persetujuan'"></span>
            </div>

            <!-- Steps Visualization with (1), (2), (3) indicators -->
            <div class="flex items-center gap-3 overflow-x-auto pb-2 pt-1 scrollbar-hide">
                <template x-for="(step, index) in selectedFlow.steps" :key="step.id || index">
                    <div class="flex items-center gap-3 shrink-0">
                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-200 min-w-[210px] hover:border-amikom-purple transition-all shadow-xs">
                            <div :class="step.bg || 'bg-blue-600'" class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-xs shrink-0 font-label-sm">
                                (<span x-text="index + 1"></span>)
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 font-semibold font-label-sm">Tahap <span x-text="index + 1"></span></p>
                                <p class="text-sm font-bold text-gray-900 truncate font-label-md" x-text="step.role_label || step.name"></p>
                            </div>
                        </div>
                        <template x-if="index < selectedFlow.steps.length - 1">
                            <div class="flex items-center justify-center px-1">
                                <x-icon name="arrow_forward" class="w-5 h-5 text-amikom-purple font-bold" />
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- Empty State if No Flow Selected -->
    <template x-if="!selectedFlow">
        <div class="py-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <x-icon name="help_outline" class="w-8 h-8 text-gray-400 mx-auto mb-2" />
            <p class="text-sm font-bold text-gray-700 font-label-md">Belum ada alur dipilih</p>
            <p class="text-xs text-gray-500 mt-1 font-body-sm">Klik tombol "Ubah Alur" di atas untuk memilih alur persetujuan dari database.</p>
        </div>
    </template>
</section>
