<?php

namespace App\Services;

use App\Enums\ApproverSource;
use App\Models\ApprovalFlowStep;
use App\Models\LecturerPosition;
use App\Models\StudentLecturer;
use App\Models\Submission;
use Exception;

class SubmissionAssignmentService
{
  public function resolveApprover(
    Submission $submission,
    ApprovalFlowStep $step
  ): int {

    return match ($step->approver_source) {

      ApproverSource::STUDENT_LECTURER =>
      $this->resolveStudentLecturer(
        $submission,
        $step
      ),

      ApproverSource::LECTURER_POSITION =>
      $this->resolveLecturerPosition(
        $step
      ),
    };
  }

  protected function resolveStudentLecturer(
    Submission $submission,
    ApprovalFlowStep $step
  ): int {

    $relation = StudentLecturer::query()

      ->where(
        'student_id',
        $submission->student_id
      )

      ->where(
        'lecturer_role',
        $step->approval_role
      )

      ->where(
        'is_active',
        true
      )

      ->first();

    if (! $relation) {
      throw new Exception(
        "Approver not found from student lecturer relation."
      );
    }

    return $relation
      ->lecturer
      ->user_id;
  }

  protected function resolveLecturerPosition(
    ApprovalFlowStep $step
  ): int {

    $position = LecturerPosition::query()

      ->where(
        'position',
        $step->approval_role
      )

      ->where(
        'is_active',
        true
      )

      ->first();

    if (! $position) {
      throw new Exception(
        "Approver not found from lecturer position."
      );
    }

    return $position
      ->lecturer
      ->user_id;
  }
}
