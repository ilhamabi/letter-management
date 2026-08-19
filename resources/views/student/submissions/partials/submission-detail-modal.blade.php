<!-- Submission Detail Modal Component -->
<x-modal id="status-modal" title="Detail Status Pengajuan" maxWidth="max-w-lg">
    <x-slot:subtitle>
        <span id="modal-doc-name">Verifikasi Pendaftaran</span>
    </x-slot:subtitle>

    <div class="mb-4">
        <span
            class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-700 border border-gray-200 flex items-center justify-center gap-1.5 w-fit"
            id="modal-status-badge">
            <span class="w-1.5 h-1.5 rounded-full bg-[#92400e] animate-pulse"></span>
            <span id="modal-status-text">SEDANG DIPROSES</span>
        </span>
    </div>

    <!-- Status Timeline -->
    <div class="relative pl-8 space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant"
        id="timeline-container">
        <!-- Timeline items will be populated dynamically -->
    </div>

    <hr class="border-outline-variant">

    <!-- Details Section -->
    <div class="space-y-6">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">KEPERLUAN</p>
            <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-purpose">Syarat Beasiswa</p>
        </div>

        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold mb-2">DOSEN DITUJU</p>
            <div id="modal-approvers-grid" class="grid grid-cols-2 gap-3">
                <!-- Will be populated dynamically by JS -->
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">NIM</p>
                <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-nim">{{ $nim ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-1">PROGRAM
                    STUDI</p>
                <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-prodi">{{ $prodi ?? 'D3 Teknik Informatika' }}</p>
            </div>
        </div>

        <!-- Team / Group Section -->
        <div id="modal-team-section" class="hidden space-y-2 p-3.5 bg-gray-50/50 rounded-xl border border-gray-200">
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold">INFORMASI TIM / PENGAJU</p>
            <div class="text-xs text-gray-700 space-y-1">
                <p><span class="font-bold text-gray-900">Ketua Tim (Pengaju):</span> <span id="modal-creator-name">-</span> (<span id="modal-creator-nim">-</span>)</p>
                <div id="modal-members-list-wrapper">
                    <p class="font-bold text-gray-900 mt-1.5 mb-0.5">Anggota Tim:</p>
                    <ul id="modal-members-list" class="list-disc pl-5 text-gray-600 space-y-0.5"></ul>
                </div>
            </div>
        </div>

        <!-- Additional Info / Instansi Section -->
        <div id="modal-additional-section" class="hidden space-y-2 p-3.5 bg-gray-50/50 rounded-xl border border-gray-200">
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold">INFORMASI TAMBAHAN / INSTANSI</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs" id="modal-additional-grid">
                <!-- Dynamically populated key-value items in exact order (thesis_title, company_name, company_address, start_date, end_date) -->
            </div>
        </div>

        <div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold mb-2">LAMPIRAN</p>
            <div class="grid grid-cols-2 gap-4" id="attachments-container">
                <!-- Attachments will be populated dynamically -->
            </div>
        </div>
    </div>

    <!-- Official Issued Document Card (Shown when submission is approved/completed) -->
    <div id="modal-approved-doc-section" class="hidden space-y-3 p-4 bg-emerald-50 rounded-xl border border-emerald-200 my-4 animate-fade-in">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2 text-emerald-900 font-bold text-sm">
                <x-icon name="verified" class="w-5 h-5 text-emerald-600 shrink-0" />
                <span>Dokumen Resmi Telah Terbit</span>
            </div>
            <span id="modal-doc-filename" class="text-[11px] font-mono font-bold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded border border-emerald-200 truncate max-w-[220px]">
                Surat_Resmi.pdf
            </span>
        </div>
        <p class="text-xs text-emerald-800 leading-relaxed">
            Permohonan Anda telah disetujui secara lengkap oleh seluruh pejabat berwenang. Dokumen ini sah dan dilengkapi dengan QR Code Verifikasi.
        </p>
        <div class="flex gap-2.5 pt-1">
            <a id="btn-preview-approved-doc" href="#" target="_blank" class="flex-1 py-2.5 px-3 bg-white hover:bg-emerald-100/60 border border-emerald-300 text-emerald-800 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-2xs">
                <x-icon name="visibility" class="w-4 h-4 text-emerald-700" />
                <span>Pratinjau Surat</span>
            </a>
            <a id="btn-download-approved-doc" href="#" class="flex-1 py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-xs">
                <x-icon name="download" class="w-4 h-4" />
                <span>Unduh / Cetak Surat</span>
            </a>
        </div>
    </div>

    <!-- SLA Info Box -->
    <div class="bg-primary-fixed/10 p-4 rounded-lg border border-primary-container/10 flex gap-3">
        <x-icon name="info" class="w-5 h-5 text-primary shrink-0" />
        <p class="text-body-sm text-on-surface-variant">Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika
            belum ada pembaruan, Anda dapat menghubungi dosen terkait.</p>
    </div>

    <x-slot:footer>
        <button class="px-8 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow"
            onclick="typeof closeModal === 'function' ? closeModal('status-modal') : document.getElementById('status-modal').classList.add('hidden')">
            Tutup
        </button>
    </x-slot:footer>
</x-modal>

@push('scripts')
    <script>
        function openStatusModal(data) {
            // Update Title & Status Badge
            document.getElementById('modal-doc-name').innerText = data.type;
            document.getElementById('modal-status-text').innerText = (data.statusText || data.status || 'SEDANG DIPROSES').toUpperCase();
            
            const modalStatusBadge = document.getElementById('modal-status-badge');
            if (modalStatusBadge && data.statusBadgeClass) {
                modalStatusBadge.className = `px-3.5 py-1.5 rounded-full text-xs font-bold border tracking-wider transition-colors inline-flex items-center gap-1.5 w-fit ${data.statusBadgeClass}`;
            }

            // Populate Team Info Section
            const teamSection = document.getElementById('modal-team-section');
            const creatorName = document.getElementById('modal-creator-name');
            const creatorNim = document.getElementById('modal-creator-nim');
            const membersList = document.getElementById('modal-members-list');

            if (teamSection) {
                if (data.isGroup || (data.members && data.members.length > 0)) {
                    teamSection.classList.remove('hidden');
                    if (creatorName) creatorName.innerText = data.creatorName || '-';
                    if (creatorNim) creatorNim.innerText = data.creatorNim || '-';

                    if (membersList) {
                        membersList.innerHTML = '';
                        if (data.members && data.members.length > 0) {
                            data.members.forEach(m => {
                                membersList.insertAdjacentHTML('beforeend', `<li>${m.name} (NIM: ${m.nim})</li>`);
                            });
                        } else {
                            membersList.insertAdjacentHTML('beforeend', '<li class="italic text-on-surface-variant/70">Tidak ada anggota tambahan</li>');
                        }
                    }
                } else {
                    teamSection.classList.add('hidden');
                }
            }

            // Populate Additional Data / Instansi Section
            const additionalSection = document.getElementById('modal-additional-section');
            const additionalGrid = document.getElementById('modal-additional-grid');

            if (additionalSection && additionalGrid) {
                additionalGrid.innerHTML = '';
                const addData = data.additional_data || data.additionalData;
                if (addData && typeof addData === 'object' && Object.keys(addData).length > 0) {
                    let hasItems = false;
                    const preferredOrder = ['thesis_title', 'company_name', 'company_address', 'start_date', 'end_date', 'group_name', 'academic_year', 'total_credits', 'gpa', 'purpose'];

                    const labelMap = {
                        'thesis_title': 'Judul Tugas Akhir / Proyek',
                        'company_name': 'Nama Instansi / Perusahaan',
                        'company_address': 'Alamat Instansi / Perusahaan',
                        'start_date': 'Tanggal Mulai',
                        'end_date': 'Tanggal Selesai',
                        'total_credits': 'Total SKS',
                        'gpa': 'IPK Kumulatif',
                        'group_name': 'Nama Kelompok / Tim',
                        'academic_year': 'Tahun Akademik',
                        'purpose': 'Keperluan / Alasan'
                    };

                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];

                    const entries = Object.entries(addData).sort(([keyA], [keyB]) => {
                        let idxA = preferredOrder.indexOf(keyA);
                        let idxB = preferredOrder.indexOf(keyB);
                        if (idxA === -1) idxA = 999;
                        if (idxB === -1) idxB = 999;
                        return idxA - idxB;
                    });

                    for (const [key, val] of entries) {
                        if (val && typeof val !== 'object') {
                            hasItems = true;
                            const label = labelMap[key] || key.replace(/_/g, ' ').toUpperCase();
                            let displayVal = val;

                            if (['start_date', 'end_date'].includes(key) && val) {
                                try {
                                    const parts = String(val).split('-');
                                    if (parts.length === 3) {
                                        const year = parts[0];
                                        const mIdx = parseInt(parts[1], 10) - 1;
                                        const day = parseInt(parts[2], 10);
                                        if (mIdx >= 0 && mIdx < 12) {
                                            displayVal = `${day} ${months[mIdx]} ${year}`;
                                        }
                                    }
                                } catch (e) {
                                    displayVal = val;
                                }
                            }

                            const itemHtml = `
                                <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                    <span class="text-gray-500 font-semibold block uppercase text-[10px] tracking-wider mb-0.5">${label}</span>
                                    <span class="text-gray-900 font-bold text-xs">${displayVal}</span>
                                </div>
                            `;
                            additionalGrid.insertAdjacentHTML('beforeend', itemHtml);
                        }
                    }

                    if (hasItems) {
                        additionalSection.classList.remove('hidden');
                    } else {
                        additionalSection.classList.add('hidden');
                    }
                } else {
                    additionalSection.classList.add('hidden');
                }
            }

            const timelineContainer = document.getElementById('timeline-container');
            timelineContainer.innerHTML = ''; // Clear previous items

            if (data.timeline && data.timeline.length > 0) {
                data.timeline.forEach((step) => {
                    let iconBgClass = '';
                    let iconSvg = '';
                    let pulseClass = '';
                    let textClass = 'text-gray-900 font-bold';

                    if (step.status === 'completed') {
                        iconBgClass = 'bg-emerald-500 text-white ring-4 ring-emerald-100';
                        iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                    } else if (step.status === 'rejected') {
                        iconBgClass = 'bg-rose-500 text-white ring-4 ring-rose-100';
                        iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                    } else if (step.status === 'active') {
                        iconBgClass = 'bg-amber-500 text-white ring-4 ring-amber-100';
                        iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                        pulseClass = 'animate-pulse';
                    } else {
                        iconBgClass = 'bg-slate-300 text-white ring-4 ring-slate-100';
                        iconSvg = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                        textClass = 'text-gray-400 font-medium';
                    }

                    const notesHtml = step.notes ? `<p class="text-xs text-gray-700 mt-1 bg-gray-50 p-2.5 rounded-lg border border-gray-200">Catatan: ${step.notes}</p>` : '';

                    const stepHtml = `
                        <div class="relative font-body-sm">
                            <div class="absolute -left-8 w-6 h-6 rounded-full ${iconBgClass} flex items-center justify-center z-10 ${pulseClass}">
                                ${iconSvg}
                            </div>
                            <div>
                                <p class="font-label-lg text-label-lg ${textClass}">${step.title}</p>
                                <p class="text-body-sm text-gray-500 mt-0.5">${step.time}</p>
                                ${notesHtml}
                            </div>
                        </div>
                    `;
                    timelineContainer.insertAdjacentHTML('beforeend', stepHtml);
                });
            }

            // Update Details
            document.getElementById('modal-purpose').innerText = data.purpose || 'Pengajuan dokumen akademik';
            
            const approversGrid = document.getElementById('modal-approvers-grid');
            if (approversGrid) {
                if (data.approvers && data.approvers.length > 0) {
                    approversGrid.innerHTML = '';
                    data.approvers.forEach(approver => {
                        const approverCard = `
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-0.5">${approver.role}</p>
                                <p class="text-xs font-bold text-gray-900">${approver.name}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">NIP/NIK: ${approver.nik || '—'}</p>
                                <p class="text-[10px] text-gray-500">Email: ${approver.email || '—'}</p>
                            </div>
                        `;
                        approversGrid.insertAdjacentHTML('beforeend', approverCard);
                    });
                } else {
                    approversGrid.innerHTML = '<p class="text-xs text-gray-500 italic col-span-2">Belum ada dosen dituju</p>';
                }
            }
            
            if (document.getElementById('modal-nim')) {
                document.getElementById('modal-nim').innerText = data.nim || data.creatorNim || '-';
            }
            if (document.getElementById('modal-prodi')) {
                document.getElementById('modal-prodi').innerText = data.prodi || data.study_program || 'D3 Teknik Informatika';
            }

            // Update Attachments
            const attachmentsContainer = document.getElementById('attachments-container');
            attachmentsContainer.innerHTML = '';
            if (data.attachments && data.attachments.length > 0) {
                data.attachments.forEach(file => {
                    const targetUrl = file.url ? file.url : '#';
                    const fileHtml = `
                        <a href="${targetUrl}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group col-span-2 sm:col-span-1">
                            <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"/><path d="M9 13v6"/></svg>
                            </div>
                            <div class="overflow-hidden font-body-sm flex-1">
                                <p class="text-label-sm text-deep-black truncate font-semibold" title="${file.name}">${file.name}</p>
                                <p class="text-[10px] text-on-surface-variant">${file.size}</p>
                            </div>
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                    `;
                    attachmentsContainer.insertAdjacentHTML('beforeend', fileHtml);
                });
            } else {
                attachmentsContainer.innerHTML = '<p class="text-body-sm text-on-surface-variant italic col-span-2">Tidak ada lampiran</p>';
            }

            // Toggle Approved Document Card & Action Buttons
            const approvedDocSection = document.getElementById('modal-approved-doc-section');
            const docFilename = document.getElementById('modal-doc-filename');
            const btnPreviewDoc = document.getElementById('btn-preview-approved-doc');
            const btnDownloadDoc = document.getElementById('btn-download-approved-doc');

            const isApproved = data.isApproved === true || 
                ['approved', 'generated', 'disetujui'].includes(String(data.status || '').toLowerCase()) ||
                String(data.statusText || '').toLowerCase() === 'disetujui' ||
                String(data.statusText || '').toLowerCase() === 'selesai';

            if (approvedDocSection) {
                if (isApproved) {
                    approvedDocSection.classList.remove('hidden');
                    if (docFilename) docFilename.innerText = data.fileName || 'Surat_Resmi.pdf';
                    if (btnPreviewDoc) btnPreviewDoc.href = data.previewUrl || `/student/submissions/${data.id}/preview`;
                    if (btnDownloadDoc) btnDownloadDoc.href = data.downloadUrl || `/student/submissions/${data.id}/download`;
                } else {
                    approvedDocSection.classList.add('hidden');
                }
            }

            // Show Modal
            if (typeof openModal === 'function') {
                openModal('status-modal');
            } else {
                document.getElementById('status-modal').classList.remove('hidden');
            }
        }
    </script>
@endpush
