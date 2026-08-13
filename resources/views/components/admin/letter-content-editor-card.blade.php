@props([
    'editorId' => 'letter-template-editor',
    'selectId' => 'placeholder-select',
    'initialContent' => null,
    'guideModalId' => 'placeholder-guide-modal',
])

@php
    $placeholderService = app(\App\Services\PlaceholderProviderService::class);
    $groupedPlaceholders = $placeholderService->getGroupedPlaceholders();
@endphp

<section {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm overflow-hidden relative']) }}>
    <div class="absolute top-0 left-0 w-full h-1 bg-amikom-purple"></div>

    <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-6 flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center shrink-0">
                <x-icon name="edit_document" class="w-5 h-5 text-amikom-purple" />
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 m-0 font-title-lg">Konfigurasi Template Isi Surat</h3>
                <p class="text-xs text-gray-500 mt-0.5 font-body-sm">Susun format dokumen resmi dan sisipkan variabel placeholder dinamis.</p>
            </div>
        </div>

        <!-- Panduan Placeholder Button -->
        <button 
            type="button" 
            onclick="openModal('{{ $guideModalId }}')"
            class="flex items-center gap-2 px-3.5 py-2 bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-200 rounded-xl text-xs font-bold text-gray-700 hover:text-amikom-purple transition-all shadow-2xs font-label-sm">
            <x-icon name="help_outline" class="w-4 h-4 text-amikom-purple" />
            <span>Lihat Variabel Tersedia</span>
        </button>
    </div>

    <!-- Notice Banner: Body Only Editor -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3.5 mb-4 flex items-start gap-3">
        <x-icon name="info" class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" />
        <div class="text-xs text-blue-950 space-y-0.5 font-body-sm">
            <p class="font-bold font-label-md">Catatan Penyusunan Template:</p>
            <p>Editor ini <strong>hanya digunakan untuk menyusun Isi Surat (Body Content)</strong>. Kop Surat (Header), Tanda Tangan (Signature Component & QR Code), dan Footer akan ditambahkan secara otomatis oleh sistem saat surat digenerate atau di-preview.</p>
        </div>
    </div>

    <!-- TinyMCE Container & Quick Helper Toolbar -->
    <div class="border border-gray-200 rounded-xl overflow-hidden flex flex-col gap-3 p-3.5 bg-gray-50/60">
        <div class="bg-white border border-gray-200 p-3 rounded-lg flex justify-between items-center flex-wrap gap-3 shadow-2xs">
            <span class="text-xs font-bold text-gray-800 flex items-center gap-2 font-label-sm">
                <x-icon name="extension" class="w-4 h-4 text-amikom-purple" />
                <span>Sisipkan Variabel Surat Cepat:</span>
            </span>
            <select 
                id="{{ $selectId }}" 
                class="text-xs font-bold bg-white border border-gray-300 px-3.5 py-2 rounded-lg outline-none text-amikom-purple cursor-pointer hover:border-amikom-purple transition-all focus:ring-2 focus:ring-amikom-purple/20 shadow-2xs font-label-sm">
                <option disabled selected>+ SISIPKAN PLACEHOLDER</option>
                @foreach($groupedPlaceholders as $group)
                    <optgroup class="text-[10px] text-gray-400 bg-gray-50 font-bold uppercase" label="{{ strtoupper($group['group']) }}">
                        @foreach($group['items'] as $item)
                            <option value="{{ $item['key'] }}">{{ $item['key'] }} : {{ $item['label'] }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <!-- TinyMCE Editor Textarea -->
        <textarea id="{{ $editorId }}" name="template_content" class="w-full">
@if(!empty($initialContent))
{!! $initialContent !!}
@else
<div class="doc-title-main">SURAT KETERANGAN AKTIF KULIAH</div>

<table class="info-table" style="width: 100%; border-collapse: collapse; margin-top: 6pt; margin-bottom: 12pt;">
  <tbody>
    <tr><td class="lbl" style="width: 120pt;">Nomor</td><td>: <span class="placeholder-pill">@{{letter_number}}</span></td></tr>
  </tbody>
</table>

<div class="doc-text-lead">Yang bertanda tangan di bawah ini, menerangkan bahwa:</div>

<table class="info-table" style="width: 100%; border-collapse: collapse; margin-top: 6pt; margin-bottom: 12pt;">
  <tbody>
    <tr><td class="lbl" style="width: 120pt;">Nama Mahasiswa</td><td>: <span class="placeholder-pill">@{{student_name}}</span></td></tr>
    <tr><td class="lbl">NIM</td><td>: <span class="placeholder-pill">@{{student_number}}</span></td></tr>
    <tr><td class="lbl">Program Studi</td><td>: <span class="placeholder-pill">@{{study_program}}</span></td></tr>
    <tr><td class="lbl">Semester</td><td>: <span class="placeholder-pill">@{{semester}}</span></td></tr>
  </tbody>
</table>

<div class="doc-text-justify">
  Adalah benar mahasiswa aktif yang terdaftar secara resmi pada semester berjalan di lingkungan Universitas AMIKOM Yogyakarta.
</div>

<div class="doc-text-lead" style="margin-top: 8pt;">
  Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
</div>
@endif
        </textarea>
    </div>
</section>
