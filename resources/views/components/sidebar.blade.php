@props([
    'roles' => [],
    'userName' => null,
    'userSubtext' => null,
    'userPhoto' => null,
    'variant' => 'lecturer', // 'lecturer', 'student', or 'admin'
    'role' => null,
])

@php
    $effectiveRole = strtolower((string) ($role ?? $variant));

    if ($effectiveRole === 'admin') {
        $subhead = 'System Administrator';
        $user = auth()->user();
        $name = $userName ?? ($user?->name ?? 'Admin Portal');
        $subtext = $userSubtext ?? 'Administrator';
        $photo = $userPhoto ?? null;

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'path' => 'admin/dashboard',
                'icon' => 'grid_view',
                'active' => request()->routeIs('admin.dashboard') || request()->is('admin/dashboard'),
            ],
            [
                'label' => 'Manajemen Surat',
                'route' => 'admin.letters.index',
                'path' => 'admin/letters',
                'icon' => 'description',
                'active' => request()->routeIs('admin.letters*') || request()->is('admin/letters*'),
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => 'admin.settings',
                'path' => 'admin/settings',
                'icon' => 'settings',
                'active' => request()->routeIs('admin.settings*') || request()->is('admin/settings*'),
            ]
        ];
    } elseif ($effectiveRole === 'student') {
        $subhead = 'Student Services';
        $user = auth()->user();
        $name = $userName ?? ($user?->name ?? 'Mahasiswa');
        $nim = $user?->student?->student_number ?? $user?->username ?? '-';
        $subtext = $userSubtext ?? ('NIM: ' . $nim);
        $photo = $userPhoto ?? null;

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'student.dashboard',
                'path' => 'student/dashboard',
                'icon' => 'grid_view',
                'active' => request()->routeIs('student.dashboard') || request()->is('student/dashboard'),
            ],
            [
                'label' => 'Buat Baru',
                'route' => 'student.submissions.create',
                'path' => 'student/submissions/create',
                'icon' => 'add_circle',
                'active' => request()->routeIs('student.submissions.create*'),
            ],
            [
                'label' => 'Riwayat Pengajuan',
                'route' => 'student.submissions.history',
                'path' => 'student/submissions',
                'icon' => 'history',
                'active' => request()->routeIs('student.submissions.history*') || request()->is('student/submissions'),
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => 'student.settings',
                'path' => 'student/settings',
                'icon' => 'settings',
                'active' => request()->routeIs('student.settings*') || request()->is('student/settings*'),
            ],
        ];
    } else {
        $subhead = 'Lecturer Services';
        $user = auth()->user();
        $name = $userName ?? ($user?->name ?? 'Heri Setyawan, M.Kom.');
        $nidn = $user?->lecturer?->national_lecturer_number ?? $user?->username ?? '123456789';
        $subtext = $userSubtext ?? ('NIDN: ' . $nidn);
        $photo = $userPhoto ?? null;

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'lecturer.dashboard',
                'path' => 'lecturer/dashboard',
                'icon' => 'grid_view',
                'active' => request()->routeIs('lecturer.dashboard') || request()->is('lecturer/dashboard'),
            ],
            [
                'label' => 'Persetujuan Dokumen',
                'route' => 'lecturer.submissions.index',
                'path' => 'lecturer/submissions',
                'icon' => 'description',
                'active' => request()->routeIs('lecturer.submissions.index*') || request()->is('lecturer/submissions'),
            ],
            [
                'label' => 'Riwayat Persetujuan',
                'route' => 'lecturer.submissions.history',
                'path' => 'lecturer/submissions/history',
                'icon' => 'history',
                'active' => request()->routeIs('lecturer.submissions.history*') || request()->is('lecturer/history*'),
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => 'lecturer.settings',
                'path' => 'lecturer/settings',
                'icon' => 'settings',
                'active' => request()->routeIs('lecturer.settings*') || request()->is('lecturer/settings*'),
            ],
        ];
    }
@endphp

<!-- Unified SideNavBar Component -->
<aside x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-40 w-64 bg-pure-white border-r border-outline-variant flex flex-col justify-between transition-transform duration-300 ease-in-out md:static md:translate-x-0 shrink-0"
       data-purpose="sidebar">
    <div>
        <!-- Standardized Logo Header -->
        <div class="px-6 py-8 flex items-center gap-4 mb-6">
            <div class="flex items-center gap-3">
                <img alt="Universitas Amikom Logo" class="w-10 h-10 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs">
                <div>
                    <h1 class="font-headline-lg text-[18px] leading-[1.1] text-primary font-bold" style="color: rgb(65, 0, 99);">
                        UNIVERSITAS<br>AMIKOM
                    </h1>
                    <p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">{{ $subhead }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
            @foreach($navItems as $item)
                @php
                    $isActive = $item['active'] ?? (request()->routeIs($item['route'] ?? '') || request()->is($item['path'] ?? ''));
                @endphp
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ $isActive ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route($item['route']) }}">
                    <x-icon :name="$item['icon']" class="w-6 h-6 shrink-0 pointer-events-none" />
                    <span class="font-label-lg text-label-lg pointer-events-none">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- User Profile Footer -->
    <div class="p-4 border-t border-outline-variant bg-surface-container-low/30" data-purpose="user-profile">
        <div class="flex flex-col gap-2.5">
            <div class="flex items-center gap-3">
                @if(!empty($photo) && filter_var($photo, FILTER_VALIDATE_URL))
                    <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 shrink-0">
                        <img alt="{{ $name }}" class="w-full h-full object-cover shrink-0" src="{{ $photo }}">
                    </div>
                @else
                    <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center border border-purple-200 text-amikom-purple shrink-0">
                        <x-icon name="person" class="w-6 h-6 text-amikom-purple" />
                    </div>
                @endif
                <div class="flex-1 min-w-0 overflow-hidden">
                    <p class="font-headline-lg text-sm text-on-surface leading-tight font-bold truncate" title="{{ $name }}">{{ $name }}</p>
                    <p class="font-label-sm text-xs text-on-surface-variant truncate mt-0.5" title="{{ $subtext }}">{{ $subtext }}</p>
                </div>
            </div>

            @if(!empty($roles))
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($roles as $rb)
                        <x-role-badge :role="$rb['code'] ?? $rb['name']" size="sm" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</aside>
