<?php

namespace App\Policies;

use App\Models\SubmissionAttachment;
use App\Models\User;

class SubmissionAttachmentPolicy
{
    /**
     * Determine whether the user can view the attachment.
     */
    public function view(User $user, SubmissionAttachment $attachment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        $submission = $attachment->submission;
        if (!$submission) {
            return false;
        }

        // Student authorization: owner or group member
        if ($user->isStudent() && $user->student) {
            $studentId = $user->student->id;
            if ($submission->student_id === $studentId) {
                return true;
            }

            if ($submission->groupMembers()->where('student_id', $studentId)->exists()) {
                return true;
            }
        }

        // Lecturer authorization: assigned approver or actor in logs
        if ($user->isLecturer()) {
            if ($submission->assigned_to_user_id === $user->id) {
                return true;
            }

            if ($submission->logs()->where('user_id', $user->id)->exists()) {
                return true;
            }
        }

        return false;
    }
}
