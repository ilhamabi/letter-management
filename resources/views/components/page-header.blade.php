@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes }}>
    <h1 class="text-2xl font-bold text-gray-900 mb-2 font-headline-lg">{{ $title }}</h1>
    @if($subtitle)
        <p class="text-gray-600 text-sm">{{ $subtitle }}</p>
    @endif
</div>
