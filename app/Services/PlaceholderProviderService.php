<?php

namespace App\Services;

class PlaceholderProviderService
{
    /**
     * Get grouped placeholders with key, label, description, and sample value.
     * Dedicated to Letter Body Content placeholders.
     */
    public function getGroupedPlaceholders(): array
    {
        return [
            [
                'group' => 'Data Mahasiswa Pemohon / Ketua',
                'items' => [
                    [
                        'key' => '{{student_name}}',
                        'aliases' => ['{{Nama Mahasiswa}}'],
                        'label' => 'Nama Mahasiswa',
                        'description' => 'Nama lengkap mahasiswa pemohon / ketua',
                        'sample' => 'Nayaka Hananadhif Adinata',
                    ],
                    [
                        'key' => '{{student_number}}',
                        'aliases' => ['{{NIM}}'],
                        'label' => 'NIM',
                        'description' => 'Nomor Induk Mahasiswa',
                        'sample' => '23.01.5022',
                    ],
                    [
                        'key' => '{{study_program}}',
                        'aliases' => ['{{Program Studi}}'],
                        'label' => 'Program Studi',
                        'description' => 'Nama Program Studi / Jurusan',
                        'sample' => 'D3 Teknik Informatika',
                    ],
                    [
                        'key' => '{{semester}}',
                        'aliases' => ['{{Semester}}'],
                        'label' => 'Semester',
                        'description' => 'Semester aktif mahasiswa saat ini',
                        'sample' => '5',
                    ],
                    [
                        'key' => '{{gpa}}',
                        'aliases' => ['{{IPK}}'],
                        'label' => 'Minimal / IPK Kumulatif',
                        'description' => 'Indeks Prestasi Kumulatif',
                        'sample' => '3.83',
                    ],
                    [
                        'key' => '{{total_credits}}',
                        'aliases' => ['{{Total SKS}}', '{{total_sks}}'],
                        'label' => 'Total SKS',
                        'description' => 'Jumlah SKS yang telah ditempuh',
                        'sample' => '92 SKS',
                    ],
                ],
            ],
            [
                'group' => 'Data Dosen & Pejabat Institusi',
                'items' => [
                    [
                        'key' => '{{academic_advisor_name}}',
                        'aliases' => ['{{Nama Dosen Wali}}', '{{advisor_name}}'],
                        'label' => 'Nama Dosen Wali',
                        'description' => 'Nama lengkap dan gelar Dosen Wali',
                        'sample' => 'Nila Feby Puspitasari, S.Kom, M.Cs.',
                    ],
                    [
                        'key' => '{{academic_advisor_nip}}',
                        'aliases' => ['{{NIP Dosen Wali}}', '{{advisor_nip}}'],
                        'label' => 'NIP / NIDN Dosen Wali',
                        'description' => 'Nomor Induk Pegawai / Dosen Wali',
                        'sample' => '0510118101',
                    ],
                    [
                        'key' => '{{head_of_program_name}}',
                        'aliases' => ['{{Nama Kaprodi}}'],
                        'label' => 'Nama Ketua Program Studi',
                        'description' => 'Nama lengkap Ketua Program Studi (Kaprodi)',
                        'sample' => 'Dr. Barka Satya, M.Kom',
                    ],
                    [
                        'key' => '{{head_of_program_nip}}',
                        'aliases' => ['{{NIP Kaprodi}}', '{{head_of_program_nidn}}'],
                        'label' => 'NIP / NIDN Kaprodi',
                        'description' => 'Nomor Induk Pegawai Kaprodi',
                        'sample' => '190302126',
                    ],
                    [
                        'key' => '{{supervisor_name}}',
                        'aliases' => ['{{Nama Dosen Pembimbing}}'],
                        'label' => 'Nama Dosen Pembimbing',
                        'description' => 'Nama lengkap Dosen Pembimbing Tugas Akhir/Magang',
                        'sample' => 'Ferry Wahyu Wibowo, S.Kom., M.Cs.',
                    ],
                    [
                        'key' => '{{supervisor_nip}}',
                        'aliases' => ['{{NIP Dosen Pembimbing}}'],
                        'label' => 'NIP / NIDN Pembimbing',
                        'description' => 'Nomor Induk Pegawai Dosen Pembimbing',
                        'sample' => '190302088',
                    ],
                    [
                        'key' => '{{dean_name}}',
                        'aliases' => ['{{Nama Dekan}}'],
                        'label' => 'Nama Dekan Fakultas',
                        'description' => 'Nama lengkap Dekan Fakultas',
                        'sample' => 'Hanif Al Fatta, M.Kom, Ph.D',
                    ],
                    [
                        'key' => '{{dean_nip}}',
                        'aliases' => ['{{NIP Dekan}}'],
                        'label' => 'NIP / NIDN Dekan',
                        'description' => 'Nomor Induk Pegawai Dekan',
                        'sample' => '190302001',
                    ],
                ],
            ],
            [
                'group' => 'Data Kelompok & Tugas Akhir',
                'items' => [
                    [
                        'key' => '{{group_name}}',
                        'aliases' => ['{{Nama Kelompok}}'],
                        'label' => 'Nama Kelompok / Tim',
                        'description' => 'Nama tim atau kelompok pengaju',
                        'sample' => 'STRONGER MANUFACTURE',
                    ],
                    [
                        'key' => '{{thesis_title}}',
                        'aliases' => ['{{Judul Tugas Akhir}}', '{{Judul TA}}'],
                        'label' => 'Judul Tugas Akhir / Proyek',
                        'description' => 'Judul penelitian atau proyek tugas akhir',
                        'sample' => 'Rancang Bangun Aplikasi Manajemen Produksi di STRONGER MANUFACTURE',
                    ],
                    [
                        'key' => '{{group_leader_name}}',
                        'aliases' => ['{{Nama Ketua Kelompok}}'],
                        'label' => 'Nama Ketua Kelompok',
                        'description' => 'Nama mahasiswa ketua kelompok',
                        'sample' => 'Ahmad Doni',
                    ],
                    [
                        'key' => '{{group_leader_number}}',
                        'aliases' => ['{{NIM Ketua Kelompok}}'],
                        'label' => 'NIM Ketua Kelompok',
                        'description' => 'Nomor Induk Mahasiswa ketua kelompok',
                        'sample' => '23.01.4972',
                    ],
                    [
                        'key' => '{{group_members}}',
                        'aliases' => ['{{Daftar Anggota Kelompok}}'],
                        'label' => 'Daftar Anggota (Tabel)',
                        'description' => 'Tabel daftar nama & NIM seluruh anggota kelompok',
                        'sample' => '<table class="member-table"><thead><tr><th class="col-no">No</th><th class="col-nim">NIM</th><th>Nama Mahasiswa</th></tr></thead><tbody><tr><td class="text-center">1</td><td class="text-center">23.01.4969</td><td>Aditya Giri Kurniawan</td></tr><tr><td class="text-center">2</td><td class="text-center">23.01.4972</td><td>Ahmad Doni</td></tr><tr><td class="text-center">3</td><td class="text-center">23.01.5005</td><td>Hafizh Umar Fadillah</td></tr></tbody></table>',
                    ],
                ],
            ],
            [
                'group' => 'Data Instansi, Keperluan & Akademik',
                'items' => [
                    [
                        'key' => '{{letter_number}}',
                        'aliases' => ['{{Nomor Surat}}'],
                        'label' => 'Nomor Surat Resmi',
                        'description' => 'Nomor registrasi surat yang di-generate sistem',
                        'sample' => '41/FIK-D3TI/AMIKOM/VI/2026',
                    ],
                    [
                        'key' => '{{purpose}}',
                        'aliases' => ['{{Keperluan}}'],
                        'label' => 'Keperluan Pengajuan',
                        'description' => 'Alasan atau peruntukan surat',
                        'sample' => 'Pengajuan Magang Industri dan Kerja Praktik',
                    ],
                    [
                        'key' => '{{faculty_name}}',
                        'aliases' => ['{{Nama Fakultas}}'],
                        'label' => 'Nama Fakultas',
                        'description' => 'Fakultas tempat mahasiswa bernaung',
                        'sample' => 'Fakultas Ilmu Komputer',
                    ],
                    [
                        'key' => '{{company_name}}',
                        'aliases' => ['{{Nama Perusahaan}}', '{{Nama Instansi}}'],
                        'label' => 'Nama Perusahaan / Instansi Tujuan',
                        'description' => 'Nama tempat tujuan magang/penelitian',
                        'sample' => 'PT Gamatechno Indonesia',
                    ],
                    [
                        'key' => '{{company_address}}',
                        'aliases' => ['{{Alamat Perusahaan}}', '{{Alamat Instansi}}'],
                        'label' => 'Alamat Instansi / Perusahaan',
                        'description' => 'Alamat lengkap tempat magang/penelitian',
                        'sample' => 'Jl. Tegalturi No.83, Giwangan, Umbulharjo, Yogyakarta',
                    ],
                    [
                        'key' => '{{start_date}}',
                        'aliases' => ['{{Tanggal Mulai}}'],
                        'label' => 'Tanggal Mulai Kegiatan',
                        'description' => 'Tanggal pelaksanaan awal kegiatan',
                        'sample' => '1 September 2026',
                    ],
                    [
                        'key' => '{{end_date}}',
                        'aliases' => ['{{Tanggal Selesai}}'],
                        'label' => 'Tanggal Selesai Kegiatan',
                        'description' => 'Tanggal akhir pelaksanaan kegiatan',
                        'sample' => '31 Desember 2026',
                    ],
                    [
                        'key' => '{{academic_year}}',
                        'aliases' => ['{{Tahun Akademik}}'],
                        'label' => 'Tahun Akademik',
                        'description' => 'Tahun ajaran berjalan',
                        'sample' => '2025/2026',
                    ],
                    [
                        'key' => '{{submission_date}}',
                        'aliases' => ['{{Tanggal Pengajuan}}'],
                        'label' => 'Tanggal Pengajuan',
                        'description' => 'Tanggal mahasiswa membuat pengajuan',
                        'sample' => '11 September 2025',
                    ],
                ],
            ],
        ];
    }

    /**
     * Flat array of all primary keys and aliases.
     */
    public function getAllPlaceholderKeys(): array
    {
        $keys = [];
        foreach ($this->getGroupedPlaceholders() as $group) {
            foreach ($group['items'] as $item) {
                $keys[] = $item['key'];
                foreach ($item['aliases'] as $alias) {
                    $keys[] = $alias;
                }
            }
        }
        return array_values(array_unique($keys));
    }

    /**
     * Map of all keys and aliases to their sample display value.
     */
    public function getSampleData(): array
    {
        $samples = [];
        foreach ($this->getGroupedPlaceholders() as $group) {
            foreach ($group['items'] as $item) {
                $samples[$item['key']] = $item['sample'];
                foreach ($item['aliases'] as $alias) {
                    $samples[$alias] = $item['sample'];
                }
            }
        }

        // Additional fallbacks for document components
        $samples['{{letter_number}}'] = '41/FIK-D3TI/AMIKOM/VI/2026';
        $samples['{{print_date}}'] = '11 September 2025';
        $samples['{{approval_date}}'] = '11 September 2025';

        return $samples;
    }
}
