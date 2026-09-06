<?php

namespace Database\Seeders;

use App\Enums\SubmissionLogStatus;
use App\Enums\SubmissionStatus;
use App\Models\LetterType;
use App\Models\Student;
use App\Models\Submission;
use App\Models\SubmissionGroupMember;
use App\Models\SubmissionLog;
use App\Models\User;
use App\Services\ApprovalWorkflowService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $workflowService = app(ApprovalWorkflowService::class);

        $budi = Student::where('student_number', '21.01.0001')->first() ?? Student::first();
        $andi = Student::where('student_number', '21.01.0002')->first();
        $citra = Student::where('student_number', '22.01.0003')->first();
        $doni = Student::where('student_number', '22.01.0004')->first();
        $eka = Student::where('student_number', '23.01.0005')->first();

        // 3 Official Seeded Letter Types
        $typeNonReg = LetterType::where('code', 'STN')->first();
        $typeMagang = LetterType::where('code', 'SRM')->first();
        $typePendadaran = LetterType::where('code', 'SRP')->first();

        if (!$typeNonReg || !$typeMagang || !$typePendadaran) {
            return;
        }

        // 1. Pengajuan Magang (Individu) - APPROVED
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $typeMagang,
            'purpose' => 'Pelaksanaan kegiatan magang/kerja praktik di PT Telkom Indonesia',
            'additional_data' => [
                'company_name' => 'PT Telkom Indonesia (Persero) Tbk',
                'company_address' => 'Jl. Jend. Sudirman No. 52, Jakarta',
                'start_date' => '1 September 2026',
                'end_date' => '31 Desember 2026',
                'total_credits' => '92 SKS',
                'gpa' => '3.83',
            ],
            'created_at' => now()->subDays(5),
            'workflowService' => $workflowService,
            'stepsToApprove' => 1,
            'notesPerStep' => [
                'IPK dan SKS memenuhi syarat. Disetujui Dosen Wali.',
            ],
        ]);

        // 2. Pengajuan Pendadaran (Individu) - PENDING LEVEL 1
        if ($andi) {
            $this->createSubmission([
                'student' => $andi,
                'letter_type' => $typePendadaran,
                'purpose' => 'Mengikuti pendaftaran pendadaran / ujian tugas akhir semester berjalan',
                'additional_data' => [
                    'thesis_title' => 'Implementasi Machine Learning untuk Klasifikasi Dokumen Akademik',
                ],
                'created_at' => now()->subDays(2),
                'workflowService' => $workflowService,
                'stepsToApprove' => 0,
            ]);
        }

        // 3. Pengajuan TA Non-Reguler (Kelompok) - PENDING LEVEL 1
        if ($budi && $citra) {
            $this->createSubmission([
                'student' => $budi,
                'letter_type' => $typeNonReg,
                'purpose' => 'Rancang Bangun Aplikasi Manajemen Produksi di STRONGER MANUFACTURE',
                'group_name' => 'Tim Stronger Production',
                'additional_data' => [
                    'thesis_title' => 'Rancang Bangun Aplikasi Manajemen Produksi di STRONGER MANUFACTURE',
                ],
                'created_at' => now()->subDays(3),
                'members' => [$citra, $doni],
                'workflowService' => $workflowService,
                'stepsToApprove' => 0,
            ]);
        }

        // 4. Pengajuan Magang (Individu) - REJECTED LEVEL 1
        if ($eka) {
            $this->createSubmission([
                'student' => $eka,
                'letter_type' => $typeMagang,
                'purpose' => 'Kegiatan magang mandiri di Startup XYZ',
                'additional_data' => [
                    'company_name' => 'Startup XYZ Indonesia',
                    'company_address' => 'Jl. Kaliurang Km 5, Yogyakarta',
                ],
                'created_at' => now()->subDays(7),
                'workflowService' => $workflowService,
                'rejectAtStep' => 1,
                'rejectNote' => 'Jumlah SKS belum mencapai batas minimal 50 SKS.',
            ]);
        }
    }

    private function createSubmission(array $config): Submission
    {
        $student = $config['student'];
        $letterType = $config['letter_type'];
        $purpose = $config['purpose'];
        $groupName = $config['group_name'] ?? null;
        $createdAt = $config['created_at'];
        $members = array_filter($config['members'] ?? []);
        $workflowService = $config['workflowService'];
        $stepsToApprove = $config['stepsToApprove'] ?? 0;
        $rejectAtStep = $config['rejectAtStep'] ?? null;
        $notesPerStep = $config['notesPerStep'] ?? [];
        $rejectNote = $config['rejectNote'] ?? 'Pengajuan tidak memenuhi kelayakan.';

        $additionalData = $config['additional_data'] ?? null;

        return DB::transaction(function () use (
            $student, $letterType, $purpose, $groupName, $additionalData, $createdAt, $members,
            $workflowService, $stepsToApprove, $rejectAtStep, $notesPerStep, $rejectNote
        ) {
            $isGroup = count($members) > 0;

            // 1. Create Base Submission
            $submission = Submission::create([
                'student_id' => $student->id,
                'letter_type_id' => $letterType->id,
                'purpose' => $purpose,
                'group_name' => $groupName,
                'additional_data' => $additionalData,
                'status' => SubmissionStatus::PENDING,
                'submitted_at' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // 2. Attach Group Members if any
            $sort = 1;
            foreach ($members as $memberStudent) {
                if ($memberStudent) {
                    SubmissionGroupMember::create([
                        'submission_id' => $submission->id,
                        'student_id' => $memberStudent->id,
                        'sort_order' => $sort++,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                }
            }

            // 3. Create Initial Submission Log
            SubmissionLog::create([
                'submission_id' => $submission->id,
                'approval_flow_step_id' => null,
                'user_id' => $student->user_id,
                'status' => SubmissionLogStatus::APPROVED,
                'notes' => $isGroup
                    ? 'Pengajuan kelompok berhasil dibuat dan dikirim oleh ketua tim.'
                    : 'Pengajuan surat berhasil dibuat dan dikirim oleh mahasiswa.',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // 4. Assign First Approver
            $workflowService->assignFirstApprover($submission);

            // Fetch flow steps ordered by step_order
            $steps = $letterType->approvalFlow->steps()->orderBy('step_order')->get();
            $logTime = clone $createdAt;

            // 5. Progress through approval steps if configured
            $maxStep = $rejectAtStep ?? $stepsToApprove;
            for ($i = 0; $i < $maxStep; $i++) {
                if (!isset($steps[$i])) break;

                $step = $steps[$i];
                $submission->refresh();

                // Find assigned user or fallback user
                $approverUserId = $submission->assigned_to_user_id;
                $approverUser = $approverUserId ? User::find($approverUserId) : User::where('role', 'LECTURER')->first();

                $logTime = (clone $logTime)->addHours(12);

                if ($rejectAtStep !== null && ($i + 1) === $rejectAtStep) {
                    $workflowService->reject($submission, $approverUser, $rejectNote);
                    SubmissionLog::where('submission_id', $submission->id)
                        ->where('approval_flow_step_id', $step->id)
                        ->update(['created_at' => $logTime, 'updated_at' => $logTime]);
                    break;
                } else {
                    $note = $notesPerStep[$i] ?? 'Persetujuan verifikasi kelayakan dokumen.';
                    $workflowService->approve($submission, $approverUser, $note);
                    SubmissionLog::where('submission_id', $submission->id)
                        ->where('approval_flow_step_id', $step->id)
                        ->update(['created_at' => $logTime, 'updated_at' => $logTime]);
                }
            }

            return $submission;
        });
    }
}
