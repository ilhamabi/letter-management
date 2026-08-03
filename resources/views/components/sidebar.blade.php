@props([
    'role' => 'student', // 'student', 'lecturer', or 'admin'
    'userName' => null,
    'userSubtext' => null,
    'userPhoto' => null,
    'roles' => [],
])

@php
    if ($role === 'student') {
        $name = $userName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
        $subtext = $userSubtext ?? 'NIM: 21.11.9999';
        $photo = $userPhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
        
        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'student.dashboard',
                'path' => 'student/dashboard',
                'icon' => 'grid_view'
            ],
            [
                'label' => 'Buat Baru',
                'route' => 'student.submission',
                'path' => 'student/submission',
                'icon' => 'add_circle'
            ],
            [
                'label' => 'Riwayat Pengajuan',
                'route' => 'student.submission-history',
                'path' => 'student/submission-history',
                'icon' => 'history'
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => 'student.settings',
                'path' => 'student/settings',
                'icon' => 'settings'
            ]
        ];
    } elseif ($role === 'admin') {
        $name = $userName ?? (auth()->check() ? auth()->user()->name : 'Admin');
        $subtext = $userSubtext ?? 'Administrator';
        $photo = $userPhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBMizNsImUsAhQ1K0MobwV_I-xE5GJAje3rmApO43UMzs2HSAmf2BVZXm3AyvXCbW0TyVQiGNpGGQH_7zZhKQzgE-socR3g9BJVABx_IEBfzntAvOyZtgMO_tlj8GVxuL_2qNWxXtDetUKHpaysIf0n3dKfPG1eIM9EYmkaKrSEPDLsi_Yib9xlm8vTGmzkww7ib2CoLQf1OUEl8CMPS6G-eIKzYMC5EPlK5uOkKYOSDPufDRy7TRMg';
        $roleBadges = [];

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'path' => 'admin/dashboard',
                'icon' => 'dashboard',
                'active' => request()->routeIs('admin.dashboard*') || request()->is('admin/dashboard*'),
            ],
            [
                'label' => 'Manajemen Surat',
                'route' => Route::has('admin.letters') ? 'admin.letters' : 'admin.dashboard',
                'path' => 'admin/letters',
                'icon' => 'description',
                'active' => request()->routeIs('admin.letters*') || request()->is('admin/letters*'),
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => Route::has('admin.settings') ? 'admin.settings' : 'admin.dashboard',
                'path' => 'admin/settings',
                'icon' => 'settings',
                'active' => request()->routeIs('admin.settings*') || request()->is('admin/settings*'),
            ]
        ];
    } else {
        $name = $userName ?? (auth()->check() ? auth()->user()->name : 'Heri Setyawan, M.Kom.');
        $subtext = $userSubtext ?? 'NIDN: 123456789';
        $photo = $userPhoto ?? 'https://i1.pickpik.com/photos/206/134/327/teacher-lecturer-writer-counselor-626ababd87ee30e9c0eb278ac724ee0a.jpg';
        $roleBadges = !empty($roles) ? $roles : [
            ['name' => 'Kaprodi', 'bg' => 'bg-amikom-purple'],
            ['name' => 'Dosen Wali', 'bg' => 'bg-amikom-gold'],
            ['name' => 'Dosen Pembimbing', 'bg' => 'bg-amikom-green'],
        ];

        $navItems = [
            [
                'label' => 'Dashboard',
                'route' => 'lecturer.dashboard',
                'icon' => 'grid_view',
                'active' => request()->routeIs('lecturer.dashboard') || request()->is('lecturer/dashboard'),
            ],
            [
                'label' => 'Persetujuan Dokumen',
                'route' => 'lecturer.approval',
                'icon' => 'description',
                'active' => (request()->routeIs('lecturer.approval*') || request()->is('lecturer/approval*')) && !request()->routeIs('lecturer.approval-history*') && !request()->is('lecturer/approval-history*'),
            ],
            [
                'label' => 'Riwayat Persetujuan',
                'route' => 'lecturer.approval-history',
                'icon' => 'history',
                'active' => request()->routeIs('lecturer.approval-history*') || request()->is('lecturer/approval-history*'),
            ],
            [
                'label' => 'Pengaturan Akun',
                'route' => 'lecturer.settings',
                'icon' => 'settings',
                'active' => request()->routeIs('lecturer.settings*') || request()->is('lecturer/settings*'),
            ]
        ];
    }
@endphp

@if($role === 'student')
    <!-- Student SideNavBar -->
    <nav class="hidden md:flex flex-col h-screen w-sidebar-width fixed left-0 top-0 bg-pure-white border-r border-outline-variant z-20 w-[280px] pt-8">
        <div class="px-container-padding mb-12 flex items-center gap-4">
            <img alt="Universitas Amikom Logo" class="w-12 h-12 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzP5jFOS82Pd35fmnUkuGV6T1SjLrH8yph0LfAZECxQhHtrBR07hagT1GxHZ2N8-SZc2xBmiH2MP6ibJ92d9VntHHnqPwhkU-iUK_XGgHC_89n3CQkexpZ5M_hbYur0Ac4OT_sFNCmPCbhTOVAE91jJDgNVoKoYE19eI35kafYYSR_86RT-A_4wUQplxu0_3BoeglQHTQ1c1BWldP-TxTfnyDSB8et-dpbLGFKV-9-w-vqsCoqCoceEVpQFdKgqrzSowvtEzWRAGs">
            <div>
                <h1 class="font-display-lg text-title-lg text-primary leading-[1.2] font-bold uppercase tracking-tight">Universitas<br>Amikom</h1>
                <p class="font-label-sm text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mt-0.5">Student Services</p>
            </div>
        </div>
        
        <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
            @foreach($navItems as $item)
                @php
                    $isActive = $item['active'] ?? (request()->routeIs($item['route']) || request()->is($item['path']));
                @endphp
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ $isActive ? 'bg-primary text-white font-bold relative' : 'text-on-surface-variant hover:bg-surface-container' }}" href="{{ route($item['route']) }}">
                    <x-icon :name="$item['icon']" class="w-6 h-6 shrink-0" />
                    <span class="font-label-lg text-label-lg">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        
        <div class="border-t border-outline-variant bg-surface-container-low/30">
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 shrink-0">
                    <img alt="{{ $name }}" class="w-full h-full object-cover shrink-0" src="{{ $photo }}">
                </div>
                <div class="flex-1 min-w-0 overflow-hidden">
                    <p class="font-label-md text-sm text-on-surface truncate font-semibold" title="{{ $name }}">{{ $name }}</p>
                    <p class="font-label-sm text-xs text-on-surface-variant truncate" title="{{ $subtext }}">{{ $subtext }}</p>
                </div>
            </div>
        </div>
    </nav>
@else
    <!-- Lecturer Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col justify-between transition-transform duration-300 ease-in-out md:static md:translate-x-0"
           data-purpose="sidebar">
        <div>
            <!-- Logo -->
            <div class="px-6 py-8 flex items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <img alt="Universitas Amikom Logo" class="w-10 h-10 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjgUI4zaYlX51lbXCaQCgsysUwapK1PGQCi-WXmC5mHugpUw0m1Hc2HsTQTMeTSUVEj-f1a3Q8hyOCxeXdcBHRieKppabbINKUbu8GvOBrmQDltQRNBaxc43NNCNssv3V109JdKSRGK-Kditdog1qCT5qiIigPZn5NJit1sGMgQL397ZCVG-KWQcJyJ55apPJygmFqyDZtvWKPL_bJSWbI0SgnkQINZFh9cOXAHGnNEPqz2UoD24dbXC3jyQlaR3QB-SSvpo0hoh8">
                    <div>
                        <h1 class="font-headline-lg text-[18px] leading-[1.1] text-primary font-bold" style="color: rgb(65, 0, 99);">
                            UNIVERSITAS<br>AMIKOM
                        </h1>
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-medium text-gray-500">Student Services</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1" data-purpose="navigation">
                @foreach($navItems as $item)
                    @php
                        $isActive = $item['active'] ?? (request()->routeIs($item['route']) || request()->is($item['path']));
                    @endphp
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ $isActive ? 'bg-amikom-purple text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}" href="{{ route($item['route']) }}">
                        <x-icon :name="$item['icon']" class="w-6 h-6 shrink-0" />
                        <span class="font-label-lg text-label-lg">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-200 bg-white" data-purpose="user-profile">
            <div class="flex flex-col gap-2.5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 shrink-0">
                        <img alt="{{ $name }}" class="w-full h-full object-cover shrink-0" src="{{ $photo }}">
                    </div>
                    <div class="flex-1 min-w-0 overflow-hidden">
                        <p class="text-sm font-headline-lg text-gray-900 leading-tight font-bold truncate" title="{{ $name }}">{{ $name }}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">{{ $subtext }}</p>
                    </div>
                </div>
                
                @if(!empty($roleBadges))
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($roleBadges as $rb)
                            <span class="text-[10px] font-semibold text-white uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $rb['bg'] }}">{{ $rb['name'] }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </aside>
@endif
