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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#ffdf96",
                        "surface-dim": "#dbdad9",
                        "deep-black": "#1A1A1A",
                        "surface-bright": "#fbf9f9",
                        "primary-container": "#59207b",
                        "primary": "#410063",
                        "on-tertiary-fixed": "#251a00",
                        "on-primary": "#ffffff",
                        "on-background": "#1b1c1c",
                        "tertiary": "#332500",
                        "inverse-primary": "#e5b4ff",
                        "on-tertiary-fixed-variant": "#584409",
                        "tertiary-container": "#4d3a00",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff",
                        "primary-fixed": "#f5d9ff",
                        "on-surface-variant": "#4d4450",
                        "on-surface": "#1b1c1c",
                        "on-primary-fixed": "#30004b",
                        "surface-container": "#efeded",
                        "surface-tint": "#7e45a0",
                        "surface": "#fbf9f9",
                        "surface-container-low": "#f5f3f3",
                        "pure-white": "#FFFFFF",
                        "tertiary-fixed-dim": "#e1c37d",
                        "surface-gray": "#F7F7F7",
                        "background": "#fbf9f9",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#ffe16d",
                        "on-secondary-container": "#6e5c00",
                        "inverse-on-surface": "#f2f0f0",
                        "on-tertiary-container": "#c0a461",
                        "on-primary-fixed-variant": "#642c86",
                        "secondary": "#705d00",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed": "#221b00",
                        "secondary-fixed-dim": "#e9c400",
                        "surface-container-highest": "#e3e2e2",
                        "secondary-container": "#fcd400",
                        "inverse-surface": "#303031",
                        "outline": "#7e7481",
                        "surface-variant": "#e3e2e2",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#e9e8e7",
                        "primary-fixed-dim": "#e5b4ff",
                        "on-secondary-fixed-variant": "#544600",
                        "on-primary-container": "#cc8ff0",
                        "error-container": "#ffdad6",
                        "outline-variant": "#cfc2d1"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "gutter": "24px",
                        "margin-desktop": "48px",
                        "base": "8px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "label-lg": ["Public Sans", "sans-serif"],
                        "headline-lg-mobile": ["Montserrat", "sans-serif"],
                        "body-md": ["Public Sans", "sans-serif"],
                        "body-lg": ["Public Sans", "sans-serif"],
                        "headline-md": ["Montserrat", "sans-serif"],
                        "title-lg": ["Montserrat", "sans-serif"],
                        "display-lg": ["Montserrat", "sans-serif"],
                        "body-sm": ["Public Sans", "sans-serif"],
                        "label-sm": ["Public Sans", "sans-serif"],
                        "headline-lg": ["Montserrat", "sans-serif"]
                    },
                    "fontSize": {
                        "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "title-lg": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
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
<main class="w-full max-w-[480px] bg-pure-white rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.08)] flex flex-col overflow-hidden">
    <!-- Centered Login Form -->
    <div class="w-full p-8 md:p-12 flex flex-col justify-center">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <img alt="Amikom Logo" class="h-16 w-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPwgxwir4KI6SoWZNdKJxltvkHVQx_0luCzc3fgrPNb_X4Ugn8bIR04eM4VknpmU8CNX15KjM5BQZIo6_Q20X8KTTlxSS8LPfWRJ-4wGXXn6i4oDaFrLzCHISooOJ58JPBMI-q49ow1OriJyfl0yqIyzg8RhbAeQoJg_Lx_z-qdpFkLDJBMNBk-cPspF6SuwY4-YUXTMsgvZflrxB3f48PLjVVKCr8ZjmXfQs7bO8R8LWqncJv61LKMj5lFXVD8BfqlWTFW8GCnno">
        </div>
        <div class="mb-8 text-center">
            <h2 class="font-headline-md text-headline-md text-primary mb-2">Selamat Datang</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masuk ke akun Anda untuk melanjutkan.</p>
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
                <label class="block font-label-lg text-label-lg text-on-surface mb-2" for="email">NIDN / NIM</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </span>
                    <input class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline/30 bg-pure-white text-on-surface font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-colors" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Masukkan NIDN atau NIM" 
                           required 
                           type="text" 
                           autofocus 
                           autocomplete="username">
                </div>
                @if ($errors->has('email'))
                    <p class="text-sm text-error mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password Field -->
            <div>
                <label class="block font-label-lg text-label-lg text-on-surface mb-2" for="password">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </span>
                    <input class="w-full pl-10 pr-10 py-3 rounded-lg border border-outline/30 bg-pure-white text-on-surface font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-colors" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan Password" 
                           required 
                           type="password" 
                           autocomplete="current-password">
                    <button class="absolute inset-y-0 right-0 flex items-center pr-3 text-outline hover:text-primary transition-colors" onclick="togglePassword()" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="visibility-icon">visibility_off</span>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <p class="text-sm text-error mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Submit Button -->
            <button class="w-full bg-primary hover:bg-primary-container text-on-primary font-label-lg text-label-lg py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 mt-6" type="submit">
                Login
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>
    </div>
</main>
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
</body>
</html>
