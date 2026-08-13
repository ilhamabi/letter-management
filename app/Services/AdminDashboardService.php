<?php

namespace App\Services;

use App\Models\ApprovalFlow;
use App\Models\LetterType;

class AdminDashboardService
{
    /**
     * Get summary metrics for admin dashboard.
     */
    public function getStats(): array
    {
        return [
            'total_types' => LetterType::count(),
            'active_types' => LetterType::where('is_active', true)->count(),
            'inactive_types' => LetterType::where('is_active', false)->count(),
            'total_flows' => ApprovalFlow::count(),
        ];
    }

    /**
     * Get recent admin configuration activities (creating types, updating templates, changing flows).
     */
    public function getRecentActivities(int $limit = 5): array
    {
        $types = LetterType::with(['approvalFlow', 'activeTemplate'])
            ->latest('updated_at')
            ->limit($limit)
            ->get();

        if ($types->isEmpty()) {
            return [];
        }

        return $types->map(function ($type) {
            $isRecentlyCreated = $type->created_at && $type->updated_at && $type->created_at->diffInSeconds($type->updated_at) < 5;

            if ($isRecentlyCreated) {
                $activityLabel = 'Membuat Jenis Surat';
                $badgeClass = 'bg-green-50 text-green-700 border-green-200';
            } elseif ($type->is_active) {
                $activityLabel = 'Jenis Surat Aktif';
                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            } else {
                $activityLabel = 'Jenis Surat Nonaktif';
                $badgeClass = 'bg-red-50 text-red-700 border-red-200';
            }

            return [
                'letter_type' => $type->name . ' (' . $type->code . ')',
                'date' => $type->updated_at ? $type->updated_at->format('d M Y, H:i') : now()->format('d M Y, H:i'),
                'activity' => $activityLabel,
                'badge_class' => $badgeClass,
            ];
        })->toArray();
    }

    /**
     * Get top 3 most requested letter types.
     */
    public function getTopRequested(int $limit = 3): array
    {
        $types = LetterType::withCount('submissions')
            ->orderByDesc('submissions_count')
            ->limit($limit)
            ->get();

        $rankStyles = [
            1 => 'bg-amikom-purple text-white',
            2 => 'bg-amber-100 text-amber-800',
            3 => 'bg-blue-100 text-blue-800',
        ];

        return $types->map(function ($type, $index) use ($rankStyles) {
            $rank = $index + 1;

            return [
                'rank' => $rank,
                'name' => $type->name . ' (' . $type->code . ')',
                'count' => $type->submissions_count . ' Pengajuan',
                'rank_bg' => $rankStyles[$rank] ?? 'bg-gray-100 text-gray-600',
            ];
        })->toArray();
    }
}
