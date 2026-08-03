@props([
    'name' => 'Surat Keterangan Aktif',
    'status' => 'Aktif',
])

<section {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm']) }}>
    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6 font-title-lg">Informasi Dasar</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-xs font-bold uppercase text-gray-500 tracking-wider block font-label-sm">Nama Surat</label>
            <input class="w-full bg-white border border-gray-300 rounded px-4 py-2.5 text-sm focus:ring-amikom-purple focus:border-amikom-purple outline-none transition-all font-body-sm" type="text" value="{{ $name }}">
        </div>
        <div class="space-y-2">
            <label class="text-xs font-bold uppercase text-gray-500 tracking-wider block font-label-sm">Status Template</label>
            <select class="w-full bg-white border border-gray-300 rounded px-4 py-2.5 text-sm focus:ring-amikom-purple focus:border-amikom-purple outline-none transition-all font-body-sm">
                <option value="Aktif" {{ $status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Non-Aktif" {{ $status === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>
    </div>
</section>
