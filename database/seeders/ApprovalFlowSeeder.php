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
        // -------------------------------------------------------------
        // 1-TINGKAT APPROVAL FLOWS
        // -------------------------------------------------------------

        // 1. Flow 1-Tingkat: Dosen Wali
        $flow1Wali = ApprovalFlow::create([
            'name' => 'Alur Approval 1-Tingkat (Dosen Wali)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow1Wali->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);

        // 2. Flow 1-Tingkat: Dosen Pembimbing Magang
        $flow1Magang = ApprovalFlow::create([
            'name' => 'Alur Approval 1-Tingkat (Dosen Pembimbing Magang)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow1Magang->id,
            'name' => 'Persetujuan Dosen Pembimbing Magang',
            'approval_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);

        // 3. Flow 1-Tingkat: Dosen Pembimbing TA
        $flow1TA = ApprovalFlow::create([
            'name' => 'Alur Approval 1-Tingkat (Dosen Pembimbing TA)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow1TA->id,
            'name' => 'Persetujuan Dosen Pembimbing TA',
            'approval_role' => ApprovalRole::THESIS_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);

        // 4. Flow 1-Tingkat: Kaprodi
        $flow1Kaprodi = ApprovalFlow::create([
            'name' => 'Alur Approval 1-Tingkat (Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow1Kaprodi->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 1,
        ]);

        // -------------------------------------------------------------
        // 2-TINGKAT APPROVAL FLOWS
        // -------------------------------------------------------------

        // 5. Flow 2-Tingkat: Dosen Wali -> Kaprodi
        $flow2WaliKaprodi = ApprovalFlow::create([
            'name' => 'Alur Approval 2-Tingkat (Wali -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliKaprodi->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliKaprodi->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 2,
        ]);

        // 6. Flow 2-Tingkat: Dosen Pembimbing Magang -> Kaprodi
        $flow2MagangKaprodi = ApprovalFlow::create([
            'name' => 'Alur Approval 2-Tingkat (Pembimbing Magang -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2MagangKaprodi->id,
            'name' => 'Persetujuan Dosen Pembimbing Magang',
            'approval_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2MagangKaprodi->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 2,
        ]);

        // 7. Flow 2-Tingkat: Dosen Pembimbing TA -> Kaprodi
        $flow2TAKaprodi = ApprovalFlow::create([
            'name' => 'Alur Approval 2-Tingkat (Pembimbing TA -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2TAKaprodi->id,
            'name' => 'Persetujuan Dosen Pembimbing TA',
            'approval_role' => ApprovalRole::THESIS_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2TAKaprodi->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 2,
        ]);

        // 8. Flow 2-Tingkat: Dosen Wali -> Dosen Pembimbing Magang (NEW)
        $flow2WaliMagang = ApprovalFlow::create([
            'name' => 'Alur Approval 2-Tingkat (Wali -> Pembimbing Magang)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliMagang->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliMagang->id,
            'name' => 'Persetujuan Dosen Pembimbing Magang',
            'approval_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 2,
        ]);

        // 9. Flow 2-Tingkat: Dosen Wali -> Dosen Pembimbing TA (NEW)
        $flow2WaliTA = ApprovalFlow::create([
            'name' => 'Alur Approval 2-Tingkat (Wali -> Pembimbing TA)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliTA->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow2WaliTA->id,
            'name' => 'Persetujuan Dosen Pembimbing TA',
            'approval_role' => ApprovalRole::THESIS_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 2,
        ]);

        // -------------------------------------------------------------
        // 3-TINGKAT APPROVAL FLOWS (Wali -> Pembimbing -> Kaprodi)
        // -------------------------------------------------------------

        // 10. Flow 3-Tingkat: Dosen Wali -> Dosen Pembimbing Magang -> Kaprodi
        $flow3Magang = ApprovalFlow::create([
            'name' => 'Alur Approval 3-Tingkat (Wali -> Pembimbing Magang -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Persetujuan Dosen Pembimbing Magang',
            'approval_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 2,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 3,
        ]);

        // 11. Flow 3-Tingkat: Dosen Wali -> Dosen Pembimbing TA -> Kaprodi
        $flow3TA = ApprovalFlow::create([
            'name' => 'Alur Approval 3-Tingkat (Wali -> Pembimbing TA -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3TA->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3TA->id,
            'name' => 'Persetujuan Dosen Pembimbing TA/Skripsi',
            'approval_role' => ApprovalRole::THESIS_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 2,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3TA->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 3,
        ]);
    }
}
