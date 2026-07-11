<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Public+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-surface-gray font-body-md text-on-surface antialiased">
    <div
        class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top_left,_rgba(65,0,99,0.08),_transparent_40%)] px-4 py-8 sm:px-6 lg:px-8">
        <div
            class="w-full max-w-[480px] overflow-hidden rounded-xl border border-outline/20 bg-pure-white shadow-[0_4px_12px_rgba(0,0,0,0.08)]">
            <div class="p-8 md:p-12">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
