@props([
    'title' => 'Universitas Amikom',
    'customCss' => null,
    'bodyClass' => 'bg-surface-gray text-on-surface min-h-screen flex',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title }}</title>

    <!-- Tailwind CSS & JS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Public+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if ($customCss)
        <link rel="stylesheet" href="{{ asset($customCss) }}">
    @endif

    {{ $styles ?? '' }}
    @stack('styles')
</head>
<body class="{{ $bodyClass }}" {{ $attributes }}>
    {{ $slot }}

    {{ $scripts ?? '' }}
    @stack('scripts')
</body>
</html>
