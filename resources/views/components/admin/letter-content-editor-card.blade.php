@props([
    'editorId' => 'letter-template-editor',
    'selectId' => 'placeholder-select',
    'initialContent' => null,
])

<section {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm']) }}>
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-amikom-purple/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-amikom-purple">edit_document</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 m-0">Konfigurasi Template Isi Surat</h3>
                <!-- <p class="text-xs text-gray-500 m-0">Sesuaikan format dokumen dan variabel dinamis surat resmi</p> -->
            </div>
        </div>
        <div class="relative group cursor-help">
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-full text-xs font-medium text-gray-600 hover:bg-white transition-colors">
                <span class="material-symbols-outlined text-sm">help</span>
                Panduan Placeholder
            </div>
            <div class="absolute right-0 bottom-full mb-2 hidden group-hover:block w-72 bg-gray-900 text-white text-[11px] p-4 rounded-xl shadow-xl z-10">
                <p class="font-bold mb-2 text-amikom-gold">Cara Menggunakan Placeholder:</p>
                <ul class="space-y-1.5 opacity-90 pl-0">
                    <li>1. Gunakan tombol <span class="text-amikom-gold">+ Variable Surat</span> di toolbar TinyMCE</li>
                    <li>2. Atau pilih dari dropdown di bawah</li>
                    <li>3. Format variabel akan otomatis tersisip sebagai badge <span class="text-amikom-gold">@{{...}}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- TinyMCE Container & Quick Helper Toolbar -->
    <div class="border border-gray-200 rounded-lg overflow-hidden flex flex-col gap-3 p-3 bg-gray-50/50">
        <div class="bg-white border border-gray-200 p-2.5 rounded-md flex justify-between items-center flex-wrap gap-2 shadow-sm">
            <span class="text-xs font-semibold text-gray-700 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-base text-amikom-purple">extension</span>
                Sisipkan Variable Surat Cepat:
            </span>
            <select id="{{ $selectId }}" class="text-xs font-bold bg-white border border-gray-300 px-3 py-2 rounded-md outline-none text-amikom-purple cursor-pointer hover:border-amikom-purple transition-all focus:ring-2 focus:ring-amikom-purple/20 shadow-sm">
                <option disabled selected>+ SISIPKAN PLACEHOLDER</option>
                <optgroup class="text-[10px] text-gray-400 bg-gray-50" label="DATA MAHASISWA">
                    <option value="@{{Nama Mahasiswa}}">@{{Nama Mahasiswa}} : Nama lengkap mahasiswa</option>
                    <option value="@{{NIM}}">@{{NIM}} : Nomor Induk Mahasiswa</option>
                    <option value="@{{Program Studi}}">@{{Program Studi}} : Prodi asal mahasiswa</option>
                    <option value="@{{Semester}}">@{{Semester}} : Semester aktif saat ini</option>
                </optgroup>
                <optgroup class="text-[10px] text-gray-400 bg-gray-50" label="DATA SURAT">
                    <option value="@{{Nomor Surat}}">@{{Nomor Surat}} : Nomor registrasi otomatis</option>
                    <option value="@{{Tanggal}}">@{{Tanggal}} : Tanggal cetak surat</option>
                    <option value="@{{Tahun Akademik}}">@{{Tahun Akademik}} : Tahun ajaran berjalan</option>
                </optgroup>
                <optgroup class="text-[10px] text-gray-400 bg-gray-50" label="DATA PEJABAT">
                    <option value="@{{Nama Kaprodi}}">@{{Nama Kaprodi}} : Nama pejabat penandatangan</option>
                    <option value="@{{NIP Kaprodi}}">@{{NIP Kaprodi}} : NIP pejabat penandatangan</option>
                </optgroup>
            </select>
        </div>

        <!-- TinyMCE Editor Textarea -->
        <textarea id="{{ $editorId }}" name="content" class="w-full">
@if($initialContent)
{!! $initialContent !!}
@else
<p style="text-align: right;">Bandung, <span class="placeholder-pill">@{{Tanggal}}</span></p>
<p>Nomor: <span class="placeholder-pill">@{{Nomor Surat}}</span><br>Lampiran: -<br>Hal: Surat Keterangan Aktif Kuliah</p>
<p>Yth.<br>Pihak yang Berkepentingan<br>di Tempat</p>
<p>Yang bertanda tangan di bawah ini, menerangkan bahwa:</p>
<table style="margin-left: 24px; width: 100%; max-width: 420px; border-collapse: collapse;">
  <tbody>
    <tr><td style="width: 130px; padding: 4px 0; font-weight: 600;">Nama</td><td>: <span class="placeholder-pill">@{{Nama Mahasiswa}}</span></td></tr>
    <tr><td style="padding: 4px 0; font-weight: 600;">NIM</td><td>: <span class="placeholder-pill">@{{NIM}}</span></td></tr>
    <tr><td style="padding: 4px 0; font-weight: 600;">Program Studi</td><td>: <span class="placeholder-pill">@{{Program Studi}}</span></td></tr>
    <tr><td style="padding: 4px 0; font-weight: 600;">Semester</td><td>: <span class="placeholder-pill">@{{Semester}}</span></td></tr>
  </tbody>
</table>
<p>Adalah benar mahasiswa aktif pada semester berjalan di institusi kami.</p>
<p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
<p style="text-align: right;">Hormat Kami,<br><br><br><br><span class="placeholder-pill">@{{Nama Kaprodi}}</span><br>NIP. <span class="placeholder-pill">@{{NIP Kaprodi}}</span></p>
@endif
        </textarea>
    </div>
</section>
