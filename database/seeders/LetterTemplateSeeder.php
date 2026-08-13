<?php

namespace Database\Seeders;

use App\Models\LetterTemplate;
use App\Models\LetterType;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Template: Surat Persetujuan TA Jalur Non-Reguler (Kelompok)
        $typeNonReg = LetterType::where('code', 'SP-TA-NONREG')->first();
        if ($typeNonReg) {
            LetterTemplate::updateOrCreate(
                ['letter_type_id' => $typeNonReg->id, 'name' => 'Template Persetujuan TA Non-Reguler (Kelompok)'],
                [
                    'body_content' => '<div class="doc-title-main">SURAT PERSETUJUAN TUGAS AKHIR</div><div class="doc-title-sub">JALUR NON REGULER</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nomor</td><td>: {{letter_number}}</td></tr></tbody></table><div class="doc-text-lead" style="margin-top: 10pt;">Yang bertanda tangan di bawah ini:</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 12pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nama</td><td>: {{head_of_program_name}}</td></tr><tr><td>NIK/NIDN</td><td>: {{head_of_program_nip}}</td></tr><tr><td>Jabatan</td><td>: Ketua Program Studi</td></tr></tbody></table><div class="doc-text-justify" style="margin-bottom: 10pt;">Dengan ini memberikan persetujuan Tugas Akhir berkelompok jalur non reguler dengan judul <span class="bold">"{{thesis_title}}"</span>. Identitas kelompok sebagai berikut :</div><div style="margin-bottom: 12pt;">{{group_members}}</div><div class="doc-text-justify" style="margin-bottom: 10pt;">Persetujuan ini diberikan dengan mempertimbangkan bahwa kelompok yang bersangkutan telah memenuhi persyaratan akademik dan administratif sesuai ketentuan yang berlaku di lingkungan Program Studi D3 Teknik Informatika, serta memiliki kemampuan dan kesiapan untuk menyelesaikan Tugas Akhir melalui jalur tersebut.</div><div class="doc-text-lead" style="margin-top: 10pt;">Demikian surat persetujuan jalur non-reguler ini dibuat dan dipertimbangkan untuk digunakan sebagaimana mestinya.</div>',
                    'is_active' => true,
                ]
            );
        }

        // 2. Template: Surat Rekomendasi Magang (Individu)
        $typeMagang = LetterType::where('code', 'SR-MAGANG')->first();
        if ($typeMagang) {
            LetterTemplate::updateOrCreate(
                ['letter_type_id' => $typeMagang->id, 'name' => 'Template Rekomendasi Magang (Individu)'],
                [
                    'body_content' => '<div class="doc-title-main">SURAT REKOMENDASI MAGANG</div><div class="doc-title-sub" style="font-size: 12pt; font-weight: normal; margin-bottom: 12pt;">Program Studi D3 Teknik Informatika</div><div class="doc-text-lead" style="margin-top: 10pt;">Yang bertanda tangan di bawah ini:</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nama</td><td>: {{academic_advisor_name}}</td></tr><tr><td>NIK/NIDN</td><td>: {{academic_advisor_nip}}</td></tr><tr><td>Jabatan</td><td>: Dosen Wali</td></tr></tbody></table><div class="doc-text-lead" style="margin-bottom: 6pt;">Dengan ini memberikan <span class="bold">rekomendasi</span> kepada:</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nama Mahasiswa</td><td>: {{student_name}}</td></tr><tr><td>NIM</td><td>: {{student_number}}</td></tr><tr><td>Program Studi</td><td>: {{study_program}}</td></tr><tr><td>Semester</td><td>: {{semester}}</td></tr></tbody></table><div class="doc-text-justify" style="margin-bottom: 10pt;">Untuk melaksanakan kegiatan <span class="bold">magang/kerja praktik</span> dalam rangka memenuhi salah satu persyaratan akademik di program studi D3 Teknik Informatika.</div><div style="margin-bottom: 10pt;"><div style="margin-bottom: 4pt; font-weight: 600;">Telah saya review terkait nilai akademiknya sebagai berikut :</div><table class="info-table"><tbody><tr><td class="lbl" style="width: 130pt;">Jumlah SKS terakhir</td><td>: {{total_credits}}</td></tr><tr><td>IPK</td><td>: {{gpa}}</td></tr></tbody></table></div><div class="doc-text-lead" style="margin-top: 10pt;">Demikian surat rekomendasi ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</div>',
                    'is_active' => true,
                ]
            );
        }

        // 3. Template: Surat Rekomendasi Pendaftaran Pendadaran (Individu)
        $typePendadaran = LetterType::where('code', 'SR-PENDADARAN')->first();
        if ($typePendadaran) {
            LetterTemplate::updateOrCreate(
                ['letter_type_id' => $typePendadaran->id, 'name' => 'Template Rekomendasi Pendaftaran Pendadaran (Individu)'],
                [
                    'body_content' => '<div class="doc-title-main">SURAT REKOMENDASI</div><div class="doc-title-sub">PENDAFTARAN PENDADARAN</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nomor</td><td>: {{letter_number}}</td></tr></tbody></table><div class="doc-text-lead" style="margin-top: 10pt;">Yang bertanda tangan di bawah ini:</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nama</td><td>: {{head_of_program_name}}</td></tr><tr><td>NIK/NIDN</td><td>: {{head_of_program_nip}}</td></tr><tr><td>Jabatan</td><td>: Ketua Program Studi</td></tr></tbody></table><div class="doc-text-lead" style="margin-bottom: 6pt;">Dengan ini memberikan rekomendasi kepada:</div><table class="info-table" style="margin-top: 6pt; margin-bottom: 10pt;"><tbody><tr><td class="lbl" style="width: 120pt;">Nama</td><td>: {{student_name}}</td></tr><tr><td>NIM</td><td>: {{student_number}}</td></tr><tr><td>Program Studi</td><td>: {{study_program}}</td></tr></tbody></table><div class="doc-text-justify" style="margin-bottom: 10pt;">Untuk mengikuti pendaftaran pendadaran / ujian tugas akhir (Keperluan: {{purpose}}).</div><div class="doc-text-lead" style="margin-top: 10pt;">Demikian surat rekomendasi ini dibuat dan dipertimbangkan untuk digunakan sebagaimana mestinya.</div>',
                    'is_active' => true,
                ]
            );
        }
    }
}
