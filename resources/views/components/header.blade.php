@props([
    'title' => 'Layanan Dokumen',
    'role' => 'student',
])

@if ($role === 'student')
    <!-- Top AppBar Student -->
    <header class="h-16 bg-pure-white border-b border-outline-variant flex justify-between items-center px-container-padding sticky top-0 z-10 w-full">
        <h2 class="font-headline-sm text-headline-sm text-primary hidden md:block w-auto whitespace-nowrap">{{ $title }}</h2>
        <div class="flex items-center gap-gutter w-full justify-end">
            <div class="flex items-center gap-4 text-on-surface-variant">
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            <span>Keluar</span>
                        </button>
                    </form>
                @else
                    <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-lg text-on-surface-variant font-label-md hover:bg-surface-container transition-colors" onclick="alert('Keluar')">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        <span>Keluar</span>
                    </button>
                @endif
            </div>
        </div>
    </header>
@else
    <!-- Top Header Lecturer -->
    <header class="h-16 flex items-center justify-between px-8 bg-white border-b border-gray-200 shrink-0 sticky top-0 z-20 backdrop-blur-md bg-white/80" data-purpose="top-header">
        <div class="flex items-center">
            <!-- Hamburger Button for Mobile -->
            <button @click="sidebarOpen = true" class="md:hidden mr-4 text-gray-600 hover:text-gray-900 focus:outline-none">
                <span class="material-symbols-outlined text-2xl flex items-center justify-center">menu</span>
            </button>
            <h2 class="text-xl font-semibold text-amikom-purple">{{ $title }}</h2>
        </div>
        
        <!-- Logout Button -->
        @if (Route::has('logout'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    Logout
                </button>
            </form>
        @else
            <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm text-sm font-medium" onclick="alert('Logout action placeholder')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                Logout
            </button>
        @endif
    </header>
@endif
