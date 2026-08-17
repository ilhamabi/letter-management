<x-letter.layout 
    :title="$documentTitle ?? 'Preview Surat Resmi AMIKOM'" 
    :signers="$signers ?? null" 
    :signatureProps="$signatureProps ?? null" 
    :qrToken="$qrToken ?? 'DEMO-TOKEN-2026'"
    :isPlaceholder="$isPlaceholderMode ?? false"
    :customCss="$customCss ?? null">
    {!! $bodyContent !!}
</x-letter.layout>
