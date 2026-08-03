# Design Specification: Sistem Informasi Manajemen Surat Akademik (Amikom Letter Management)

> **Document Purpose**: Design specification document formatted for upload to **Google Stitch** to generate consistent, high-fidelity UI components, layouts, and interactive screens for the Academic Letter Management System. Grounded entirely in real codebase assets, database schemas, Tailwind tokens, and workflow logic.

---

## 1. Codebase Overview, Purpose & Critical Files

### 1.1 Codebase Purpose & Product Vision
- **Application Name**: Sistem Informasi Manajemen Surat Akademik (Amikom Letter Management) / **Universitas Amikom Student Services**
- **Core Purpose**: Streamline the entire lifecycle of academic letter requests for Universitas Amikom students, from submission and multi-tier lecturer approval workflows to automated document generation, digital signatures, and administrative template management.
- **Target Roles**:
  1. `STUDENT` (Mahasiswa): Submits letter requests, tracks multi-stage approval progress, and downloads finalized signed documents.
  2. `LECTURER` (Dosen): Acts as Academic Advisor (`Dosen Wali`), Internship Supervisor (`Dosen Pembimbing Magang`), Thesis Supervisor (`Dosen Pembimbing TA`), or Head of Study Program (`Kaprodi`) to review, request revisions, approve, or reject student requests with digital signatures.
  3. `ADMIN` (Administrator): Manages letter types, configures multi-step approval flows, updates letter templates with dynamic tags, and monitors system usage.
- **Dominant Core Feature**: **Multi-Step Approval Workflow Pipeline & Live PDF Document Verification**.

### 1.2 Critical Codebase Files & Ground Truth References
- **Routing & Controllers**:
  - [routes/web.php](file:///c:/laragon/www/letter-management/routes/web.php): Enforces role-based route middleware (`role:ADMIN`, `role:STUDENT`, `role:LECTURER`) and letter view serving (`/letter/{filename}`).
  - [app/Http/Controllers/StudentController.php](file:///c:/laragon/www/letter-management/app/Http/Controllers/StudentController.php), [LecturerController.php](file:///c:/laragon/www/letter-management/app/Http/Controllers/LecturerController.php), [ProfileController.php](file:///c:/laragon/www/letter-management/app/Http/Controllers/ProfileController.php).
- **Domain Models & Enums**:
  - [app/Enums/UserRole.php](file:///c:/laragon/www/letter-management/app/Enums/UserRole.php): `ADMIN`, `LECTURER`, `STUDENT`.
  - [app/Enums/ApprovalRole.php](file:///c:/laragon/www/letter-management/app/Enums/ApprovalRole.php): `ACADEMIC_ADVISOR`, `INTERNSHIP_SUPERVISOR`, `THESIS_SUPERVISOR`, `HEAD_OF_STUDY_PROGRAM`.
  - [app/Enums/ApproverSource.php](file:///c:/laragon/www/letter-management/app/Enums/ApproverSource.php): `STUDENT_LECTURER`, `LECTURER_POSITION`.
  - [app/Models/LetterType.php](file:///c:/laragon/www/letter-management/app/Models/LetterType.php), [LetterTemplate.php](file:///c:/laragon/www/letter-management/app/Models/LetterTemplate.php), [ApprovalFlow.php](file:///c:/laragon/www/letter-management/app/Models/ApprovalFlow.php), [ApprovalFlowStep.php](file:///c:/laragon/www/letter-management/app/Models/ApprovalFlowStep.php), [Student.php](file:///c:/laragon/www/letter-management/app/Models/Student.php), [Lecturer.php](file:///c:/laragon/www/letter-management/app/Models/Lecturer.php).
- **Database Schema & Migrations**:
  - `database/migrations/2026_07_07_141127_create_students_table.php` (`student_number`, `batch_year`, `semester`, `gpa`, `total_credits`, `academic_status`)
  - `database/migrations/2026_07_28_174800_create_approval_flow_steps_table.php` (`approval_flow_id`, `name`, `approval_role`, `approver_source`, `step_order`)
  - `database/migrations/2026_07_28_175309_create_letter_types_table.php` (`approval_flow_id`, `name`, `code`, `description`, `minimum_gpa`, `minimum_credits`, `requires_attachment`, `is_active`)
  - `database/migrations/2026_07_28_175651_create_letter_templates_table.php` (`letter_type_id`, `name`, `body_content`, `is_active`)
- **Design System Configuration**:
  - [tailwind.config.js](file:///c:/laragon/www/letter-management/tailwind.config.js): Defines institutional colors, typography scales, spacing tokens, and custom container max widths.
- **Blade Layouts & Key Components**:
  - [resources/views/components/sidebar.blade.php](file:///c:/laragon/www/letter-management/resources/views/components/sidebar.blade.php): Dynamic navigation per role with Universitas Amikom branding.
  - [resources/views/components/status-badge.blade.php](file:///c:/laragon/www/letter-management/resources/views/components/status-badge.blade.php): Institutional status badges (`Disetujui`, `Ditolak`, `Perlu Revisi`, `Menunggu`).
  - [resources/views/components/header.blade.php](file:///c:/laragon/www/letter-management/resources/views/components/header.blade.php), [stat-card.blade.php](file:///c:/laragon/www/letter-management/resources/views/components/stat-card.blade.php), [welcome-card.blade.php](file:///c:/laragon/www/letter-management/resources/views/components/welcome-card.blade.php).

---

## 2. Real Content, Terminology & Domain Logic

### 2.1 Academic Letter Types (Real Codebase Types)
1. **Surat Persetujuan Tugas Akhir Jalur Non-Reguler** (`persetujuan_ta_non_reguler`)
   - Requires verification of GPA & total credits. Approved by Academic Advisor and Head of Study Program.
2. **Surat Rekomendasi Magang** (`rekomendasi_magang`)
   - Requires internship details and company destination info. Approved by Academic Advisor / Internship Supervisor.
3. **Surat Rekomendasi Pendaftaran Pendadaran** (`rekomendasi_pendadaran`)
   - Prerequisites check (`minimum_gpa`, `minimum_credits`, required attachments). Approved by Thesis Supervisor and Head of Study Program.

### 2.2 Native Shape: The Multi-Tier Approval Pipeline State Machine
The core structure of the application is a **Pipeline State Machine**. Rather than standard static dashboards, UI screens are organized around the step-by-step progression of a letter request:
```
[ Step 1: Draft / Request ] ──> [ Step 2: Verification (Dosen Wali) ] ──> [ Step 3: Approval (Kaprodi) ] ──> [ Step 4: Signed PDF ]
```
- **Validation Constraints** (from `LetterType` schema): `minimum_gpa` (decimal), `minimum_credits` (integer), `requires_attachment` (boolean).
- **Approval Roles** (from `ApprovalRole` enum):
  - `Academic Advisor` (`Dosen Wali`)
  - `Internship Supervisor` (`Dosen Pembimbing Magang`)
  - `Thesis Supervisor` (`Dosen Pembimbing TA`)
  - `Head of Study Program` (`Kaprodi`)
- **Approver Resolution Source** (from `ApproverSource` enum):
  - `STUDENT_LECTURER` (Direct student-to-lecturer relationship)
  - `LECTURER_POSITION` (Role assigned by institutional position)

---

## 3. Design System & Design Tokens (Extracted from Codebase)

### 3.1 Color Tokens (from `tailwind.config.js`)

#### Institutional Primary & Brand Colors
- `amikom-purple` (`#431E6D`): Dominant brand color used on sidebars, primary CTA buttons, and header elements.
- `primary` (`#410063`): Primary container headers and active navigation background.
- `primary-container` (`#59207B`): Secondary active states and dark container highlights.
- `primary-fixed-dim` (`#E5B4FF`): Purple accent borders and highlighted badge fills.
- `amikom-purple-light` (`#F3E8FF`): Subtle callout containers, pill indicators, and background highlights.

#### Institutional Accent & Secondary Colors
- `amikom-gold` (`#E28800`): Accent highlights, pending status indicators, and warning callouts.
- `secondary-container` (`#FCD400`): High-priority alert banners and active notification badges.
- `secondary-fixed` (`#FFE16D`) / `on-secondary-fixed-variant` (`#544600`): Light amber badge backgrounds and dark text.
- `tertiary` (`#332500`): Dark gold/amber typography for contrast on light gold backgrounds.

#### Status & Functional Colors (from `status-badge.blade.php` & `tailwind.config.js`)
- `amikom-green` / `success` (`#0E7452`): Approved status, completed step, verified digital signature (`bg-green-100 text-green-800 border-green-200`).
- `error` (`#BA1A1A`) / `on-error-container` (`#93000A`): Rejected status, form validation errors, destructive actions.
- `error-container` (`#FFDAD6`): Rejection reason alert box and error callouts (`bg-red-100 text-red-800 border-red-200`).
- `amber-status`: Revision requested state (`bg-amber-100 text-amber-800 border-amber-200`).
- `outline` (`#7E7481`) / `outline-variant` (`#CFC2D1`): Form element borders, table row dividers, card outlines.

#### Neutral & Background Tokens
- `background` / `surface` (`#FBF9F9`): Main page workspace background color.
- `surface-container-lowest` / `pure-white` (`#FFFFFF`): Primary card containers, modals, table rows.
- `surface-container` (`#EFEDED`) / `surface-container-low` (`#F5F3F3`): Input background fills, hover states.
- `surface-container-high` (`#E9E8E7`): Header bars, muted card sections.
- `on-surface` (`#1B1C1C`) / `deep-black` (`#1A1A1A`): Primary headings and high-contrast body copy.
- `on-surface-variant` (`#4D4450`): Secondary copy, form labels, metadata captions.

---

### 3.2 Typography Scale (from `tailwind.config.js`)

- **Primary Body & Label Font**: `Public Sans`, `Inter`, `sans-serif`
- **Display & Headline Font**: `Montserrat`, `sans-serif`

| Token Name | Font Family | Size / Line Height | Font Weight | Usage in Codebase |
| :--- | :--- | :--- | :--- | :--- |
| `display-lg` | Montserrat | 48px / 56px (`-0.02em`) | Bold (700) | Hero title, landing header |
| `headline-lg` | Montserrat | 32px / 40px | SemiBold (600) | Page titles, major dashboard headers |
| `headline-lg-mobile` | Montserrat | 24px / 32px | SemiBold (600) | Mobile main page titles |
| `headline-md` | Montserrat | 24px / 32px | SemiBold (600) | Section headers, card group titles |
| `headline-sm` | Montserrat | 20px / 28px | SemiBold (600) | Card titles, sub-section headers |
| `title-lg` | Montserrat | 20px / 28px | SemiBold (600) | Modal dialog headers, step titles |
| `body-lg` | Public Sans | 18px / 28px | Regular (400) | Lead introductory paragraphs |
| `body-md` | Public Sans | 16px / 24px | Regular (400) | Standard body text, form input value |
| `body-sm` | Public Sans | 14px / 20px | Regular (400) | Table row cells, description text |
| `label-lg` | Public Sans | 14px / 20px (`0.01em`) | SemiBold (600) | Sidebar navigation items, primary buttons |
| `label-md` | Public Sans | 14px / 16px (`0.05em`) | SemiBold (600) | Form field labels, card headers |
| `label-sm` | Public Sans | 12px / 16px (`0.04em`) | Medium (500) | Status badges, timestamps, metadata |

---

### 3.3 Spacing & Grid Tokens (from `tailwind.config.js`)

- **Base Unit (`unit` / `base` / `stack-sm`)**: `8px`
- **Stack Medium (`stack-md` / `margin-mobile`)**: `16px`
- **Gutter (`gutter`)**: `24px`
- **Sidebar Width (`sidebar-width`)**: `280px` fixed desktop sidebar width
- **Stack Large (`stack-lg` / `container-padding`)**: `32px`
- **Desktop Margin (`margin-desktop`)**: `48px`
- **Max Container Width (`container-max`)**: `1280px`

---

## 4. Information Architecture & Key Routes

```
[ Auth / Login (/) ]
       │
       ├──> [ STUDENT Portal (/student/*) ]
       │      ├── /student/dashboard ──> Ringkasan Pengajuan & Pipeline Stats
       │      ├── /student/submission ──> Form Wizard Pengajuan Surat & Validation Check
       │      ├── /student/submission-history ──> Tabel Riwayat, Search, Filter Status & Download PDF
       │      └── /student/settings ──> Pengaturan Profil & Password
       │
       ├──> [ LECTURER Portal (/lecturer/*) ]
       │      ├── /lecturer/dashboard ──> Antrean Persetujuan HARI INI & Summary Metrics
       │      ├── /lecturer/approval ──> Tabel Antrean Persetujuan Surat
       │      ├── /lecturer/approval/detail ──> Live Split View (60% PDF Preview, 40% TTD & Review Form)
       │      ├── /lecturer/approval-history ──> Riwayat Persetujuan & Log Audit
       │      └── /lecturer/settings ──> Pengaturan Profil & Passphrase TTDE
       │
       └──> [ ADMIN Portal (/admin/*) ]
              ├── /admin/dashboard ──> Analytics & System Activity Overview
              ├── /admin/letters ──> Kelola Jenis Surat & Flow Persetujuan
              ├── /admin/letters/edit ──> Visual Template Editor ({NAMA}, {NIM}, {PRODI}, {TANGGAL})
              └── /admin/settings ──> Pengaturan Sistem & User Roles
```

---

## 5. Detailed Screen Specifications for Google Stitch

### 5.1 Login Screen (`auth.login`)
- **Header**: Logo Universitas Amikom, App Title ("Sistem Informasi Manajemen Surat Akademik").
- **Layout**: Centered responsive card split: Left panel featuring Amikom brand illustration & subtitle ("Student Services"), Right panel containing authentication form.
- **Form Fields**:
  - Email / NIM / NIDN input field with icon prefix.
  - Password field with show/hide eye toggle.
- **Primary CTA**: "Masuk ke Sistem" (`bg-amikom-purple hover:bg-primary-container text-white`).

---

### 5.2 Student Dashboard (`student.dashboard`)
- **Layout**: Fixed left sidebar (`280px`) + main content container (`1280px`).
- **Welcome Banner**: "Selamat Datang, [Nama Mahasiswa]" with quick CTA button "Buat Pengajuan Baru".
- **Top Metrics (3 Columns)**:
  1. *Total Pengajuan*: Counter metric.
  2. *Menunggu Persetujuan*: Counter metric with `amikom-gold` border highlight.
  3. *Surat Disetujui*: Counter metric with `amikom-green` border highlight.
- **Core Section (Approval Pipeline List)**:
  - Timeline tracker bar for active submissions showing exact progress: `Diajukan` ➔ `Verifikasi Dosen Wali` ➔ `Disetujui Kaprodi` ➔ `Siap Diunduh`.
  - Quick action card triggers for letter categories: *Surat Persetujuan Tugas Akhir Jalur Non-Reguler*, *Surat Rekomendasi Magang*, *Surat Rekomendasi Pendaftaran Pendadaran*.

---

### 5.3 Student Submission Form (`student.submission`)
- **Layout**: Step wizard layout organized by academic requirements.
- **Step 1: Pilih Jenis Surat**:
  - Cards for *Surat Persetujuan Tugas Akhir Jalur Non-Reguler*, *Surat Rekomendasi Magang*, *Surat Rekomendasi Pendaftaran Pendadaran*.
  - Auto-validation panel checking prerequisites (`IPK Minimal: 3.00`, `SKS Minimal: 100`).
- **Step 2: Data Pemohon & Keperluan**:
  - Auto-filled fields: NIM (`21.11.9999`), Nama Lengkap, Program Studi, Semester, IPK, Total SKS.
  - User fields: Keperluan Surat, Instansi Tujuan, Alamat Instansi, Judul Tugas Akhir / Magang.
- **Step 3: Unggah Dokumen Pendukung**:
  - Drag-and-Drop file uploader (PDF format, max 2MB) for KTM, Transkrip Nilai, or Proposal.
- **Footer Controls**: Secondary button "Simpan Draf", Primary button "Kirim Pengajuan" (`bg-amikom-purple`).

---

### 5.4 Student Submission History (`student.submission-history`)
- **Layout**: Toolbar with Search & Filters + Data Table + Detail Side Drawer / Modal.
- **Filter Toolbar**: Search by ID/Title, Filter by Jenis Surat, Filter by Status (`Semua`, `Menunggu`, `Disetujui`, `Perlu Revisi`, `Ditolak`).
- **Data Table Columns**:
  1. No. & ID Pengajuan
  2. Jenis Surat
  3. Tanggal Pengajuan
  4. Penyetuju (Dosen Wali / Kaprodi)
  5. Status (using `<x-status-badge>`)
  6. Aksi (`Detail`, `Unduh PDF`)
- **Modal Tracking Detail**: Full audit trail log showing time-stamped signatures and reviewer notes.

---

### 5.5 Lecturer Approval Detail Screen (`lecturer.approval-detail`)
- **Layout**: **60 / 40 Split View Screen** (Dominant core feature of the app).
- **Left Panel (60% - Live PDF Previewer)**:
  - Full height document viewer with zoom & page navigation controls, displaying live rendered letter filled with student data, academic background, and placeholder signature box.
- **Right Panel (40% - Action Control & Digital Signature)**:
  - *Student Verification Card*: NIM, Nama Mahasiswa, IPK, Total SKS, Status Akademik.
  - *Verification Checklist*: Verification items (KRS Valid, IPK Minimum Met, Proposal Uploaded).
  - *Catatan Persetujuan*: Textarea for notes or required revision details.
  - *Passphrase Tanda Tangan Digital (TTDE)*: Secure passphrase input for digital signature verification.
  - *Action Buttons*:
    - "Setujui & Tanda Tangani" (`bg-amikom-green text-white`)
    - "Minta Revisi" (`bg-amber-500 text-white`)
    - "Tolak Pengajuan" (`bg-error text-white`)

---

### 5.6 Admin Letter Template Management (`admin.letters` & `admin.letters-edit`)
- **Layout**: Header with "Tambah Template Baru" + Template Grid Cards + WYSIWYG Template Editor.
- **Template Editor Components**:
  - Template Title & Code configuration (`rekomendasi_magang`).
  - Dynamic Variable Tag Palette: `{NAMA}`, `{NIM}`, `{PRODI}`, `{IPK}`, `{SKS}`, `{DOSEN_WALI}`, `{KAPRODI}`, `{TANGGAL_SURAT}`.
  - Body Content rich text editor with live variable replacement preview.
  - Active toggle (`is_active`).

---

## 6. Prompting Instructions for Google Stitch

When generating visual mocks or exporting HTML/CSS in Google Stitch using this file:
1. Preserve **`amikom-purple` (`#431E6D`)** as the primary brand color for sidebars, top headers, primary buttons, and active states.
2. Maintain exact typography rules: **`Montserrat`** for display headings and titles (`display-lg`, `headline-lg`, `headline-md`, `title-lg`), **`Public Sans`** for body copy, table cells, and form inputs (`body-md`, `body-sm`, `label-lg`, `label-sm`).
3. Ensure the **Lecturer Approval Detail view** strictly implements the **60/40 split screen** layout (60% live PDF preview on left, 40% approval control panel on right).
4. Use exact component badges defined in `<x-status-badge>`: Green (`#0E7452`) for `Disetujui`, Amber (`#E28800`) for `Perlu Revisi`, Red (`#BA1A1A`) for `Ditolak`, Gray (`#7E7481`) for `Menunggu`.
