@props([
    'role' => null,
    'size' => 'sm',
    'useFullLabel' => false,
    'showIcon' => false,
])

@php
    use App\Enums\ApprovalRole;

    $roleEnum = match (true) {
        $role instanceof ApprovalRole => $role,
        is_string($role) => ApprovalRole::tryFrom(strtoupper(trim($role))),
        default => null,
    };

    if (!$roleEnum && is_string($role)) {
        $roleUpper = strtoupper(trim($role));
        if (str_contains($roleUpper, 'KAPRODI') || str_contains($roleUpper, 'KEPALA PROGRAM')) {
            $roleEnum = ApprovalRole::HEAD_OF_STUDY_PROGRAM;
        } elseif (str_contains($roleUpper, 'WALI')) {
            $roleEnum = ApprovalRole::ACADEMIC_ADVISOR;
        } elseif (str_contains($roleUpper, 'MAGANG')) {
            $roleEnum = ApprovalRole::INTERNSHIP_SUPERVISOR;
        } elseif (str_contains($roleUpper, 'PEMBIMBING') || str_contains($roleUpper, 'SKRIPSI') || str_contains($roleUpper, 'TUGAS AKHIR')) {
            $roleEnum = ApprovalRole::THESIS_SUPERVISOR;
        }
    }

    $label = $roleEnum 
        ? ($useFullLabel ? $roleEnum->label() : $roleEnum->shortLabel()) 
        : (is_string($role) ? $role : 'Dosen Verifikator');
        
    $colorClasses = $roleEnum ? $roleEnum->badgeClass() : 'bg-amikom-purple text-white';
    $iconType = $roleEnum ? $roleEnum->icon() : 'person';
    $sizeClasses = $size === 'sm' ? 'px-3 py-1 text-xs' : 'px-3.5 py-1.5 text-sm';
    $iconSize = $size === 'sm' ? 'w-3.5 h-3.5 mr-1' : 'w-4 h-4 mr-1.5';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-semibold tracking-wider transition-colors {$sizeClasses} {$colorClasses}"]) }}>
    @if($showIcon)
        <x-icon :name="$iconType" class="{{ $iconSize }} inline shrink-0" />
    @endif
    {{ $slot->isNotEmpty() ? $slot : $label }}
</span>

