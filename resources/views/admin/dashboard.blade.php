@php
    $adminName = auth()->check() ? auth()->user()->name : 'Admin';

    $stats = $stats ?? [
        'total_types' => 0,
        'active_types' => 0,
        'inactive_types' => 0,
        'total_flows' => 0,
    ];

    $recentActivities = $recentActivities ?? [];
    $topRequested = $topRequested ?? [];
@endphp

@extends('layouts.admin')

@section('title', 'Admin Dashboard - Layanan Dokumen')

@section('content')
    <!-- Welcome Banner Component -->
    <x-welcome-card 
        :title="'Selamat Datang, ' . $adminName" 
        subtitle="Ringkasan Pengelolaan Jenis Surat, Template, dan Alur Persetujuan" 
    />

    <!-- Stats Components Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card 
            icon="description" 
            iconBg="bg-purple-50" 
            iconColor="text-amikom-purple" 
            title="Total Jenis Surat" 
            :value="$stats['total_types']" 
        />
        <x-stat-card 
            icon="check_circle" 
            iconBg="bg-green-50" 
            iconColor="text-green-600" 
            title="Jenis Surat Aktif" 
            :value="$stats['active_types']" 
        />
        <x-stat-card 
            icon="cancel" 
            iconBg="bg-red-50" 
            iconColor="text-red-600" 
            title="Jenis Surat Nonaktif" 
            :value="$stats['inactive_types']" 
        />
        <x-stat-card 
            icon="schema" 
            iconBg="bg-blue-50" 
            iconColor="text-blue-600" 
            title="Total Template Flow" 
            :value="$stats['total_flows']" 
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left Column: Aktivitas Terbaru (8 cols) -->
        <div class="lg:col-span-8">
            <x-admin.recent-activity-table :activities="$recentActivities" :actionUrl="route('admin.letters.index')" />
        </div>

        <!-- Right Column: Paling Sering Diajukan (4 cols) -->
        <div class="lg:col-span-4">
            <x-admin.top-requested-card :items="$topRequested" />
        </div>
    </div>
@endsection
