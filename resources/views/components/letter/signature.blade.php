@props([
    'signers' => null,
    'qrToken' => 'DEMO-TOKEN-2026',
    'qrUrl' => null,
    'city' => 'Yogyakarta',
    'date' => null,
    'title' => 'Ketua Program Studi',
    'department' => 'Prodi D3 Teknik Informatika',
    'name' => 'Dr. Barka Satya, M.Kom',
    'nip' => '190302126',
    'align' => 'right',
    'isPlaceholder' => false,
])

@php
    $targetUrl = $qrUrl ?? ($qrToken ? route('verify.letter', $qrToken) : url('/verify/DEMO-TOKEN-2026'));
    $qrService = app(\App\Services\QrCodeService::class);
    $qrSvgContent = $qrService->generateSvg($targetUrl, 160);
    $qrImgDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrSvgContent);

    $isPreviewToken = str_contains((string)$qrToken, 'PREVIEW') || (bool)$isPlaceholder;
    $qrCaption = $isPreviewToken 
        ? 'Pratinjau: QR Verifikasi Aktif Setelah Disetujui' 
        : 'Imbas QR untuk verifikasi keabsahan';

    // Normalize signers array if provided as props or fallback to single signer
    $signerList = [];
    if (is_array($signers) && count($signers) > 0) {
        $signerList = $signers;
    } else {
        $signerList[] = [
            'city' => $city,
            'date' => $date ?? date('d F Y'),
            'title' => $title,
            'department' => $department,
            'name' => $name,
            'nip' => $nip,
        ];
    }

    $isMultiSigner = count($signerList) > 1;
@endphp

<!-- ===== BLOK TANDA TANGAN UNIVERSAL (ADMIN PLACEHOLDER & ACTUAL MODE) ===== -->
@if($isPlaceholder)
    <!-- MODE ADMIN PREVIEW (SAMPLE DATA) -->
    <div class="sign-block text-right" style="margin-top: 10pt; width: 220pt;">
        <div>Yogyakarta, 11 September 2025</div>
        <div style="font-weight: bold;">Ketua Program Studi</div>

        <!-- Placeholder QR Code Box -->
        <div style="margin-top: 3pt; margin-bottom: 3pt; display: inline-block; text-align: center;">
            <div style="width: 52pt; height: 52pt; border: 1.5pt dashed #94a3b8; background: #f8fafc; border-radius: 4pt; margin: 0 auto; padding: 2pt; text-align: center;">
                <span style="font-size: 6.5pt; font-weight: bold; color: #475569; font-family: sans-serif; display: block; margin-top: 14pt;">[ QR CODE ]</span>
            </div>
            <div style="font-size: 6.5pt; color: #64748b; margin-top: 2pt; font-family: Arial, sans-serif; font-weight: bold;">
                Otomatis di-generate sistem
            </div>
        </div>

        <div style="font-weight: bold; margin-top: 2pt; white-space: normal; word-break: break-word;">Dr. Barka Satya, M.Kom</div>
        <div>NIK/NIDN. 190302126</div>
    </div>
@elseif(!$isMultiSigner)
    <!-- MODE SURAT ACTUAL (SINGLE SIGNER) -->
    @php
        $s = $signerList[0];
        $formattedDate = $s['date'] ?? ($date ?? date('d F Y'));
        $cityName = $s['city'] ?? $city;
        $alignClass = match($align) {
            'left' => 'text-left',
            'center' => 'text-center',
            default => 'text-right',
        };
    @endphp

    <div class="sign-block {{ $alignClass }}" style="margin-top: 10pt; width: 220pt;">
        <div>{{ $cityName }}, {{ $formattedDate }}</div>
        <div class="bold" style="font-weight: bold;">{{ $s['title'] }}</div>
        @if(!empty($s['department']))
            <div style="margin-bottom: 6pt;">{{ $s['department'] }}</div>
        @endif

        <!-- QR Code Verification Vector (Instant Local Pure SVG Render) -->
        <div style="margin-top: 6pt; margin-bottom: 4pt; display: inline-block; text-align: center;">
            <a href="{{ $targetUrl }}" target="_blank" title="Imbas atau Klik untuk Memverifikasi Keabsahan Dokumen" style="text-decoration: none; display: inline-block; border: 0; outline: none;">
                <div class="qr-code-img" style="display: inline-block; width: 52pt; height: 52pt; padding: 2pt; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 4pt; box-sizing: border-box; text-align: center;">
                    <img src="{{ $qrImgDataUri }}" alt="QR Verifikasi" width="64" height="64" style="width: 48pt; height: 48pt; display: block; margin: 0 auto; border: 0;">
                </div>
            </a>
            <div style="font-size: 6.5pt; color: #64748b; margin-top: 2pt; font-family: Arial, sans-serif; font-weight: bold;">
                {{ $qrCaption }}
            </div>
        </div>

        <div class="bold" style="font-weight: bold; margin-top: 2pt; white-space: normal; word-break: break-word;">{{ $s['name'] }}</div>
        @if(!empty($s['nip']) && $s['nip'] !== '-')
            <div>NIK/NIDN. {{ $s['nip'] }}</div>
        @endif
    </div>
@else
    <!-- MODE SURAT ACTUAL (MULTI-SIGNER SIDE-BY-SIDE TABLE FOR DOMPDF & BROWSER COMPATIBILITY) -->
    @php
        $count = count($signerList);
        $colWidth = floor(100 / $count);
    @endphp
    <table style="width: 100%; border-collapse: collapse; margin-top: 10pt; page-break-inside: avoid;">
        <tr>
            @foreach($signerList as $index => $s)
                @php
                    $formattedDate = $s['date'] ?? date('d F Y');
                    $cityName = $s['city'] ?? 'Yogyakarta';
                    $isLastSigner = $loop->last;
                    $textAlign = $loop->first ? 'left' : ($loop->last ? 'right' : 'center');
                @endphp
                <td style="width: {{ $colWidth }}%; vertical-align: top; text-align: {{ $textAlign }}; line-height: 1.3;">
                    <div>{{ $cityName }}, {{ $formattedDate }}</div>
                    <div class="bold" style="font-weight: bold;">{{ $s['title'] }}</div>
                    @if(!empty($s['department']))
                        <div style="margin-bottom: 6pt;">{{ $s['department'] }}</div>
                    @endif

                    @if($isLastSigner)
                        <!-- QR Code verification on final approver column -->
                        <div style="margin-top: 6pt; margin-bottom: 4pt; display: inline-block; text-align: center;">
                            <a href="{{ $targetUrl }}" target="_blank" title="Imbas atau Klik untuk Memverifikasi Keabsahan Dokumen" style="text-decoration: none; display: inline-block; border: 0; outline: none;">
                                <div class="qr-code-img" style="display: inline-block; width: 52pt; height: 52pt; padding: 2pt; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 4pt; box-sizing: border-box; text-align: center;">
                                    <img src="{{ $qrImgDataUri }}" alt="QR Verifikasi" width="64" height="64" style="width: 48pt; height: 48pt; display: block; margin: 0 auto; border: 0;">
                                </div>
                            </a>
                            <div style="font-size: 6.5pt; color: #64748b; margin-top: 2pt; font-family: Arial, sans-serif; font-weight: bold;">
                                {{ $qrCaption }}
                            </div>
                        </div>
                    @else
                        <div style="height: 54pt; margin-top: 3pt; margin-bottom: 3pt;"></div>
                    @endif

                    <div class="bold" style="font-weight: bold; margin-top: 4pt; white-space: normal; word-break: break-word;">{{ $s['name'] }}</div>
                    @if(!empty($s['nip']) && $s['nip'] !== '-')
                        <div>NIK/NIDN. {{ $s['nip'] }}</div>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
@endif
