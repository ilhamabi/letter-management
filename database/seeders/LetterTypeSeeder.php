<?php

namespace Database\Seeders;

use App\Models\ApprovalFlow;
use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flow1Kaprodi = ApprovalFlow::where('name', 'Alur Approval 1-Tingkat (Kaprodi)')->first() 
            ?? ApprovalFlow::first();

        $flow2WaliKaprodi = ApprovalFlow::where('name', 'Alur Approval 2-Tingkat (Wali -> Kaprodi)')->first() 
            ?? $flow1Kaprodi;

        // 1. Surat Persetujuan Tugas Akhir Jalur Non-Reguler (Kelompok)
        LetterType::updateOrCreate(
            ['code' => 'SP-TA-NONREG'],
            [
                'approval_flow_id' => $flow2WaliKaprodi->id,
                'name' => 'Surat Persetujuan Tugas Akhir Jalur Non-Reguler',
                'description' => 'Surat persetujuan resmi pelaksanaan Tugas Akhir secara berkelompok melalui jalur non-reguler.',
                'minimum_gpa' => 2.75,
                'minimum_credits' => 80,
                'requires_attachment' => true,
                'allow_group_submission' => true,
                'is_active' => true,
            ]
        );

        // 2. Surat Rekomendasi Magang (Individu)
        LetterType::updateOrCreate(
            ['code' => 'SR-MAGANG'],
            [
                'approval_flow_id' => $flow2WaliKaprodi->id,
                'name' => 'Surat Rekomendasi Magang',
                'description' => 'Surat rekomendasi dari dosen wali untuk mahasiswa yang mengajukan kegiatan magang / kerja praktik.',
                'minimum_gpa' => 2.50,
                'minimum_credits' => 50,
                'requires_attachment' => true,
                'allow_group_submission' => false,
                'is_active' => true,
            ]
        );

        // 3. Surat Rekomendasi Pendaftaran Pendadaran (Individu)
        LetterType::updateOrCreate(
            ['code' => 'SR-PENDADARAN'],
            [
                'approval_flow_id' => $flow1Kaprodi->id,
                'name' => 'Surat Rekomendasi Pendaftaran Pendadaran',
                'description' => 'Surat rekomendasi kelayakan untuk mengikuti pendaftaran pendadaran atau ujian tugas akhir.',
                'minimum_gpa' => 2.00,
                'minimum_credits' => 100,
                'requires_attachment' => true,
                'allow_group_submission' => false,
                'is_active' => true,
            ]
        );
    }
}
