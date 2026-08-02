@props([
    'status' => 'PENDING',
    'size' => 'md', // 'sm', 'md'
])

@php
    $normalized = strtolower(trim($status));
    
    $badgeClasses = 'inline-flex items-center rounded-full font-bold border tracking-wider transition-colors';
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-1 text-xs' : 'px-3.5 py-1.5 text-sm';

    if (in_array($normalized, ['disetujui', 'approved', 'verified', 'completed', 'selesai', 'aktif', 'active'])) {
        $colorClasses = 'bg-green-100 text-green-800 border-green-200';
        $label = in_array($normalized, ['aktif', 'active']) ? 'Aktif' : 'Disetujui';
    } elseif (in_array($normalized, ['ditolak', 'rejected', 'non-aktif', 'nonaktif', 'inactive'])) {
        $colorClasses = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'bg-gray-100 text-gray-500 border-gray-200' : 'bg-red-100 text-red-800 border-red-200';
        $label = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'Non-Aktif' : 'Ditolak';
    } elseif (in_array($normalized, ['revisi', 'revision', 'perlu revisi', 'needs_revision'])) {
        $colorClasses = 'bg-amber-100 text-amber-800 border-amber-200';
        $label = 'Perlu Revisi';
    } else {
        // Pending / Menunggu / Proses
        $colorClasses = 'bg-gray-100 text-gray-700 border-gray-200';
        $label = in_array($normalized, ['menunggu', 'pending', 'menunggu persetujuan', 'sedang diproses', 'proses']) ? 'Menunggu' : ucwords($status);
    }
@endphp

<span {{ $attributes->merge(['class' => "{$badgeClasses} {$sizeClasses} {$colorClasses}"]) }}>
    {{ $slot->isEmpty() ? $label : $slot }}
</span>
