@php
    // Default / Mock data in case variables aren't passed from controller or view
    $adminName = $adminName ?? (auth()->check() ? auth()->user()->name : 'Admin');

    $stats = $stats ?? [
        'total_types' => 24,
        'active_types' => 18,
        'needs_attention' => 6,
        'total_roles' => 3,
    ];

    $recentActivities = $recentActivities ?? [
        [
            'letter_type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
            'admin' => 'Super Admin',
            'date' => 'Hari ini, 10:42',
            'change' => 'Update Template',
            'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
        ],
        [
            'letter_type' => 'Surat Rekomendasi Magang',
            'admin' => 'Admin Akademik',
            'date' => 'Kemarin, 15:20',
            'change' => 'Ubah Alur',
            'badge_class' => 'bg-gray-100 text-gray-700 border-gray-200',
        ],
        [
            'letter_type' => 'Surat Rekomendasi Pendaftaran Pendadaran',
            'admin' => 'Admin Akademik',
            'date' => '12 Okt 2023',
            'change' => 'Nonaktifkan',
            'badge_class' => 'bg-red-50 text-red-700 border-red-200',
        ],
        [
            'letter_type' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
            'admin' => 'Super Admin',
            'date' => '10 Okt 2023',
            'change' => 'Buat Baru',
            'badge_class' => 'bg-green-50 text-green-700 border-green-200',
        ],
    ];

    $topRequested = $topRequested ?? [
        [
            'rank' => 1,
            'name' => 'Surat Persetujuan TA Non-Reguler',
            'count' => '142 Pengajuan',
            'percentage' => 85,
            'color' => 'bg-amikom-purple',
            'rank_bg' => 'bg-blue-100 text-blue-700',
        ],
        [
            'rank' => 2,
            'name' => 'Surat Rekomendasi Magang',
            'count' => '98 Pengajuan',
            'percentage' => 60,
            'color' => 'bg-amikom-gold',
            'rank_bg' => 'bg-gray-100 text-gray-600',
        ],
        [
            'rank' => 3,
            'name' => 'Surat Rekomendasi Pendadaran',
            'count' => '56 Pengajuan',
            'percentage' => 35,
            'color' => 'bg-gray-400',
            'rank_bg' => 'bg-gray-100 text-gray-600',
        ],
    ];
@endphp

@extends('layouts.admin')

@section('title', 'Admin Dashboard - Amikom Document Services')

@section('content')
    <!-- Welcome Banner Component -->
    <x-welcome-card 
        :title="'Selamat Datang, ' . $adminName" 
        subtitle="Ringkasan Sistem Layanan Dokumen" 
    />

    <!-- Stats Components Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card 
            icon="description" 
            iconBg="bg-blue-50" 
            iconColor="text-blue-600" 
            title="Total Jenis Surat" 
            :value="$stats['total_types']" 
        />
        <x-stat-card 
            icon="check_circle" 
            iconBg="bg-green-50" 
            iconColor="text-green-600" 
            title="Surat Aktif" 
            :value="$stats['active_types']" 
        />
        <x-stat-card 
            icon="warning" 
            iconBg="bg-red-50" 
            iconColor="text-red-600" 
            title="Perlu Perhatian" 
            :value="$stats['needs_attention']" 
            class="border-l-4 border-l-red-500"
        />
        <x-stat-card 
            icon="groups" 
            iconBg="bg-gray-100" 
            iconColor="text-gray-600" 
            title="Total Peran Terlibat" 
            :value="$stats['total_roles']" 
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left Column: Aktivitas Terbaru (8 cols) -->
        <div class="lg:col-span-8">
            <x-admin.recent-activity-table :activities="$recentActivities" />
        </div>

        <!-- Right Column: Paling Sering Diajukan (4 cols) -->
        <div class="lg:col-span-4">
            <x-admin.top-requested-card :items="$topRequested" />
        </div>
    </div>
@endsection
