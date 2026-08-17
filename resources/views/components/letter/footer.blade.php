@props([
    'isoLogoUrl' => null,
    'jasAnzLogoUrl' => null,
    'iafLogoUrl' => null,
])

@php
    $isoLogo = $isoLogoUrl ?? 'data:image/webp;base64,' . base64_encode(file_get_contents(public_path('letter/images/ISO9001.webp')));
    $jasAnzLogo = $jasAnzLogoUrl ?? 'data:image/svg+xml;base64,' . base64_encode(file_get_contents(public_path('letter/images/jas-anz.svg')));
    $iafLogo = $iafLogoUrl ?? 'data:image/svg+xml;base64,' . base64_encode(file_get_contents(public_path('letter/images/IAF.svg')));
@endphp

<!-- ===== FOOTER SURAT ===== -->
<div class="letter-footer">
    <div class="footer-badges">
        <img src="{{ $isoLogo }}" alt="ISO 9001 Logo" style="height: 38pt; width: auto; display: inline-block;">
        <img src="{{ $jasAnzLogo }}" alt="JAS-ANZ Logo" style="height: 38pt; width: 38pt; display: inline-block;">
        <img src="{{ $iafLogo }}" alt="IAF Logo" style="height: 24pt; width: auto; display: inline-block;">
    </div>

    <div class="footer-text">
        <b>GRAHA AMIKOM:</b> Jl. Padjajaran Ring Road Utara, Kel Condongcatur<br>
        Kec.Depok, Kab.Sleman. Prop. Daerah Istimewa Yogyakarta<br>
        Telp.(0274) 884201 - 204,Fax (0274) 884208<br>
        e-mail:amikom@amikom.ac.id&nbsp;&nbsp;&nbsp; www.amikom.ac.id<br>
        <span class="tagline">Creative Economy Park</span>
    </div>

    <table class="colorbar-table">
        <tr>
            <td style="width: 14.25%; background-color: #813068;"></td>
            <td style="width: 14.43%; background-color: #C75727;"></td>
            <td style="width: 14.26%; background-color: #FAA74B;"></td>
            <td style="width: 10.20%; background-color: #30155A;"></td>
            <td style="width: 20.24%; background-color: #DE6C26;"></td>
            <td style="width: 26.62%; background-color: #F3CF5F;"></td>
        </tr>
    </table>
</div>
