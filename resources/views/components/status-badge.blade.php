@props([
    'status' => 'PENDING',
    'size' => 'md', // 'sm', 'md'
    'showIcon' => true,
])

@php
    use App\Enums\SubmissionStatus;

    $statusEnum = match (true) {
        $status instanceof SubmissionStatus => $status,
        is_string($status) => SubmissionStatus::tryFrom(strtoupper(trim($status))),
        default => null,
    };

    $badgeClasses = 'inline-flex items-center rounded-full font-bold border tracking-wider transition-colors';
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-1 text-xs' : 'px-3.5 py-1.5 text-sm';
    $iconSize = $size === 'sm' ? 'w-3.5 h-3.5 mr-1' : 'w-4 h-4 mr-1.5';

    if ($statusEnum) {
        $colorClasses = $statusEnum->badgeClass();
        $label = $statusEnum->label();
        $iconType = match ($statusEnum) {
            SubmissionStatus::APPROVED, SubmissionStatus::GENERATED => 'check_circle',
            SubmissionStatus::REJECTED => 'cancel',
            default => 'clock',
        };
    } else {
        $normalized = strtolower(trim((string) $status));
        if (in_array($normalized, ['disetujui', 'approved', 'verified', 'completed', 'selesai', 'aktif', 'active'])) {
            $colorClasses = 'bg-green-100 text-green-800 border-green-200';
            $label = in_array($normalized, ['aktif', 'active']) ? 'Aktif' : 'Disetujui';
            $iconType = 'check_circle';
        } elseif (in_array($normalized, ['ditolak', 'rejected', 'non-aktif', 'nonaktif', 'inactive'])) {
            $colorClasses = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'bg-gray-100 text-gray-500 border-gray-200' : 'bg-red-100 text-red-800 border-red-200';
            $label = in_array($normalized, ['non-aktif', 'nonaktif', 'inactive']) ? 'Non-Aktif' : 'Ditolak';
            $iconType = 'cancel';
        } elseif (in_array($normalized, ['revisi', 'revision', 'perlu revisi', 'needs_revision'])) {
            $colorClasses = 'bg-amber-100 text-amber-800 border-amber-200';
            $label = 'Perlu Revisi';
            $iconType = 'warning';
        } else {
            $colorClasses = 'bg-gray-100 text-gray-700 border-gray-200';
            $label = in_array($normalized, ['menunggu', 'pending', 'menunggu persetujuan', 'sedang diproses', 'proses']) ? 'Menunggu' : ucwords((string) $status);
            $iconType = 'clock';
        }
    }
@endphp

<span {{ $attributes->merge(['class' => "{$badgeClasses} {$sizeClasses} {$colorClasses}"]) }}>
@if ($slot->isNotEmpty())
    {{ $slot }}
@else
    @if ($showIcon)
        <x-icon :name="$iconType" class="{{ $iconSize }} inline shrink-0" />
    @endif
            {{ $label }}
@endif
</span>
