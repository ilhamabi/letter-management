<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keabsahan Surat - Universitas AMIKOM Yogyakarta</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite / CDN fallback) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen font-['Plus_Jakarta_Sans',sans-serif] text-gray-800 antialiased flex flex-col justify-between">

    <!-- Header Navbar -->
    <header class="bg-white border-b border-gray-200 shadow-xs">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ url('/letter/images/logo-amikom.png') }}" alt="Logo AMIKOM" class="h-10 w-auto object-contain">
                <div class="border-l border-gray-300 pl-3">
                    <h1 class="text-sm font-bold text-gray-900 leading-tight">Universitas AMIKOM Yogyakarta</h1>
                    <p class="text-xs text-gray-500">Sistem Verifikasi Dokumen Resmi</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-amikom-purple border border-purple-100">
                E-Verification System
            </span>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-3xl mx-auto px-4 py-8 w-full flex-1">
        
        @if($isValid)
            <!-- DOKUMEN VALID CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-200 overflow-hidden">
                <!-- Status Banner -->
                <div class="bg-emerald-50 border-b border-emerald-200 px-6 py-6 text-center">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                        <x-icon name="check_circle" class="w-10 h-10" />
                    </div>
                    <h2 class="text-2xl font-extrabold text-emerald-800 tracking-tight">✓ DOKUMEN VALID</h2>
                    <p class="text-xs font-semibold text-emerald-700 mt-1">Dokumen surat ini terverifikasi asli dan diterbitkan secara resmi oleh Universitas AMIKOM Yogyakarta.</p>
                </div>

                <!-- Content Details -->
                <div class="p-6 md:p-8 space-y-6">
                    
                    <!-- Section: Informasi Surat -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Informasi Utama Surat</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <span class="text-xs font-semibold text-gray-500 block">Nomor Surat</span>
                                <span class="text-sm font-bold text-gray-900 font-mono">{{ $letterNumber }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-500 block">Jenis Surat</span>
                                <span class="text-sm font-bold text-gray-900">{{ $letterTypeName }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-500 block">Tanggal Terbit</span>
                                <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($issuedDate)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-500 block">Status Keabsahan</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    VALID
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Informasi Mahasiswa / Kelompok -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">
                            {{ $isGroup ? 'Informasi Kelompok Mahasiswa' : 'Informasi Mahasiswa Pemohon' }}
                        </h3>

                        @if(!$isGroup)
                            <!-- Individual Student Detail -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-2">
                                <div class="flex justify-between items-center py-1 border-b border-gray-200/60">
                                    <span class="text-xs font-semibold text-gray-500">Nama Mahasiswa</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $studentName ?? $student?->user?->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-xs font-semibold text-gray-500">NIM</span>
                                    <span class="text-sm font-bold text-gray-900 font-mono">{{ $studentNim ?? $student?->student_number ?? '-' }}</span>
                                </div>
                            </div>
                        @else
                            <!-- Group Detail -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 block">Judul / Nama Kelompok</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $groupData['title'] }}</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-xs font-semibold text-gray-500 block">Ketua Kelompok</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $groupData['leader_name'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-gray-500 block">NIM Ketua</span>
                                        <span class="text-sm font-bold text-gray-900 font-mono">{{ $groupData['leader_nim'] }}</span>
                                    </div>
                                </div>

                                <!-- Members Table -->
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 block mb-2">Daftar Anggota Kelompok</span>
                                    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                                        <table class="w-full text-left text-xs">
                                            <thead class="bg-gray-100 text-gray-600 font-bold border-b border-gray-200">
                                                <tr>
                                                    <th class="px-3 py-2 text-center w-10">No</th>
                                                    <th class="px-3 py-2">NIM</th>
                                                    <th class="px-3 py-2">Nama Mahasiswa</th>
                                                    <th class="px-3 py-2 text-center">Peran</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($groupData['members'] as $member)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-3 py-2 text-center font-semibold text-gray-500">{{ $member['no'] }}</td>
                                                        <td class="px-3 py-2 font-mono font-bold text-gray-800">{{ $member['nim'] }}</td>
                                                        <td class="px-3 py-2 font-semibold text-gray-900">{{ $member['name'] }}</td>
                                                        <td class="px-3 py-2 text-center">
                                                            @if($member['is_leader'])
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-amikom-purple">Ketua</span>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">Anggota</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Section: Persetujuan Pejabat & Dosen (Multi-Step Approvers) -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Diterbitkan Oleh / Pejabat Penandatangan</h3>
                        
                        @if($approvalLogs->count() > 0)
                            <div class="space-y-3">
                                @foreach($approvalLogs as $idx => $log)
                                    <div class="flex items-start gap-3 bg-purple-50/60 p-3.5 rounded-xl border border-purple-100">
                                        <div class="w-7 h-7 rounded-full bg-amikom-purple text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">
                                            {{ $idx + 1 }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1">
                                                <span class="text-xs font-extrabold uppercase text-amikom-purple">{{ $log['role_name'] }}</span>
                                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">
                                                    Disetujui: {{ \Carbon\Carbon::parse($log['approved_at'])->translatedFormat('d F Y H:i') }}
                                                </span>
                                            </div>
                                            <div class="text-sm font-bold text-gray-900 mt-0.5">{{ $log['approver_name'] }}</div>
                                            @if($log['approver_nip'] !== '-')
                                                <div class="text-xs text-gray-500 font-mono">NIK/NIDN. {{ $log['approver_nip'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs text-gray-600 font-semibold">
                                Diterbitkan secara resmi oleh Bagian Layanan Akademik Universitas AMIKOM Yogyakarta.
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Footer Banner -->
                <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 text-center">
                    <p class="text-xs text-gray-500">
                        Kode Token Verifikasi: <span class="font-mono font-bold text-gray-700">{{ $token }}</span>
                    </p>
                </div>
            </div>

        @elseif(!empty($isPending))
            <!-- DOKUMEN PRATINJAU / SEDANG DIPROSES CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-amber-200 overflow-hidden">
                <!-- Status Banner -->
                <div class="bg-amber-50 border-b border-amber-200 px-6 py-8 text-center">
                    <div class="w-16 h-16 bg-amber-500 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-md animate-pulse">
                        <x-icon name="hourglass_top" class="w-10 h-10" />
                    </div>
                    <h2 class="text-2xl font-extrabold text-amber-900 tracking-tight">⚠️ DOKUMEN DALAM TAHAP PRATINJAU</h2>
                    <p class="text-sm font-bold text-amber-800 mt-2">Surat Masih Dalam Proses Pengajuan / Verifikasi</p>
                </div>

                <!-- Status Explanation Body -->
                <div class="p-6 md:p-8 text-center space-y-4">
                    <div class="bg-amber-50/50 border border-amber-200 p-4 rounded-xl">
                        <p class="text-sm text-amber-950 font-medium leading-relaxed">
                            {{ $message ?? 'Dokumen surat ini masih dalam proses pengajuan dan belum mendapatkan persetujuan akhir dari seluruh pejabat berwenang.' }}
                        </p>
                        <p class="text-xs text-amber-800 mt-2">
                            Hasil verifikasi keabsahan resmi beserta Tanda Tangan Digital hanya akan aktif setelah surat disetujui penuh.
                        </p>
                    </div>

                    <div class="pt-2 text-xs text-gray-500 space-y-1">
                        <p class="font-mono text-gray-400">Kode Token Pratinjau: {{ $token }}</p>
                    </div>
                </div>
            </div>
        @else
            <!-- DOKUMEN TIDAK VALID CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                <!-- Status Banner -->
                <div class="bg-red-50 border-b border-red-200 px-6 py-8 text-center">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                        <x-icon name="cancel" class="w-10 h-10" />
                    </div>
                    <h2 class="text-2xl font-extrabold text-red-800 tracking-tight">✗ DOKUMEN TIDAK VALID</h2>
                    <p class="text-sm font-bold text-red-700 mt-2">QR Code tidak ditemukan.</p>
                </div>

                <!-- Error Explanation Body -->
                <div class="p-6 md:p-8 text-center space-y-4">
                    <div class="bg-red-50/50 border border-red-100 p-4 rounded-xl">
                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $message ?? 'Dokumen kemungkinan palsu atau telah dicabut dari sistem resmi Universitas AMIKOM Yogyakarta.' }}
                        </p>
                    </div>

                    <div class="pt-2 text-xs text-gray-500 space-y-1">
                        <p>Jika Anda merasa ini adalah kesalahan, silakan hubungi bagian Akademik / Direktorat Sistem Informasi AMIKOM.</p>
                        <p class="font-mono text-gray-400">Kode Token: {{ $token }}</p>
                    </div>
                </div>
            </div>
        @endif

    </main>

    <!-- Footer Copyright -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} Universitas AMIKOM Yogyakarta &bull; All Rights Reserved
        </p>
    </footer>

</body>
</html>
