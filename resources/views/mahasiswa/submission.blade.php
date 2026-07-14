@extends('layouts.mahasiswa')

@section('title', 'Buat Permintaan Baru - Layanan Dokumen')

@php
    // Default / Mock data so the submission page works out of the box even without controller variables
    $studentName = $studentName ?? (auth()->check() ? auth()->user()->name : 'Alex Chandra');
    $nim = $nim ?? '21.11.9999';
    $prodi = $prodi ?? 'S1 Informatika';
    $profilePhoto = $profilePhoto ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAI8U6QdliiTjyZkmQbBg28RYGNyEZiVLatEqMLpzH_ob8gvGl3P0O3s-Qt3Fc_D79jcaahFcbv3qSGezuoYVvawMrNM46hPYZSlOtyaAlPOojd2ZNhDPc1JYxE7y4tEponJE2zSBgJXYCeIo86cW_9J3AKqWvThHpMPKk9_JoTHl67QUOIb6pY3uPxrBpOxsik07pJOMRi5tfE-Y5BWv_wSM8ZGJ0l6pO-W_bb1XcmX1-qIBDqQRuXnyhiZkKKhr43d09ocXNKJ80';
@endphp

@section('content')
    <nav class="flex items-center gap-2 text-on-surface-variant font-label-sm">
        <a class="hover:text-primary transition-colors" href="#">Portal</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="#">Layanan Dokumen</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-primary font-semibold">Buat Permintaan Baru</span>
    </nav>
    
    <header>
        <h3 class="font-headline-lg text-[32px] text-on-surface font-bold mb-3">Buat Permintaan Baru</h3>
        <p class="font-body-md text-on-surface-variant max-w-3xl leading-relaxed">
            Silakan lengkapi formulir di bawah ini untuk mengajukan permintaan dokumen akademik. Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan.
        </p>
    </header>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-8 bg-pure-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="p-8">
                <form class="space-y-8" id="request-form">
                    @csrf
                    <div class="space-y-2">
                        <label class="block font-label-lg text-on-surface mb-1" for="jenis_surat">Jenis Surat</label>
                        <div class="relative">
                            <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 appearance-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md" id="jenis_surat">
                                <option disabled="" selected="" value="">Pilih jenis surat...</option>
                                <option value="transkrip">Transkrip Resmi (Official Transcript)</option>
                                <option value="keterangan_aktif">Surat Keterangan Aktif Kuliah</option>
                                <option value="sertifikat_lulus">Sertifikat Kelulusan (SKL)</option>
                                <option value="legalisir">Legalisir Ijazah/Transkrip</option>
                                <option value="pengantar_magang">Surat Pengantar Magang</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-label-lg text-on-surface mb-1" for="keperluan">Keperluan</label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md resize-none" id="keperluan" placeholder="Contoh: Pengajuan Beasiswa PPA, Persyaratan Magang di PT. Telkom..." rows="3"></textarea>
                        <p class="text-[12px] text-on-surface-variant">Jelaskan secara singkat tujuan penggunaan dokumen ini.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-label-lg text-on-surface mb-1" for="catatan">Catatan Tambahan <span class="text-on-surface-variant font-normal text-sm ml-1">(Opsional)</span></label>
                        <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md resize-none" id="catatan" placeholder="Tambahkan informasi tambahan jika diperlukan..." rows="4"></textarea>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block font-label-lg text-on-surface mb-1">Lampiran Pendukung</label>
                            <p class="text-[12px] text-on-surface-variant mb-3">Unggah dokumen pendukung (KTM, Transkrip, atau Bukti Bayar) dalam format PDF (Maks. 2MB)</p>
                        </div>
                        <div class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-surface-container-low/30 hover:bg-surface-container-low transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">upload_file</span>
                            </div>
                            <div class="text-center">
                                <p class="font-medium text-on-surface">Tarik dan lepas berkas di sini</p>
                                <p class="text-xs text-on-surface-variant mt-1">atau</p>
                            </div>
                            <button class="px-6 py-2 bg-pure-white border border-outline-variant rounded-lg text-primary font-label-md hover:bg-primary hover:text-on-primary transition-all" type="button">Pilih Berkas</button>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-surface-container-lowest border border-outline-variant rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-error/10 flex items-center justify-center text-error">
                                        <span class="material-symbols-outlined">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-on-surface">KTM_Alex_Chandra.pdf</p>
                                        <p class="text-[10px] text-on-surface-variant">1.2 MB</p>
                                    </div>
                                </div>
                                <button class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-outline-variant">
                        <button class="w-full bg-primary text-on-primary font-label-lg py-4 px-6 rounded-xl hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/10 flex items-center justify-center gap-2" id="submit-request-btn" type="button">
                            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'wght' 600;">send</span>
                            Ajukan Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-primary-container text-on-primary-container p-6 rounded-xl border border-primary/10">
                <h4 class="font-title-lg text-[18px] font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">info</span>
                    Informasi Penting
                </h4>
                <ul class="space-y-4 text-[13px] leading-relaxed">
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">timer</span>
                        <span class="">Proses pengerjaan dokumen membutuhkan waktu <strong>2-3 hari kerja</strong>.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">mail</span>
                        <span class="">Notifikasi akan dikirimkan melalui email dan dashboard portal.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-[18px] shrink-0 text-primary-container-on">download</span>
                        <span class="">Dokumen digital dapat diunduh langsung setelah status <strong>"Selesai"</strong>.</span>
                    </li>
                </ul>
            </div>
            
            <div class="relative bg-secondary-container rounded-xl border border-secondary/20 overflow-hidden group">
                <div class="relative p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="font-title-lg text-[18px] font-bold text-on-secondary-container">Informasi Mahasiswa</h4>
                        <span class="px-2 py-1 bg-pure-white/50 rounded-full text-[10px] font-bold text-secondary uppercase tracking-wider border border-secondary/20">Identity Verified</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pure-white flex items-center justify-center text-secondary shadow-sm">
                                <span class="material-symbols-outlined text-[24px]">school</span>
                            </div>
                            <div>
                                <p class="text-[12px] text-on-secondary-container/70 font-medium">Status Akademik</p>
                                <p class="font-bold text-on-secondary-container">Aktif Kuliah</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">Total SKS</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">112</p>
                            </div>
                            <div class="bg-pure-white/40 p-3 rounded-xl border border-secondary/10">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-1">IPK</p>
                                <p class="text-[18px] font-bold text-on-secondary-container">3.85</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-secondary/10">
                            <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Dosen Wali</p>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">person_4</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-on-secondary-container text-[14px]">Heri Setyawan, M.Kom.</p>
                                    <p class="text-[12px] text-on-secondary-container/70">NIDN: 123456789</p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10 mt-4">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Ketua Program Studi</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">person_3</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">Dr. Andi Wijaya, M.T.</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: 061234567</p>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-secondary/10 mt-4">
                                <p class="text-[10px] text-on-secondary-container/70 uppercase font-bold tracking-wider mb-3">Dosen Pembimbing</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">person_2</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-on-secondary-container text-[14px]">Siti Aminah, S.Kom., M.Cs.</p>
                                        <p class="text-[12px] text-on-secondary-container/70">NIDN: 069876543</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="fixed inset-0 z-[100] hidden" id="confirmation-modal">
        <div class="absolute inset-0 bg-deep-black/60 backdrop-blur-sm animate-fade-in" id="modal-backdrop"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-pure-white w-full max-w-md rounded-xl shadow-xl overflow-hidden transform animate-scale-up border border-outline-variant">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'wght' 500;">help</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-[20px] font-bold text-on-surface leading-tight">Konfirmasi Pengajuan</h3>
                            <p class="text-on-surface-variant text-[12px] font-medium tracking-wide uppercase mt-0.5">Permintaan Dokumen</p>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-body-md mb-8 leading-relaxed">
                        Apakah Anda yakin data yang dimasukkan sudah benar? Permintaan yang sudah dikirim <span class="font-bold text-on-surface">tidak dapat diubah kembali</span>.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button class="flex-1 order-2 sm:order-1 py-3.5 px-4 rounded-xl border border-outline-variant text-on-surface font-label-lg hover:bg-surface-container-low transition-all active:scale-[0.98]" id="close-modal-btn">
                            Batal
                        </button>
                        <button class="flex-1 order-1 sm:order-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg hover:brightness-110 active:scale-[0.98] transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2" id="confirm-submit-btn">
                            <span>Ya, Ajukan</span>
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('confirmation-modal');
    const openBtn = document.getElementById('submit-request-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const backdrop = document.getElementById('modal-backdrop');
    const confirmBtn = document.getElementById('confirm-submit-btn');

    const toggleModal = (show) => {
        if (show) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

    openBtn.addEventListener('click', () => toggleModal(true));
    closeBtn.addEventListener('click', () => toggleModal(false));
    backdrop.addEventListener('click', () => toggleModal(false));
    
    confirmBtn.addEventListener('click', () => {
        confirmBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span><span>Memproses...</span>';
        setTimeout(() => {
            toggleModal(false);
            confirmBtn.innerHTML = '<span>Ya, Ajukan</span><span class="material-symbols-outlined text-[18px]">check_circle</span>';
            alert('Permintaan Anda telah berhasil dikirim!');
        }, 1500);
    });
</script>
@endpush
