@props([
    'id' => 'status-detail-modal',
    'nim' => $nim ?? '',
    'prodi' => $prodi ?? '',
])

<!-- Student Submission Status Detail Modal Component -->
<x-modal :id="$id" title="Status Pengajuan" maxWidth="max-w-lg">
    <x-slot:subtitle>
        <span id="modal-doc-name"></span>
    </x-slot:subtitle>

    <div class="space-y-6">
        <!-- Status Badge -->
        <div>
            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center justify-center gap-1.5" id="modal-status-badge">
                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse" id="modal-status-dot"></span>
                <span id="modal-status-text"></span>
            </span>
        </div>

        <!-- Status Timeline -->
        <div class="relative pl-8 space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant" id="modal-timeline-container">
            <!-- Timeline items rendered dynamically -->
        </div>

        <hr class="border-outline-variant">

        <!-- Details Section -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2 space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Keperluan</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-purpose-text"></p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">NIM</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-nim-text">{{ $nim }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Program Studi</p>
                    <p class="font-label-lg text-label-lg text-deep-black font-bold" id="modal-prodi-text">{{ $prodi }}</p>
                </div>
                <div class="col-span-1 md:col-span-2 space-y-1 bg-error-container/20 p-3 rounded-lg border border-error/20 hidden" id="modal-reason-box">
                    <p class="text-[10px] uppercase tracking-widest text-error font-semibold">Alasan Penolakan</p>
                    <p class="font-label-lg text-label-lg text-deep-black" id="modal-reason-text"></p>
                </div>
            </div>

            <div class="space-y-2">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-semibold">Lampiran</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="modal-attachments-container">
                    <!-- Attachments rendered dynamically -->
                </div>
            </div>
        </div>

        <!-- SLA / Status Info Box -->
        <div class="p-4 rounded-lg border flex gap-3" id="modal-sla-box">
            <x-icon name="info" class="w-5 h-5 shrink-0" />
            <p class="text-body-sm" id="modal-sla-text"></p>
        </div>
    </div>

    <x-slot:footer>
        <button class="px-6 py-2 border border-primary text-primary font-label-md rounded-lg hover:bg-primary-fixed/20 transition-colors flex items-center gap-2" id="download-btn">
            <x-icon name="download" class="w-4 h-4" />
            Unduh Dokumen
        </button>
        <button class="px-6 py-2 bg-primary text-white font-label-md rounded-lg hover:shadow-md transition-shadow" onclick="closeModal('{{ $id }}')">Tutup</button>
    </x-slot:footer>
</x-modal>

@push('scripts')
<script>
    if (typeof renderTimelineStep !== 'function') {
        /**
         * Render individual timeline step HTML with appropriate status badge styling
         */
        function renderTimelineStep(title, subtitle, stepStatus) {
            const stepStyles = {
                completed: {
                    bg: 'bg-green-100 text-green-700',
                    svg: '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
                    color: 'text-deep-black',
                    pulse: ''
                },
                active: {
                    bg: 'bg-secondary-container text-secondary',
                    svg: '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>',
                    color: 'text-deep-black',
                    pulse: 'animate-pulse'
                },
                rejected: {
                    bg: 'bg-error-container text-error',
                    svg: '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
                    color: 'text-error',
                    pulse: ''
                },
                pending: {
                    bg: 'bg-surface-container text-on-surface-variant',
                    svg: '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
                    color: 'text-on-surface-variant',
                    pulse: ''
                }
            };

            const config = stepStyles[stepStatus] || stepStyles.pending;

            return `
                <div class="relative font-body-sm">
                    <div class="absolute -left-8 w-6 h-6 rounded-full ${config.bg} flex items-center justify-center z-10 ${config.pulse}">
                        ${config.svg}
                    </div>
                    <div>
                        <p class="font-label-lg text-label-lg ${config.color}">${title}</p>
                        <p class="text-body-sm text-on-surface-variant">${subtitle}</p>
                    </div>
                </div>
            `;
        }
    }

    /**
     * Display Student Submission Status Detail Modal with dynamic backend payload
     */
    function showStatusDetailModal(title, date, status, reason = '') {
        // 1. Extract and normalize backend payload
        let payload = {
            title: '',
            date: date || '-',
            status: status || '',
            statusText: (status || '').toUpperCase(),
            reason: reason || '',
            purpose: '',
            nim: '',
            prodi: '',
            attachments: [],
            timeline: []
        };

        if (typeof title === 'object' && title !== null) {
            const obj = title;
            const datePart = obj.date || (obj.created_at ? obj.created_at.substring(0, 10) : '');
            const timePart = obj.time || obj.datetime || '';

            payload.title = obj.type || (obj.letter_type ? obj.letter_type.name : 'Surat');
            payload.date = (datePart && timePart) 
                ? (timePart.includes(datePart) ? timePart : (datePart.includes(':') ? datePart : `${datePart}, ${timePart}`)) 
                : (datePart || timePart || '-');
            payload.status = typeof obj.status === 'object' ? (obj.status.value || obj.status.label || '') : (obj.status || '');
            payload.statusText = obj.statusText || obj.statusLabel || payload.status.toUpperCase();
            payload.reason = obj.reason || obj.rejection_note || '';
            payload.purpose = obj.purpose || '';
            payload.nim = obj.nim || '';
            payload.prodi = obj.prodi || '';
            payload.attachments = obj.attachments || [];
            payload.timeline = obj.timeline || [];
        } else {
            payload.title = title || 'Detail Pengajuan Surat';
        }

        // 2. Safe DOM Text Setter Helper
        const updateText = (id, val) => {
            const element = document.getElementById(id);
            if (element && val !== undefined && val !== null && val !== '') {
                element.innerText = val;
            }
        };

        updateText('modal-doc-name', payload.title);
        updateText('modal-purpose-text', payload.purpose);
        if (payload.nim) updateText('modal-nim-text', payload.nim);
        if (payload.prodi) updateText('modal-prodi-text', payload.prodi);

        // 3. Configure Status Badge, SLA Info Box, Rejection Reason & Download Button
        const badge = document.getElementById('modal-status-badge');
        const badgeText = document.getElementById('modal-status-text');
        const reasonBox = document.getElementById('modal-reason-box');
        const reasonText = document.getElementById('modal-reason-text');
        const slaBox = document.getElementById('modal-sla-box');
        const slaText = document.getElementById('modal-sla-text');
        const downloadBtn = document.getElementById('download-btn');

        const normStatus = payload.status.trim().toLowerCase();

        if (normStatus === 'disetujui' || normStatus === 'approved') {
            if (badge) badge.className = 'px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center justify-center gap-1.5 bg-green-100 text-green-800 border border-green-200';
            if (badgeText) badgeText.innerText = payload.statusText.toUpperCase();

            if (reasonBox) reasonBox.classList.add('hidden');
            if (slaBox) slaBox.className = 'p-4 rounded-lg border bg-green-100 text-green-800 border-green-200 flex gap-3';
            if (slaText) slaText.innerText = 'Pengajuan Anda telah disetujui. Dokumen dapat diunduh.';
            if (downloadBtn) downloadBtn.classList.remove('hidden');

        } else if (normStatus === 'ditolak' || normStatus === 'rejected') {
            if (badge) badge.className = 'px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center justify-center gap-1.5 bg-error-container text-error border border-error/20';
            if (badgeText) badgeText.innerText = payload.statusText.toUpperCase();

            if (reasonText) reasonText.innerText = payload.reason || '-';
            if (reasonBox) reasonBox.classList.toggle('hidden', !payload.reason);

            if (slaBox) slaBox.className = 'p-4 rounded-lg border bg-error-container/20 text-on-surface-variant border-error/20 flex gap-3';
            if (slaText) slaText.innerText = 'Pengajuan Anda ditolak. Silakan perbaiki data sesuai alasan penolakan dan buat pengajuan baru.';
            if (downloadBtn) downloadBtn.classList.add('hidden');

        } else {
            if (badge) badge.className = 'px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center justify-center gap-1.5 bg-[#fef3c7] text-[#92400e] border border-[#fcd400]';
            if (badgeText) badgeText.innerText = payload.statusText.toUpperCase();

            if (reasonBox) reasonBox.classList.add('hidden');
            if (slaBox) slaBox.className = 'p-4 rounded-lg border bg-primary-fixed/20 text-on-surface-variant border-primary/10 flex gap-3';
            if (slaText) slaText.innerText = 'Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika belum ada pembaruan, Anda dapat menghubungi dosen terkait.';
            if (downloadBtn) downloadBtn.classList.add('hidden');
        }

        // 4. Render Timeline Steps from Backend Array
        const timelineContainer = document.getElementById('modal-timeline-container');
        if (timelineContainer) {
            let steps = [];
            if (Array.isArray(payload.timeline) && payload.timeline.length > 0) {
                const hasSubmitted = payload.timeline.some(s => 
                    (s.title || '').toLowerCase().includes('terkirim') || 
                    (s.title || '').toLowerCase().includes('pengajuan')
                );
                steps = hasSubmitted
                    ? payload.timeline.map(s => ({ title: s.title, subtitle: s.time, status: s.status }))
                    : [{ title: 'Pengajuan Terkirim', subtitle: payload.date, status: 'completed' }, ...payload.timeline.map(s => ({ title: s.title, subtitle: s.time, status: s.status }))];
            } else {
                steps = [
                    { title: 'Pengajuan Terkirim', subtitle: payload.date, status: 'completed' },
                    { title: 'Proses Verifikasi', subtitle: normStatus === 'approved' ? 'Selesai' : (normStatus === 'rejected' ? 'Ditolak' : 'Sedang diproses'), status: normStatus === 'approved' ? 'completed' : (normStatus === 'rejected' ? 'rejected' : 'active') }
                ];
            }

            timelineContainer.innerHTML = steps.map(s => renderTimelineStep(s.title, s.subtitle, s.status)).join('');
        }

        // 5. Render Attachment Cards from Backend Array
        const attachmentsContainer = document.getElementById('modal-attachments-container');
        if (attachmentsContainer) {
            const validAttachments = Array.isArray(payload.attachments) 
                ? payload.attachments.filter(file => {
                    if (!file) return false;
                    const sizeStr = (file.size || '').toString().toLowerCase();
                    return !sizeStr.includes('tidak ada') && !sizeStr.includes('no file');
                }) 
                : [];

            if (validAttachments.length > 0) {
                attachmentsContainer.innerHTML = validAttachments.map(file => {
                    const fileName = file.name || file.original_filename || 'Dokumen.pdf';
                    const fileSize = file.size || (file.file_size ? (Math.round(file.file_size / 1024) + ' KB') : '-');
                    const fileUrl = file.url || (file.file_path ? (`/storage/${file.file_path}`) : '#');
                    const isDummy = fileUrl === '#';

                    return `
                        <a href="${fileUrl}" ${isDummy ? 'onclick="event.preventDefault()"' : 'target="_blank" download="' + fileName + '"'} class="flex items-center gap-3 p-3 border border-outline-variant rounded-lg hover:bg-surface-container transition-colors cursor-pointer group">
                            <div class="w-10 h-10 bg-error-container/20 rounded flex items-center justify-center text-error shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"/><path d="M9 13v6"/></svg>
                            </div>
                            <div class="overflow-hidden font-body-sm flex-grow">
                                <p class="text-label-sm text-deep-black truncate font-semibold group-hover:text-primary transition-colors">${fileName}</p>
                                <p class="text-[10px] text-on-surface-variant">${fileSize}</p>
                            </div>
                            <svg class="w-4 h-4 text-on-surface-variant group-hover:text-primary shrink-0 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </a>
                    `;
                }).join('');
            } else {
                attachmentsContainer.innerHTML = '<p class="text-body-sm text-on-surface-variant italic col-span-2">Tidak ada lampiran</p>';
            }
        }

        openModal('{{ $id }}');
    }

    // Aliases for compatibility
    function openDetailModal(title, date, status, reason = '') { showStatusDetailModal(title, date, status, reason); }
    function openStatusModal(title, date, status, reason = '') { showStatusDetailModal(title, date, status, reason); }
</script>
@endpush
