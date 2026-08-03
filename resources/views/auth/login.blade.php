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
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface-gray min-h-screen flex items-center justify-center text-on-surface">
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
                <h2 class="text-2xl font-bold text-primary mb-2">Selamat Datang</h2>
                <p class="text-sm text-on-surface-variant">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" class="space-y-6" method="POST">
                @csrf

                <!-- Username / Email Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="username">NIK / NIM</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline pointer-events-none">
                            <x-icon name="person" class="w-5 h-5" />
                        </span>
                        <input
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline/30 bg-pure-white text-on-surface text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-colors"
                            id="username" name="username" value="{{ old('username') }}"
                            placeholder="Masukkan NIK atau NIM" required type="text" autofocus
                            autocomplete="username">
                    </div>
                    @if ($errors->has('username'))
                        <p class="text-sm text-error mt-1">{{ $errors->first('username') }}</p>
                    @endif
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="password">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline pointer-events-none">
                            <x-icon name="lock" class="w-5 h-5" />
                        </span>
                        <input
                            class="w-full pl-10 pr-10 py-3 rounded-lg border border-outline/30 bg-pure-white text-on-surface text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-colors"
                            id="password" name="password" placeholder="Masukkan Password" required type="password"
                            autocomplete="current-password">
                        <button
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-outline hover:text-primary transition-colors"
                            onclick="togglePassword()" type="button" aria-label="Toggle password visibility">
                            <span id="visibility-icon" class="flex items-center justify-center">
                                <x-icon name="visibility_off" class="w-5 h-5" />
                            </span>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <p class="text-sm text-error mt-1">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Submit Button -->
                <button
                    class="w-full bg-primary hover:bg-primary-container text-on-primary font-semibold text-sm py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 mt-6 shadow-sm"
                    type="submit">
                    Login
                    <x-icon name="arrow_forward" class="w-4 h-4" />
                </button>
            </form>
        </div>
    </main>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const iconContainer = document.getElementById('visibility-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
            } else {
                passwordInput.type = 'password';
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
            }
        }
    </script>
</body>

</html>
