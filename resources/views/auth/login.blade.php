<x-guest-layout>
    <div class="flex flex-col justify-center">
        <div class="mb-8 flex justify-center">
            <img alt="Amikom Logo" class="h-16 w-auto"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPwgxwir4KI6SoWZNdKJxltvkHVQx_0luCzc3fgrPNb_X4Ugn8bIR04eM4VknpmU8CNX15KjM5BQZIo6_Q20X8KTTlxSS8LPfWRJ-4wGXXn6i4oDaFrLzCHISooOJ58JPBMI-q49ow1OriJyfl0yqIyzg8RhbAeQoJg_Lx_z-qdpFkLDJBMNBk-cPspF6SuwY4-YUXTMsgvZflrxB3f48PLjVVKCr8ZjmXfQs7bO8R8LWqncJv61LKMj5lFXVD8BfqlWTFW8GCnno">
        </div>

        <div class="mb-8 text-center">
            <h2 class="mb-2 font-headline-md text-headline-md text-primary">Selamat Datang</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masuk ke akun Anda untuk melanjutkan.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form action="{{ route('login') }}" class="space-y-6" method="POST">
            @csrf

            <div>
                <label class="mb-2 block font-label-lg text-label-lg text-on-surface" for="email">NIK / NIM</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </span>
                    <input
                        class="w-full rounded-lg border border-outline/30 bg-pure-white py-3 pl-10 pr-4 font-body-md text-body-md text-on-surface transition-colors focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        id="username" name="username" type="text" value="{{ old('username') }}"
                        placeholder="Masukkan NIK atau NIM" required autofocus autocomplete="username">
                </div>
                @error('username')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block font-label-lg text-label-lg text-on-surface" for="password">Password</label>
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
                        <span class="material-symbols-outlined text-[20px]" id="visibility-icon">visibility_off</span>
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
</x-guest-layout>
