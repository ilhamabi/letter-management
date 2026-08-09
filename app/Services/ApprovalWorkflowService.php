<?php

namespace App\Services;

use App\Enums\SubmissionLogStatus;
use App\Enums\SubmissionStatus;
use App\Models\ApprovalFlowStep;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalWorkflowService
{
  public function __construct(
    protected SubmissionAssignmentService $assignmentService
  ) {}

  public function assignFirstApprover(
    Submission $submission
  ): void {

    $firstStep = $submission
      ->letterType
      ->approvalFlow
      ->steps()
      ->orderBy('step_order')
      ->first();

    if (! $firstStep) {
      throw new \Exception(
        'Approval flow has no steps.'
      );
    }

    $approverUserId =
      $this->assignmentService
      ->resolveApprover(
        $submission,
        $firstStep
      );

    $submission->update([
      'assigned_to_user_id' => $approverUserId,
      'approval_flow_step_id' => $firstStep->id,
      'status' => SubmissionStatus::IN_REVIEW,
    ]);
  }

  public function approve(
    Submission $submission,
    User $user,
    ?string $notes = null
  ): void {

    DB::transaction(function () use (
      $submission,
      $user,
      $notes
    ) {

      $currentStep = $submission->approvalFlowStep ?? $submission->currentStep;

      SubmissionLog::create([
        'submission_id' => $submission->id,
        'approval_flow_step_id' => $currentStep->id,
        'user_id' => $user->id,
        'status' =>  SubmissionLogStatus::APPROVED,
        'notes' => $notes,
      ]);

      $nextStep =
        $this->findNextStep(
          $submission,
          $currentStep
        );

      if (! $nextStep) {

        $submission->update([
          'status' => SubmissionStatus::APPROVED,
          'assigned_to_user_id' => null,
          'approval_flow_step_id' => null,
        ]);

        return;
      }

      $approverUserId =
        $this->assignmentService
        ->resolveApprover(
          $submission,
          $nextStep
        );

      $submission->update([
        'assigned_to_user_id' => $approverUserId,
        'approval_flow_step_id' => $nextStep->id,
      ]);
    });
  }
  public function reject(
    Submission $submission,
    User $user,
    ?string $notes = null
  ): void {

    DB::transaction(function () use (
      $submission,
      $user,
      $notes
    ) {
      SubmissionLog::create([
        'submission_id' => $submission->id,
        'approval_flow_step_id' => $submission->approval_flow_step_id,
        'user_id' => $user->id,
        'status' => SubmissionLogStatus::REJECTED,
        'notes' => $notes,
      ]);

      $submission->update([
        'status' => SubmissionStatus::REJECTED,
        'assigned_to_user_id' => null,
        'approval_flow_step_id' => null,
      ]);
    });
  }

  protected function findNextStep(
    Submission $submission,
    ApprovalFlowStep $currentStep
  ): ?ApprovalFlowStep {

    return ApprovalFlowStep::query()
      ->where(
        'approval_flow_id',
        $currentStep->approval_flow_id
      )
      ->where(
        'step_order',
        '>',
        $currentStep->step_order
      )
      ->orderBy('step_order')
      ->first();
  }
}
