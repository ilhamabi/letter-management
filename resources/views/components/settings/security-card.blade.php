@props([
    'title' => 'Keamanan Akun',
    'description' => 'Pastikan kata sandi Anda kuat dan panjang kata sandi minimal 6 karakter.',
    'actionUrl' => null,
])

<div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col gap-6 shadow-sm">
    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-lg font-bold text-gray-900 font-title-lg">{{ $title }}</h4>
        <p class="text-sm text-gray-500 mt-1 font-body-sm">{{ $description }}</p>
    </div>
    <form @if($actionUrl) action="{{ $actionUrl }}" method="POST" @else type="button" @endif class="flex flex-col gap-4">
        @csrf
        
        <x-input-password 
            id="current-password" 
            name="current_password" 
            label="Kata Sandi Saat Ini" 
            placeholder="••••••••" 
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input-password 
                id="new-password" 
                name="new_password" 
                label="Kata Sandi Baru" 
                placeholder="••••••••" 
            />
            <x-input-password 
                id="confirm-password" 
                name="new_password_confirmation" 
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
</div>
