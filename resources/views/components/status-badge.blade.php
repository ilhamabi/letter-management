@props([
    'status' => 'PENDING',
    'size' => 'md', // 'sm', 'md'
    'showIcon' => true,
])

@php
    $normalized = strtolower(trim($status));
    
    $badgeClasses = 'inline-flex items-center rounded-full font-bold border tracking-wider transition-colors';
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-1 text-xs' : 'px-3.5 py-1.5 text-sm';
    $iconSize = $size === 'sm' ? 'w-3.5 h-3.5 mr-1' : 'w-4 h-4 mr-1.5';

    if (in_array($normalized, ['disetujui', 'approved', 'verified', 'completed', 'selesai', 'aktif', 'active'])) {
        $colorClasses = 'bg-green-100 text-green-800 border-green-200';
        $label = in_array($normalized, ['aktif', 'active']) ? 'Aktif' : 'Disetujui';
        $iconType = 'check';
    } elseif (in_array($normalized, ['ditolak', 'rejected', 'non-aktif', 'nonaktif', 'inactive'])) {
        $colorClasses = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'bg-gray-100 text-gray-500 border-gray-200' : 'bg-red-100 text-red-800 border-red-200';
        $label = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'Non-Aktif' : 'Ditolak';
        $iconType = 'cancel';
    } elseif (in_array($normalized, ['revisi', 'revision', 'perlu revisi', 'needs_revision'])) {
        $colorClasses = 'bg-amber-100 text-amber-800 border-amber-200';
        $label = 'Perlu Revisi';
        $iconType = 'warning';
    } else {
        // Pending / Menunggu / Proses
        $colorClasses = 'bg-gray-100 text-gray-700 border-gray-200';
        $label = in_array($normalized, ['menunggu', 'pending', 'menunggu persetujuan', 'sedang diproses', 'proses']) ? 'Menunggu' : ucwords($status);
        $iconType = 'clock';
    }
@endphp

<span {{ $attributes->merge(['class' => "{$badgeClasses} {$sizeClasses} {$colorClasses}"]) }}>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        @if ($showIcon)
            @if ($iconType === 'check')
                <svg class="{{ $iconSize }} stroke-current inline shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @elseif ($iconType === 'cancel')
                <svg class="{{ $iconSize }} stroke-current inline shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @elseif ($iconType === 'warning')
                <svg class="{{ $iconSize }} stroke-current inline shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @else
                <svg class="{{ $iconSize }} stroke-current inline shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        @endif
        {{ $label }}
    @endif
</span>
