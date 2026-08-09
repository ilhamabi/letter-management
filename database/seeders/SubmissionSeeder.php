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
        $budi = Student::whereHas('user', fn($q) => $q->where('username', '20210001'))->first() ?? Student::first();
        $andi = Student::whereHas('user', fn($q) => $q->where('username', '20210002'))->first();
        $citra = Student::whereHas('user', fn($q) => $q->where('username', '20210003'))->first();

        $workflowService = app(ApprovalWorkflowService::class);

        // Fetch Letter Types
        $ska = LetterType::where('code', 'SKA')->first();
        $skm = LetterType::where('code', 'SKM')->first();
        $skl = LetterType::where('code', 'SKL')->first();
        $spp = LetterType::where('code', 'SPP')->first();
        $spkp = LetterType::where('code', 'SPKP')->first();
        $srmk = LetterType::where('code', 'SRMK')->first();
        $spta = LetterType::where('code', 'SPTA')->first();
        $sppkm = LetterType::where('code', 'SPPKM')->first();
        $sppk = LetterType::where('code', 'SPPK')->first();

        // -------------------------------------------------------------
        // WORKFLOW 1-TINGKAT
        // -------------------------------------------------------------

        // 1. SKA (1-Tingkat) - PENDING LEVEL 1
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $ska,
            'purpose' => 'Persyaratan pembuatan Kartu Tanda Mahasiswa (KTM) pengganti',
            'created_at' => now()->subDays(1),
            'workflowService' => $workflowService,
            'stepsToApprove' => 0,
        ]);

        // 2. SKM (1-Tingkat) - APPROVED
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $skm,
            'purpose' => 'Persyaratan pengajuan beasiswa prestasi akademik kampus',
            'created_at' => now()->subDays(5),
            'workflowService' => $workflowService,
            'stepsToApprove' => 1,
            'notesPerStep' => ['Penyelenggara beasiswa resmi. Pengajuan disetujui.'],
        ]);

        // 3. SKL (1-Tingkat) - REJECTED LEVEL 1
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $skl,
            'purpose' => 'Persyaratan melamar pekerjaan di instansi BUMN',
            'created_at' => now()->subDays(7),
            'workflowService' => $workflowService,
            'rejectAtStep' => 1,
            'rejectNote' => 'Transkrip nilai bebas tanggungan perpustakaan belum terverifikasi.',
        ]);

        // -------------------------------------------------------------
        // WORKFLOW 2-TINGKAT
        // -------------------------------------------------------------

        // 4. SPP (2-Tingkat) - PENDING LEVEL 1
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $spp,
            'purpose' => 'Pengantar penelitian mandiri di Dinas Komunikasi dan Informatika',
            'created_at' => now()->subDays(2),
            'workflowService' => $workflowService,
            'stepsToApprove' => 0,
        ]);

        // 5. SPKP (2-Tingkat) - PENDING LEVEL 2 (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $spkp,
            'purpose' => 'Izin pelaksanaan Kerja Praktik (KP) tim di PT Sentosa Teknologi',
            'created_at' => now()->subDays(3),
            'members' => [$andi],
            'workflowService' => $workflowService,
            'stepsToApprove' => 1,
            'notesPerStep' => ['Berkas kelayakan KP tim lengkap. Direkomendasikan.'],
        ]);

        // 6. SRMK (2-Tingkat) - APPROVED (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $srmk,
            'purpose' => 'Surat permohonan rekomendasi magang industri kelompok di PT Bukalapak',
            'created_at' => now()->subDays(10),
            'members' => [$citra],
            'workflowService' => $workflowService,
            'stepsToApprove' => 2,
            'notesPerStep' => [
                'Persyaratan SKS dan IPK seluruh anggota memenuhi kualifikasi.',
                'Surat rekomendasi magang disetujui dan dapat diterbitkan.'
            ],
        ]);

        // 7. SPKP (2-Tingkat) - REJECTED LEVEL 2 (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $spkp,
            'purpose' => 'Izin pelaksanaan Kerja Praktik tim di CV Digital Kreatif',
            'created_at' => now()->subDays(8),
            'members' => [$andi],
            'workflowService' => $workflowService,
            'rejectAtStep' => 2,
            'notesPerStep' => ['Berkas proposal awal disetujui Dosen Wali.'],
            'rejectNote' => 'Instansi tujuan Kerja Praktik belum terdaftar dalam sistem kemitraan prodi.',
        ]);

        // -------------------------------------------------------------
        // WORKFLOW 3-TINGKAT
        // -------------------------------------------------------------

        // 8. SPTA (3-Tingkat) - PENDING LEVEL 1
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $spta,
            'purpose' => 'Permohonan persetujuan judul dan pelaksanaan Tugas Akhir (Sistem Informasi Manajemen)',
            'created_at' => now()->subHours(6),
            'workflowService' => $workflowService,
            'stepsToApprove' => 0,
        ]);

        // 9. SPPKM (3-Tingkat) - PENDING LEVEL 2 (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $sppkm,
            'purpose' => 'Surat pengantar pengajuan proposal PKM-KC ke Kemendikbudristek',
            'created_at' => now()->subDays(2),
            'members' => [$citra],
            'workflowService' => $workflowService,
            'stepsToApprove' => 1,
            'notesPerStep' => ['Draft gagasan PKM sangat potensial. Disetujui Pembimbing.'],
        ]);

        // 10. SPPK (3-Tingkat) - PENDING LEVEL 3 (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $sppk,
            'purpose' => 'Pengantar proposal proyek mata kuliah Rekayasa Perangkat Lunak ke UMKM Mitra',
            'created_at' => now()->subDays(5),
            'members' => [$andi],
            'workflowService' => $workflowService,
            'stepsToApprove' => 2,
            'notesPerStep' => [
                'Proyek sesuai dengan capaian pembelajaran mata kuliah.',
                'Dosen Wali menyetujui lokasi dan alokasi tim.'
            ],
        ]);

        // 11. SPTA (3-Tingkat) - APPROVED
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $spta,
            'purpose' => 'Persetujuan judul Tugas Akhir: Perancangan Aplikasi Manajemen Surat Berbasis Microservices',
            'created_at' => now()->subDays(14),
            'workflowService' => $workflowService,
            'stepsToApprove' => 3,
            'notesPerStep' => [
                'Rumusan masalah dan metodologi penelitian Tugas Akhir disetujui Pembimbing.',
                'Syarat kelayakan akademik dan SKS dipenuhi. Disetujui Dosen Wali.',
                'Judul Tugas Akhir resmi disetujui dan dicatat oleh Prodi.'
            ],
        ]);

        // 12. SPPKM (3-Tingkat) - REJECTED LEVEL 3 (KELOMPOK)
        $this->createSubmission([
            'student' => $budi,
            'letter_type' => $sppkm,
            'purpose' => 'Surat pengantar pengajuan proposal PKM-RE kelompok ke Ditbelmawa',
            'created_at' => now()->subDays(12),
            'members' => [$citra],
            'workflowService' => $workflowService,
            'rejectAtStep' => 3,
            'notesPerStep' => [
                'Substansi riset PKM disetujui Pembimbing.',
                'Anggota tim dan administrasi disetujui Dosen Wali.'
            ],
            'rejectNote' => 'Format tata tulis proposal PKM belum sesuai dengan Pedoman Teknis Ditbelmawa 2026.',
        ]);

        // 13. SRMK (2-Tingkat) - PENDING LEVEL 2 (ANDI SEBAGAI KETUA, BUDI SEBAGAI ANGGOTA)
        if ($andi) {
            $this->createSubmission([
                'student' => $andi,
                'letter_type' => $srmk,
                'purpose' => 'Pengantar magang kelompok bidang Cyber Security di PT Cyber Defense Indonesia',
                'created_at' => now()->subDays(2),
                'members' => [$budi],
                'workflowService' => $workflowService,
                'stepsToApprove' => 1,
                'notesPerStep' => ['Kualifikasi anggota tim Magang Cyber Defense terverifikasi.'],
            ]);
        }
    }

    private function createSubmission(array $config): Submission
    {
        $student = $config['student'];
        $letterType = $config['letter_type'];
        $purpose = $config['purpose'];
        $createdAt = $config['created_at'];
        $members = array_filter($config['members'] ?? []);
        $workflowService = $config['workflowService'];
        $stepsToApprove = $config['stepsToApprove'] ?? 0;
        $rejectAtStep = $config['rejectAtStep'] ?? null;
        $notesPerStep = $config['notesPerStep'] ?? [];
        $rejectNote = $config['rejectNote'] ?? 'Pengajuan tidak memenuhi kelayakan.';

        return DB::transaction(function () use (
            $student, $letterType, $purpose, $createdAt, $members,
            $workflowService, $stepsToApprove, $rejectAtStep, $notesPerStep, $rejectNote
        ) {
            $isGroup = count($members) > 0;

            // 1. Create Base Submission
            $submission = Submission::create([
                'student_id' => $student->id,
                'letter_type_id' => $letterType->id,
                'purpose' => $purpose,
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

            // 3. Create Initial Submission Log (Creation log)
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

                // Increment timestamp for realistic timeline gap
                $logTime = (clone $logTime)->addHours(12);

                // Check if this step should reject or approve
                if ($rejectAtStep !== null && ($i + 1) === $rejectAtStep) {
                    $workflowService->reject($submission, $approverUser, $rejectNote);
                    // Backdate the generated rejection log
                    SubmissionLog::where('submission_id', $submission->id)
                        ->where('approval_flow_step_id', $step->id)
                        ->update(['created_at' => $logTime, 'updated_at' => $logTime]);
                    break;
                } else {
                    $note = $notesPerStep[$i] ?? 'Persetujuan verifikasi kelayakan dokumen.';
                    $workflowService->approve($submission, $approverUser, $note);
                    // Backdate the generated approval log
                    SubmissionLog::where('submission_id', $submission->id)
                        ->where('approval_flow_step_id', $step->id)
                        ->update(['created_at' => $logTime, 'updated_at' => $logTime]);
                }
            }

            return $submission;
        });
    }
}
