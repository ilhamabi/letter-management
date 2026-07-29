<?php

namespace Database\Seeders;

use App\Enums\ApprovalRole;
use App\Enums\ApproverSource;
use App\Models\ApprovalFlow;
use App\Models\ApprovalFlowStep;
use Illuminate\Database\Seeder;

class ApprovalFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flow = ApprovalFlow::create([
            'name' => 'Certificate of Active Study Flow',
        ]);

        ApprovalFlowStep::create([
            'approval_flow_id' => $flow->id,
            'name' => 'Academic Advisor Approval',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);

        ApprovalFlowStep::create([
            'approval_flow_id' => $flow->id,
            'name' => 'Head of Study Program Approval',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 2,
        ]);
    }
}
