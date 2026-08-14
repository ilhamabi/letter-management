@props([
    'title' => 'Surat Resmi - Universitas AMIKOM Yogyakarta',
    'signers' => null,
    'qrToken' => 'DEMO-TOKEN-2026',
    'signatureProps' => null,
    'isPlaceholder' => false,
    'includePrintScript' => true,
    'customCss' => null,
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ url('/letter/letter-style.css') }}">
    @if($customCss)
        <style>
            {!! $customCss !!}
        </style>
    @endif
</head>
<body>
    <div class="sheet-wrap">
        <div class="page">
            <!-- Kop Surat Component -->
            <x-letter.header />

            <!-- Content Body from DB -->
            <div class="doc-content">
                {{ $slot }}

                @if(isset($signature))
                    {{ $signature }}
                @elseif(is_array($signers) && count($signers) > 0)
                    <x-letter.signature :signers="$signers" :qrToken="$qrToken" :isPlaceholder="$isPlaceholder" />
                @elseif(is_array($signatureProps))
                    <x-letter.signature 
                        :city="$signatureProps['city'] ?? 'Yogyakarta'" 
                        :date="$signatureProps['date'] ?? null" 
                        :title="$signatureProps['title'] ?? 'Ketua Program Studi'" 
                        :department="$signatureProps['department'] ?? 'Prodi D3 Teknik Informatika'" 
                        :name="$signatureProps['name'] ?? 'Dr. Barka Satya, M.Kom'" 
                        :nip="$signatureProps['nip'] ?? '190302126'" 
                        :qrToken="$qrToken"
                        :isPlaceholder="$isPlaceholder"
                    />
                @else
                    <x-letter.signature :qrToken="$qrToken" :isPlaceholder="$isPlaceholder" />
                @endif
            </div>

            <!-- Footer Component -->
            <x-letter.footer />
        </div>
    </div>

    @if($includePrintScript)
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('print') === 'true') {
                    setTimeout(() => {
                        window.print();
                    }, 500);
                }
            });
        </script>
    @endif
</body>
</html>
