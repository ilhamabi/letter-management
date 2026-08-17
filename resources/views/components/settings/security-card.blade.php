@props([
    'title' => 'Keamanan Akun',
    'description' => 'Untuk memperbaharui kata sandi, silakan isi form di bawah ini. Ketentuan: minimal 6 karakter, mengandung kombinasi huruf dan angka.',
    'actionUrl' => null,
])

<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-lg font-bold text-gray-900 font-title-lg">{{ $title }}</h4>
        <p class="text-sm text-gray-500 mt-1 font-body-sm">{{ $description }}</p>
    </div>
    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input-password 
                id="new-password" 
                name="password" 
                label="Kata Sandi Baru" 
                placeholder="••••••••" 
            />
            <x-input-password 
                id="confirm-password" 
                name="password_confirmation" 
                label="Konfirmasi Kata Sandi Baru" 
                placeholder="••••••••" 
            />
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary-container transition-colors shadow-sm font-label-md">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>

    @if ($errors->updatePassword->any())
        <x-notification 
            type="error" 
            message="{{ $errors->updatePassword->first() }}" 
        />
    @endif

    @if (session('status') === 'password-updated')
        <x-notification 
            type="success" 
            message="Kata sandi berhasil diperbarui! Anda dapat menggunakan kata sandi baru untuk masuk selanjutnya." 
        />
    @endif
</div>
