<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Amikom Registry - Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap"
        rel="stylesheet">
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .bg-pattern {
            background-color: #410063;
            background-image: radial-gradient(#59207b 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="bg-surface-gray min-h-screen flex items-center justify-center font-body-md text-on-surface">
    <main
        class="w-full max-w-[480px] bg-pure-white rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.08)] flex flex-col overflow-hidden">
        <!-- Centered Login Form -->
        <div class="w-full p-8 md:p-12 flex flex-col justify-center">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img alt="Amikom Logo" class="h-16 w-auto"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPwgxwir4KI6SoWZNdKJxltvkHVQx_0luCzc3fgrPNb_X4Ugn8bIR04eM4VknpmU8CNX15KjM5BQZIo6_Q20X8KTTlxSS8LPfWRJ-4wGXXn6i4oDaFrLzCHISooOJ58JPBMI-q49ow1OriJyfl0yqIyzg8RhbAeQoJg_Lx_z-qdpFkLDJBMNBk-cPspF6SuwY4-YUXTMsgvZflrxB3f48PLjVVKCr8ZjmXfQs7bO8R8LWqncJv61LKMj5lFXVD8BfqlWTFW8GCnno">
            </div>
            <div class="mb-8 text-center">
                <h2 class="font-headline-md text-headline-md text-primary mb-2">Selamat Datang</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masuk ke akun Anda untuk
                    melanjutkan.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form action="{{ route('login') }}" class="space-y-6" method="POST">
                @csrf

                <!-- Username / Email Field -->
                <div>
                    <label class="block font-label-lg text-label-lg text-on-surface mb-2" for="username">NIK /
                        NIM</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                        </span>
                        <input
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline/30 bg-pure-white text-on-surface font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-colors"
                            id="username" name="username" value="{{ old('username') }}"
                            placeholder="Masukkan NIK atau NIM" required type="text" autofocus
                            autocomplete="username">
                    </div>
                    @if ($errors->has('username'))
                        <p class="text-sm text-error mt-1">{{ $errors->first('username') }}</p>
                    @endif
                </div>

                <div>
                    <label class="mb-2 block font-label-lg text-label-lg text-on-surface"
                        for="password">Password</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </span>
                        <input
                            class="w-full rounded-lg border border-outline/30 bg-pure-white py-3 pl-10 pr-10 font-body-md text-body-md text-on-surface transition-colors focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                            id="password" name="password" type="password" placeholder="Masukkan Password" required
                            autocomplete="current-password">
                        <button
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-outline transition-colors hover:text-primary"
                            onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined text-[20px]"
                                id="visibility-icon">visibility_off</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    class="mt-6 flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 font-label-lg text-label-lg text-on-primary transition-colors hover:bg-primary-container"
                    type="submit">
                    Login
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const icon = document.getElementById('visibility-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.textContent = 'visibility';
                } else {
                    passwordInput.type = 'password';
                    icon.textContent = 'visibility_off';
                }
            }
        </script>
    </main>
</body>
