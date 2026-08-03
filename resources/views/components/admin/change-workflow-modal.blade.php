@props([
    'id' => 'add-role-modal',
])

<div class="fixed inset-0 z-[100] hidden" id="{{ $id }}" x-data="{ 
    selectedFlow: 1, 
    filterOpen: false, 
    rolesFilter: { wali: true, kaprodi: true, pembimbing: true },
    flows: [
        { id: 1, name: 'Standar (Dosen Wali → Kaprodi)', steps: ['Dosen Wali', 'Kaprodi'], roles: ['wali', 'kaprodi'] },
        { id: 2, name: 'Lengkap (Dosen Wali → Dosen Pembimbing → Kaprodi)', steps: ['Dosen Wali', 'Dosen Pembimbing', 'Kaprodi'], roles: ['wali', 'pembimbing', 'kaprodi'] },
        { id: 3, name: 'Akademik (Dosen Wali → Dosen Pembimbing)', steps: ['Dosen Wali', 'Dosen Pembimbing'], roles: ['wali', 'pembimbing'] },
        { id: 4, name: 'Kaprodi Langsung', steps: ['Kaprodi'], roles: ['kaprodi'] }
    ],
    get filteredFlows() {
        return this.flows.filter(flow => {
            if (this.rolesFilter.wali && flow.roles.includes('wali')) return true;
            if (this.rolesFilter.kaprodi && flow.roles.includes('kaprodi')) return true;
            if (this.rolesFilter.pembimbing && flow.roles.includes('pembimbing')) return true;
            return false;
        });
    },
    applyWorkflow() {
        const selected = this.flows.find(f => f.id === this.selectedFlow);
        if (selected) {
            this.$dispatch('workflow-updated', selected.steps);
        }
        document.getElementById('{{ $id }}').classList.add('hidden');
    }
}">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"></div>

    <!-- Modal Content Card -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden z-10 my-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-amikom-purple m-0">Ubah Alur Persetujuan</h3>
                <button class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" type="button">
                    <x-icon name="close" class="w-5 h-5" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider m-0">Pilih Alur Persetujuan</h4>
                    
                    <!-- Filter Peran Dropdown -->
                    <div class="relative">
                        <button 
                            @click="filterOpen = !filterOpen" 
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 hover:border-amikom-purple transition-all focus:ring-2 focus:ring-amikom-purple/20" 
                            type="button">
                            <div class="flex items-center gap-2">
                                <x-icon name="filter_list" class="w-4 h-4 text-gray-400" />
                                <span class="font-medium">Filter Peran</span>
                            </div>
                            <x-icon name="expand_more" class="w-4 h-4 text-gray-400 transition-transform duration-200" x-bind:class="filterOpen ? 'rotate-180' : ''" />
                        </button>

                        <!-- Filter Dropdown Menu -->
                        <div 
                            x-show="filterOpen" 
                            @click.away="filterOpen = false" 
                            x-transition
                            class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-20 overflow-hidden" 
                            style="display: none;">
                            <div class="p-2 space-y-1">
                                <label class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded cursor-pointer transition-colors select-none">
                                    <input type="checkbox" x-model="rolesFilter.wali" class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple">
                                    <span class="text-sm text-gray-700 font-medium">Dosen Wali</span>
                                </label>
                                <label class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded cursor-pointer transition-colors select-none">
                                    <input type="checkbox" x-model="rolesFilter.kaprodi" class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple">
                                    <span class="text-sm text-gray-700 font-medium">Kaprodi</span>
                                </label>
                                <label class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded cursor-pointer transition-colors select-none">
                                    <input type="checkbox" x-model="rolesFilter.pembimbing" class="rounded border-gray-300 text-amikom-purple focus:ring-amikom-purple">
                                    <span class="text-sm text-gray-700 font-medium">Dosen Pembimbing</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Workflow Options List -->
                    <div class="flex flex-col gap-3 max-h-[320px] overflow-y-auto pr-1">
                        <template x-for="flow in filteredFlows" :key="flow.id">
                            <button 
                                @click="selectedFlow = flow.id" 
                                type="button"
                                x-bind:class="selectedFlow === flow.id 
                                    ? 'border-2 border-amikom-purple bg-white shadow-sm' 
                                    : 'border border-gray-200 bg-gray-50 hover:border-amikom-purple hover:bg-white'"
                                class="w-full px-4 py-3 rounded-xl flex items-center justify-between text-left transition-all">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <template x-for="(step, idx) in flow.steps" :key="idx">
                                            <div class="flex items-center gap-2">
                                                <span 
                                                    x-bind:class="selectedFlow === flow.id ? 'text-gray-900 font-bold' : 'text-gray-600 font-medium'"
                                                    class="text-xs" 
                                                    x-text="step"></span>
                                                <span x-show="idx < flow.steps.length - 1">
                                                    <x-icon name="arrow_forward" class="w-3.5 h-3.5 text-gray-400 inline" />
                                                </span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <span x-show="selectedFlow === flow.id">
                                    <x-icon name="check_circle" class="w-5 h-5 text-amikom-purple" />
                                </span>
                                <div x-show="selectedFlow !== flow.id" class="w-6"></div>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100">
                <button class="px-6 py-2 rounded-md text-sm font-bold text-gray-600 hover:bg-gray-100 transition-colors border border-gray-300" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" type="button">
                    Batal
                </button>
                <button class="px-6 py-2 rounded-md text-sm font-bold bg-amikom-purple text-white hover:opacity-90 active:scale-95 transition-all shadow-md" @click="applyWorkflow()" type="button">
                    Ubah Alur
                </button>
            </div>
        </div>
    </div>
</div>
