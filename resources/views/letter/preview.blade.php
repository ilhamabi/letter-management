<x-letter.layout 
    :title="$documentTitle ?? 'Preview Surat Resmi AMIKOM'" 
    :signers="$signers ?? null" 
    :signatureProps="$signatureProps ?? null" 
    :qrToken="$qrToken ?? 'DEMO-TOKEN-2026'"
    :isPlaceholder="$isPlaceholderMode ?? false"
    :customCss="$customCss ?? null"
    :enableToggle="$enableToggle ?? false">
    
    @if($enableToggle ?? false)
        <div id="body-sample" class="body-version active">
            {!! $bodyContentSample !!}
        </div>
        <div id="body-raw" class="body-version hidden">
            {!! $bodyContentRaw !!}
        </div>
    @else
        {!! $bodyContent !!}
    @endif
</x-letter.layout>
