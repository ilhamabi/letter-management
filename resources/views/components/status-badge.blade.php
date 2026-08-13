@props([
    'status' => 'PENDING',
    'size' => 'md', // 'sm', 'md'
    'showIcon' => true,
])

@php
    use App\Enums\SubmissionStatus;
    use App\Enums\LetterTypeStatus;

    $letterStatusEnum = match (true) {
        $status instanceof LetterTypeStatus => $status,
        is_bool($status) => LetterTypeStatus::fromBoolean($status),
        default => null,
    };

    $statusEnum = match (true) {
        $status instanceof SubmissionStatus => $status,
        is_string($status) => SubmissionStatus::tryFrom(strtoupper(trim($status))),
        default => null,
    };

    $badgeClasses = 'inline-flex items-center rounded-full font-bold border tracking-wider transition-colors';
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-1 text-xs' : 'px-3.5 py-1.5 text-sm';
    $iconSize = $size === 'sm' ? 'w-3.5 h-3.5 mr-1' : 'w-4 h-4 mr-1.5';

    if ($letterStatusEnum) {
        $colorClasses = $letterStatusEnum->badgeClass();
        $label = $letterStatusEnum->label();
        $iconType = $letterStatusEnum->icon();
    } elseif ($statusEnum) {
        $colorClasses = $statusEnum->badgeClass();
        $label = $statusEnum->label();
        $iconType = $statusEnum->icon();
    } else {
        $normalized = strtolower(trim((string) $status));
        if (in_array($normalized, ['disetujui', 'approved', 'verified', 'completed', 'selesai'])) {
            $statusEnum = SubmissionStatus::APPROVED;
        } elseif (in_array($normalized, ['ditolak', 'rejected'])) {
            $statusEnum = SubmissionStatus::REJECTED;
        } elseif (in_array($normalized, ['aktif', 'active'])) {
            $letterStatusEnum = LetterTypeStatus::ACTIVE;
        } elseif (in_array($normalized, ['non-aktif', 'nonaktif', 'inactive'])) {
            $letterStatusEnum = LetterTypeStatus::INACTIVE;
        } else {
            $statusEnum = SubmissionStatus::PENDING;
        }

        if ($letterStatusEnum) {
            $colorClasses = $letterStatusEnum->badgeClass();
            $label = $letterStatusEnum->label();
            $iconType = $letterStatusEnum->icon();
        } else {
            $colorClasses = $statusEnum->badgeClass();
            $label = $statusEnum->label();
            $iconType = $statusEnum->icon();
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

