<p align="center">
  <img src="public/letter/images/logo-amikom.png" width="220" alt="Logo AMIKOM Yogyakarta">
</p>

<h1 align="center">Sistem Informasi Pengajuan Dan Monitoring Surat Akademik Mahasiswa Berbasis Web</h1>
<p align="center">
  <b>Tugas Akhir — D3 Teknik Informatika Universitas AMIKOM Yogyakarta</b><br>
  <i>Sistem Pengajuan dan Monitoring Surat Akademik Mahasiswa Terintegrasi dengan Multi-Tier Approval Workflow dan Verifikasi QR Code.</i>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-^8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
</p>

---

## 🎓 Informasi Tugas Akhir

| Parameter | Spesifikasi Laporan TA |
| :--- | :--- |
| **Judul Tugas Akhir** | Rancang Bangun Sistem Informasi Pengajuan Dan Monitoring Surat Akademik Mahasiswa Berbasis Web |
| **Program Studi** | D3 Teknik Informatika |
| **Fakultas / Instansi** | Fakultas Ilmu Komputer — Universitas AMIKOM Yogyakarta |
| **Metodologi Pengembangan** | Agile Development |
| **Lingkup Implementasi** | Program Studi D3 Teknik Informatika |
| **Metode Pengujian** | Blackbox Testing

---

## 📌 Latar Belakang & Masalah Utama

Proses administrasi pelayanan hak akademik mahasiswa di **Program Studi D3 Teknik Informatika Universitas AMIKOM Yogyakarta** — seperti pengajuan *Surat Rekomendasi Magang*, *Surat Persetujuan Tugas Akhir Non-Reguler*, hingga *Surat Rekomendasi Pendadaran* — sebelumnya masih berjalan secara **terfragmentasi** dan belum terintegrasi ke dalam satu platform tunggal.

### ⚠️ Permasalahan Operasional Sebelum Ada Sistem:

1. **Alur Kerja Terpisah & Manual**: Mahasiswa harus menginput data di **Google Form**, lalu membuka **Website Fakultas** terpisah untuk memantau status, dan menunggu **Email** pengiriman file PDF hasil.
2. **Lemahnya Sinkronisasi Data**: Informasi tersebar di berbagai media terpisah, menyebabkan ketidakteraturan kelola data antara pihak program studi dan fakultas.
3. **Absennya Dasbor Monitoring Terpusat**: Mahasiswa mengalami kebingungan memantau posisi berkas pengajuannya karena tidak ada dasbor pemantauan real-time.
4. **Alur Persetujuan Kurang Transparan**: Waktu penyelesaian surat sulit diprediksi sehingga beban administratif berisiko tinggi memicu keterlambatan pelayanan.

### 💡 Solusi yang Diusulkan:

Dikembangkan **Sistem Informasi Manajemen Persuratan Terintegrasi Berbasis Web** berbasis framework **Laravel** dengan **Metode Agile**. Seluruh proses pengajuan surat, pemantauan status real-time, persetujuan berjenjang dosen/kaprodi, hingga penerbitan dokumen PDF resmi ber-QR Code disatukan dalam satu platform terpusat.

---

## ✨ Fitur Utama Sistem

- 🎓 **Portal Mahasiswa D3 TI (`STUDENT`)**:
  - Permohonan surat perorangan maupun kelompok (*team request*).
  - Dasbor pemantauan status alur persetujuan (*monitoring progress*) secara real-time.
  - Pratinjau dokumen A4 resmi dan pengunduhan file PDF terbitan.

- 👨‍🏫 **Portal Dosen & Penguji (`LECTURER`)**:
  - Penelaahan pengajuan berjenjang sesuai peran (Dosen Wali, Pembimbing TA/Magang, Kaprodi D3 Teknik Informatika).
  - Dashboard statistik permohonan (*pending*, *approved*, *rejected*).
  - Persetujuan cepat (*batch approval*) dan penolakan disertai catatan revisi.

- 🛠️ **Portal Admin Prodi (`ADMIN`)**:
  - Manajemen Jenis Surat Akademik & Prasyarat Akademik (Minimal IPK, SKS, Lampiran).
  - Konfigurasi Alur Persetujuan Multi-Tahap (*Approval Flows*).
  - Editor Template Surat (*Letter Templates*) dengan *dynamic placeholder tags*.

- 🔍 **E-Verification**:
  - Generator Surat PDF Otomatis dengan Tanda Tangan Digital & QR Code.
  - Halaman Verifikasi Publik (`/verify/{token}`) untuk pembuktian keabsahan surat terbitan.

---

## 🛠️ Teknologi & Stack

- **Framework Backend**: Laravel 12 (PHP 8.3+)
- **Frontend Engine**: Blade Templating, Tailwind CSS 3.4, Vite, Alpine.js
- **PDF & QR Code**: Spatie Laravel PDF / Browsershot, Simple QrCode
- **Database**: MySQL / SQLite (disertai indeks optimasi performa)
- **Metode Pengembangan**: Agile Development
- **Metode Testing**: Blackbox Testing

---

## 🚀 Panduan Instalasi Lokal

```bash
# 1. Clone repositori
git clone https://github.com/username/letter-management.git
cd letter-management

# 2. Install dependensi PHP & Node
composer install
npm install

# 3. Salin konfigurasi environment & Generate Key
cp .env.example .env
php artisan key:generate

# 4. Jalankan Migrasi Database & Seeder
php artisan migrate --seed

# 5. Buat Symlink Storage
php artisan storage:link

# 6. Jalankan Server Pengembang & Asset Build
npm run dev
# Pada terminal terpisah:
php artisan serve
```

Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## 📑 Dokumentasi Teknis TA

Dokumentasi teknis lengkap mencakup **Kebutuhan Fungsional (SRS)**, **Naskah Utuh Latar Belakang Laporan**, **Skema Database (ERD)**, **Metodologi Pengembangan Agile**, **Metodologi Pengujian Blackbox**, serta **Daftar Placeholder Tag Template** dapat diakses pada berkas **[DOCUMENTATION.md](DOCUMENTATION.md)**.
