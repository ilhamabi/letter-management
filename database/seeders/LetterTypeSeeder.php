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
        $flow1Wali = ApprovalFlow::where('name', 'Alur Approval 1-Tingkat (Dosen Wali)')->first();
        $flow1Kaprodi = ApprovalFlow::where('name', 'Alur Approval 1-Tingkat (Kaprodi)')->first();
        $flow2WaliKaprodi = ApprovalFlow::where('name', 'Alur Approval 2-Tingkat (Wali -> Kaprodi)')->first();
        $flow2MagangKaprodi = ApprovalFlow::where('name', 'Alur Approval 2-Tingkat (Pembimbing Magang -> Kaprodi)')->first();
        $flow3Skripsi = ApprovalFlow::where('name', 'Alur Approval 3-Tingkat (Pembimbing Skripsi -> Wali -> Kaprodi)')->first();
        $flow3Magang = ApprovalFlow::where('name', 'Alur Approval 3-Tingkat (Pembimbing Magang -> Wali -> Kaprodi)')->first();

        // --- 1. WORKFLOW 1 TINGKAT ---

        // 1. Surat Keterangan Mahasiswa (SKM) - 1-Tingkat Wali (Individu)
        LetterType::create([
            'approval_flow_id' => $flow1Wali->id,
            'name' => 'Surat Keterangan Mahasiswa',
            'code' => 'SKM',
            'description' => 'Surat keterangan status umum mahasiswa untuk keanggotaan/beasiswa (1-Tingkat Approval: Dosen Wali).',
            'minimum_gpa' => null,
            'minimum_credits' => null,
            'requires_attachment' => false,
            'allow_group_submission' => false,
            'is_active' => true,
        ]);

        // 2. Surat Keterangan Aktif Kuliah (SKA) - 1-Tingkat Wali (Individu)
        LetterType::create([
            'approval_flow_id' => $flow1Wali->id,
            'name' => 'Surat Keterangan Aktif Kuliah',
            'code' => 'SKA',
            'description' => 'Surat keterangan resmi yang menyatakan mahasiswa aktif dalam perkuliahan (1-Tingkat Approval: Dosen Wali).',
            'minimum_gpa' => null,
            'minimum_credits' => null,
            'requires_attachment' => false,
            'allow_group_submission' => false,
            'is_active' => true,
        ]);

        // 3. Surat Keterangan Lulus (SKL) - 1-Tingkat Kaprodi (Individu)
        LetterType::create([
            'approval_flow_id' => $flow1Kaprodi->id,
            'name' => 'Surat Keterangan Lulus',
            'code' => 'SKL',
            'description' => 'Surat keterangan resmi yang menyatakan mahasiswa telah memenuhi kelulusan (1-Tingkat Approval: Kaprodi).',
            'minimum_gpa' => 2.00,
            'minimum_credits' => 110,
            'requires_attachment' => true,
            'allow_group_submission' => false,
            'is_active' => true,
        ]);


        // --- 2. WORKFLOW 2 TINGKAT ---

        // 4. Surat Rekomendasi Magang Kelompok (SRMK) - 2-Tingkat Wali->Kaprodi (Kelompok)
        LetterType::create([
            'approval_flow_id' => $flow2WaliKaprodi->id,
            'name' => 'Surat Rekomendasi Magang Kelompok',
            'code' => 'SRMK',
            'description' => 'Surat permohonan pengantar magang atau PKL secara berkelompok/tim (2-Tingkat Approval: Dosen Wali -> Kaprodi).',
            'minimum_gpa' => 2.75,
            'minimum_credits' => 80,
            'requires_attachment' => true,
            'allow_group_submission' => true,
            'is_active' => true,
        ]);

        // 5. Surat Pengantar Penelitian (SPP) - 2-Tingkat Pembimbing Magang->Kaprodi (Individu)
        LetterType::create([
            'approval_flow_id' => $flow2MagangKaprodi->id,
            'name' => 'Surat Pengantar Penelitian',
            'code' => 'SPP',
            'description' => 'Surat pengantar izin penelitian atau pengambilan data lapangan mandiri (2-Tingkat Approval: Dosen Pembimbing -> Kaprodi).',
            'minimum_gpa' => null,
            'minimum_credits' => null,
            'requires_attachment' => true,
            'allow_group_submission' => false,
            'is_active' => true,
        ]);

        // 6. Surat Pengantar Kerja Praktik (SPKP) - 2-Tingkat Wali->Kaprodi (Kelompok)
        LetterType::create([
            'approval_flow_id' => $flow2WaliKaprodi->id,
            'name' => 'Surat Pengantar Kerja Praktik',
            'code' => 'SPKP',
            'description' => 'Surat permohonan izin lokasi Kerja Praktik (KP) untuk tim mahasiswa (2-Tingkat Approval: Dosen Wali -> Kaprodi).',
            'minimum_gpa' => 2.50,
            'minimum_credits' => 70,
            'requires_attachment' => true,
            'allow_group_submission' => true,
            'is_active' => true,
        ]);


        // --- 3. WORKFLOW 3 TINGKAT ---

        // 7. Surat Persetujuan Tugas Akhir (SPTA) - 3-Tingkat Pembimbing Skripsi->Wali->Kaprodi (Individu)
        LetterType::create([
            'approval_flow_id' => $flow3Skripsi->id,
            'name' => 'Surat Persetujuan Tugas Akhir',
            'code' => 'SPTA',
            'description' => 'Surat permohonan persetujuan dan pengajuan judul Tugas Akhir (3-Tingkat Approval: Pembimbing Skripsi -> Dosen Wali -> Kaprodi).',
            'minimum_gpa' => 3.00,
            'minimum_credits' => 100,
            'requires_attachment' => true,
            'allow_group_submission' => false,
            'is_active' => true,
        ]);

        // 8. Surat Pengantar Proyek PKM (SPPKM) - 3-Tingkat Pembimbing Magang->Wali->Kaprodi (Kelompok)
        LetterType::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Surat Pengantar Proyek PKM',
            'code' => 'SPPKM',
            'description' => 'Surat pengantar pengajuan Program Kreativitas Mahasiswa (PKM) kelompok (3-Tingkat Approval: Pembimbing -> Dosen Wali -> Kaprodi).',
            'minimum_gpa' => 3.00,
            'minimum_credits' => null,
            'requires_attachment' => true,
            'allow_group_submission' => true,
            'is_active' => true,
        ]);

        // 9. Surat Pengantar Proyek Kelompok (SPPK) - 3-Tingkat Pembimbing Magang->Wali->Kaprodi (Kelompok)
        LetterType::create([
            'approval_flow_id' => $flow3Magang->id,
            'name' => 'Surat Pengantar Proyek Kelompok',
            'code' => 'SPPK',
            'description' => 'Surat pengantar pengajuan proposal proyek mata kuliah kelompok ke instansi luar (3-Tingkat Approval: Pembimbing -> Dosen Wali -> Kaprodi).',
            'minimum_gpa' => null,
            'minimum_credits' => null,
            'requires_attachment' => true,
            'allow_group_submission' => true,
            'is_active' => true,
        ]);
    }
}
