@php
    $adminName = auth()->check() ? auth()->user()->name : 'Admin';

    $stats = $stats ?? [
        'total_types' => 0,
        'active_types' => 0,
        'needs_attention' => 0,
        'total_roles' => 0,
    ];

    $recentActivities = $recentActivities ?? [];
    $topRequested = $topRequested ?? [];
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
