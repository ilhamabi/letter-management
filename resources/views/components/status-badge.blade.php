@props([
    'status' => 'PENDING',
    'size' => 'md', // 'sm', 'md'
])

@php
    $normalized = strtolower(trim($status));
    
    $badgeClasses = 'inline-flex items-center rounded-full font-semibold border tracking-wider transition-colors';
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-0.5 text-[10px]' : 'px-3 py-1 text-xs';

    if (in_array($normalized, ['disetujui', 'approved', 'verified', 'completed', 'selesai'])) {
        $colorClasses = 'bg-green-100 text-green-800 border-green-200';
        $label = 'Disetujui';
    } elseif (in_array($normalized, ['ditolak', 'rejected'])) {
        $colorClasses = 'bg-red-100 text-red-800 border-red-200';
        $label = 'Ditolak';
    } elseif (in_array($normalized, ['revisi', 'revision', 'perlu revisi', 'needs_revision'])) {
        $colorClasses = 'bg-amber-100 text-amber-800 border-amber-200';
        $label = 'Perlu Revisi';
    } else {
        // Pending / Menunggu / Proses
        $colorClasses = 'bg-purple-100 text-purple-800 border-purple-200';
        $label = (in_array($normalized, ['menunggu', 'pending']) ? 'Menunggu Persetujuan' : ucwords($status));
    }
@endphp

<span {{ $attributes->merge(['class' => "{$badgeClasses} {$sizeClasses} {$colorClasses}"]) }}>
    {{ $slot->isEmpty() ? $label : $slot }}
</span>
