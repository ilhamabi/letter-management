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

        // 2. Flow 1-Tingkat: Kaprodi
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

        // 3. Flow 2-Tingkat: Dosen Wali -> Kaprodi
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

        // 4. Flow 2-Tingkat: Dosen Pembimbing Magang -> Kaprodi
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

        // 5. Flow 3-Tingkat: Dosen Pembimbing Skripsi -> Dosen Wali -> Kaprodi
        $flow3Skripsi = ApprovalFlow::create([
            'name' => 'Alur Approval 3-Tingkat (Pembimbing Skripsi -> Wali -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Skripsi->id,
            'name' => 'Persetujuan Dosen Pembimbing Skripsi/TA',
            'approval_role' => ApprovalRole::THESIS_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Skripsi->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 2,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Skripsi->id,
            'name' => 'Persetujuan Kepala Program Studi',
            'approval_role' => ApprovalRole::HEAD_OF_STUDY_PROGRAM,
            'approver_source' => ApproverSource::LECTURER_POSITION,
            'step_order' => 3,
        ]);

        // 6. Flow 3-Tingkat: Dosen Pembimbing Magang -> Dosen Wali -> Kaprodi
        $flow3Magang = ApprovalFlow::create([
            'name' => 'Alur Approval 3-Tingkat (Pembimbing Magang -> Wali -> Kaprodi)',
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Persetujuan Dosen Pembimbing Magang',
            'approval_role' => ApprovalRole::INTERNSHIP_SUPERVISOR,
            'approver_source' => ApproverSource::STUDENT_LECTURER,
            'step_order' => 1,
        ]);
        ApprovalFlowStep::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Persetujuan Dosen Wali',
            'approval_role' => ApprovalRole::ACADEMIC_ADVISOR,
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
    }
}
