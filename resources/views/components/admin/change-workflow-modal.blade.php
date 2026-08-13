@props([
    'id' => 'change-workflow-modal',
    'flows' => [],
])

@php
    use App\Enums\ApprovalRole;

    $formattedFlows = collect($flows)->map(function ($flow) {
        $steps = collect($flow->steps ?? [])->map(function ($step) {
            $roleEnum = is_object($step->approval_role) 
                ? $step->approval_role 
                : ApprovalRole::tryFrom($step->approval_role);

            return [
                'id' => $step->id,
                'name' => $step->name,
                'role_value' => $roleEnum ? $roleEnum->value : (string) $step->approval_role,
                'role_label' => $roleEnum ? $roleEnum->shortLabel() : $step->name,
                'full_label' => $roleEnum ? $roleEnum->label() : $step->name,
                'bg' => $roleEnum ? $roleEnum->bg() : 'bg-gray-600',
            ];
        })->values()->toArray();

        $rolesPresent = collect($steps)->pluck('role_value')->unique()->values()->toArray();

        return [
            'id' => $flow->id,
            'name' => $flow->name,
            'steps_count' => count($steps),
            'roles' => $rolesPresent,
            'steps' => $steps,
        ];
    })->values()->toArray();

    $roleCases = collect(ApprovalRole::cases())->map(function ($case) {
        return [
            'value' => $case->value,
            'label' => $case->shortLabel(),
            'full_label' => $case->label(),
        ];
    })->toArray();
@endphp

<script>
    window.approvalFlowsData = @json($formattedFlows);
</script>

<x-modal :id="$id" title="Ubah Alur Persetujuan" maxWidth="max-w-2xl" zIndex="z-[100]" x-data="{ 
    selectedFlowId: null, 
    rolesFilter: {
        ACADEMIC_ADVISOR: true,
        INTERNSHIP_SUPERVISOR: true,
        THESIS_SUPERVISOR: true,
        HEAD_OF_STUDY_PROGRAM: true
    },
    flows: window.approvalFlowsData || [],
    init() {
        if (this.flows.length > 0) {
            this.selectedFlowId = this.flows[0].id;
        }
    },
    toggleAllFilters(state) {
        this.rolesFilter.ACADEMIC_ADVISOR = state;
        this.rolesFilter.INTERNSHIP_SUPERVISOR = state;
        this.rolesFilter.THESIS_SUPERVISOR = state;
        this.rolesFilter.HEAD_OF_STUDY_PROGRAM = state;
    },
    get filteredFlows() {
        if (!this.flows || !Array.isArray(this.flows)) return [];
        return this.flows.filter(flow => {
            if (!flow || !Array.isArray(flow.roles)) return false;
            // Show flow if AT LEAST ONE of its roles matches the active filters
            return flow.roles.some(roleVal => Boolean(this.rolesFilter[roleVal]));
        });
    },
    applyWorkflow() {
        const selected = this.flows.find(f => f.id === this.selectedFlowId);
        if (selected) {
            this.$dispatch('flow-selected', selected);
        }
        closeModal('{{ $id }}');
    }
}">
    <div class="space-y-5">
        <!-- Filter Peran Section -->
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-700 font-label-sm">
                    <x-icon name="filter_list" class="w-4 h-4 text-amikom-purple" />
                    <span>Filter Peran Approver</span>
                </div>
                <div class="flex gap-2">
                    <button type="button" @click="toggleAllFilters(true)" class="text-xs text-amikom-purple font-bold hover:underline font-label-sm">Pilih Semua</button>
                    <span class="text-gray-300">|</span>
                    <button type="button" @click="toggleAllFilters(false)" class="text-xs text-gray-500 hover:underline font-label-sm">Bersihkan</button>
                </div>
            </div>

            <!-- Role Checkboxes from ApprovalRole Enum -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                @foreach($roleCases as $roleItem)
                    <label class="flex items-center gap-2.5 px-3 py-2 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-amikom-purple transition-all select-none shadow-2xs">
                        <input 
                            type="checkbox" 
                            x-model="rolesFilter.{{ $roleItem['value'] }}" 
                            class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple w-4 h-4 cursor-pointer">
                        <span class="text-xs font-bold text-gray-800 font-label-sm">{{ $roleItem['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Workflow Options List -->
        <div class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider font-label-sm">Pilih Alur Persetujuan (<span x-text="filteredFlows.length"></span> Tersedia)</h4>
            </div>

            <div class="flex flex-col gap-3 max-h-[360px] overflow-y-auto pr-1">
                <template x-for="flow in filteredFlows" :key="flow.id">
                    <div 
                        @click="selectedFlowId = flow.id" 
                        :class="selectedFlowId === flow.id 
                            ? 'border-2 border-amikom-purple bg-purple-50/30 shadow-sm' 
                            : 'border border-gray-200 bg-white hover:border-purple-300 hover:bg-gray-50/60'"
                        class="w-full p-4 rounded-xl flex items-center justify-between text-left transition-all cursor-pointer group">
                        <div class="flex flex-col gap-2 flex-1 mr-4">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-gray-900 font-label-md" x-text="flow.name"></span>
                                <span class="text-xs font-bold px-2.5 py-0.5 bg-gray-100 text-gray-700 rounded-full font-label-sm" x-text="flow.steps_count + ' Tahap'"></span>
                            </div>

                            <!-- Steps Preview with (1), (2) Indicators -->
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <template x-for="(step, idx) in flow.steps" :key="step.id || idx">
                                    <div class="flex items-center gap-1.5">
                                        <span :class="step.bg || 'bg-gray-600'" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-white font-label-sm shadow-2xs">
                                            <span class="mr-1 font-bold text-[11px] opacity-80" x-text="'(' + (idx + 1) + ')'"></span>
                                            <span x-text="step.role_label"></span>
                                        </span>
                                        <template x-if="idx < flow.steps.length - 1">
                                            <x-icon name="arrow_forward" class="w-3.5 h-3.5 text-gray-400 shrink-0" />
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Selection Indicator -->
                        <div class="shrink-0">
                            <template x-if="selectedFlowId === flow.id">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amikom-purple text-white shadow-xs">
                                    <x-icon name="check" class="w-4 h-4 font-bold" />
                                </span>
                            </template>
                            <template x-if="selectedFlowId !== flow.id">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full border border-gray-300 bg-white group-hover:border-amikom-purple"></span>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Empty Filter State -->
                <div x-show="filteredFlows.length === 0" class="py-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <x-icon name="filter_list" class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                    <p class="text-sm font-bold text-gray-700 font-label-md">Tidak ada alur yang cocok dengan filter peran.</p>
                    <p class="text-xs text-gray-500 mt-1 font-body-sm">Coba centang opsi role lainnya pada panel filter di atas.</p>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <button class="px-6 py-2 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300 font-label-md" onclick="closeModal('{{ $id }}')" type="button">
            Batal
        </button>
        <button class="px-6 py-2 rounded-lg text-sm font-bold bg-amikom-purple text-white hover:opacity-90 active:scale-95 transition-all shadow-md font-label-md inline-flex items-center gap-1.5" @click="applyWorkflow()" type="button">
            <x-icon name="check_circle" class="w-4 h-4" />
            <span>Ubah Alur</span>
        </button>
    </x-slot:footer>
</x-modal>
