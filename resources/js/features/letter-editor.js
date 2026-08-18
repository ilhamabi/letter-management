/**
 * Letter Template Editor Feature Module (TinyMCE Integration)
 * Matched with standard A4 letter layout from resources/views/letter/letter-style.css
 */

export const placeholderGroups = [
    {
        name: 'Data Mahasiswa Pemohon / Ketua',
        items: [
            { text: 'Nama Mahasiswa', value: '{{student_name}}' },
            { text: 'NIM', value: '{{student_number}}' },
            { text: 'Program Studi', value: '{{study_program}}' },
            { text: 'Semester', value: '{{semester}}' },
            { text: 'IPK', value: '{{gpa}}' },
            { text: 'Total SKS', value: '{{total_credits}}' },
            { text: 'Nama Mahasiswa (Alias)', value: '{{Nama Mahasiswa}}' },
            { text: 'NIM (Alias)', value: '{{NIM}}' },
            { text: 'Program Studi (Alias)', value: '{{Program Studi}}' },
            { text: 'Semester (Alias)', value: '{{Semester}}' },
            { text: 'Total SKS (Alias)', value: '{{total_sks}}' },
        ]
    },
    {
        name: 'Data Dosen & Pejabat Institusi',
        items: [
            { text: 'Nama Dosen Wali', value: '{{academic_advisor_name}}' },
            { text: 'NIK/NIDN Dosen Wali', value: '{{academic_advisor_nip}}' },
            { text: 'Nama Kaprodi', value: '{{head_of_program_name}}' },
            { text: 'NIK/NIDN Kaprodi', value: '{{head_of_program_nip}}' },
            { text: 'Nama Dosen Pembimbing', value: '{{supervisor_name}}' },
            { text: 'NIK/NIDN Pembimbing', value: '{{supervisor_nip}}' },
            { text: 'Nama Dekan', value: '{{dean_name}}' },
            { text: 'NIK/NIDN Dekan', value: '{{dean_nip}}' },
            { text: 'Nama Kaprodi (Alias)', value: '{{Nama Kaprodi}}' },
            { text: 'NIK/NIDN Kaprodi (Alias)', value: '{{head_of_program_nidn}}' },
        ]
    },
    {
        name: 'Data Kelompok & Tim',
        items: [
            { text: 'Nama Kelompok / Tim', value: '{{group_name}}' },
            { text: 'Nama Ketua Kelompok', value: '{{group_leader_name}}' },
            { text: 'NIM Ketua Kelompok', value: '{{group_leader_number}}' },
            { text: 'Daftar Anggota (Tabel)', value: '{{group_members}}' },
            { text: 'Daftar Anggota (Teks)', value: '{{group_members_list}}' },
            { text: 'Judul Tugas Akhir / Proyek', value: '{{thesis_title}}' },
        ]
    },
    {
        name: 'Data Dokumen, Instansi & Kegiatan',
        items: [
            { text: 'Nomor Surat', value: '{{letter_number}}' },
            { text: 'Keperluan Pengajuan', value: '{{purpose}}' },
            { text: 'Nama Fakultas', value: '{{faculty_name}}' },
            { text: 'Nama Perusahaan / Instansi', value: '{{company_name}}' },
            { text: 'Alamat Instansi / Perusahaan', value: '{{company_address}}' },
            { text: 'Tanggal Mulai Kegiatan', value: '{{start_date}}' },
            { text: 'Tanggal Selesai Kegiatan', value: '{{end_date}}' },
            { text: 'Tahun Akademik', value: '{{academic_year}}' },
            { text: 'Tanggal Pengajuan', value: '{{submission_date}}' },
            { text: 'Tanggal Cetak', value: '{{print_date}}' },
        ]
    }
];

// Flat list of all valid placeholders
export const validPlaceholders = placeholderGroups.flatMap(group => group.items.map(item => item.value));

/**
 * Scans editor document and formats valid typed placeholders into pills,
 * and unwraps invalid pills back into normal text.
 * Moves cursor to the right of newly formed pills.
 */
export function processPlaceholderFormatting(editor) {
    const doc = editor.getDoc();
    if (!doc) return false;

    let modified = false;
    let newlyInsertedLastNode = null;

    // 1. Process existing placeholder pills: unwrap invalid ones & ensure contenteditable="false" on valid ones
    const pills = doc.querySelectorAll('.placeholder-pill');
    pills.forEach(pill => {
        const text = pill.textContent.trim();
        if (!validPlaceholders.includes(text)) {
            const textNode = doc.createTextNode(pill.textContent);
            pill.parentNode.replaceChild(textNode, pill);
            modified = true;
        } else if (!pill.hasAttribute('contenteditable')) {
            pill.setAttribute('contenteditable', 'false');
        }
    });

    // 2. Find text nodes containing {{...}}
    const walk = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT, null, false);
    const nodesToProcess = [];
    let node;
    while ((node = walk.nextNode())) {
        if (node.parentNode && node.parentNode.classList.contains('placeholder-pill')) {
            continue;
        }
        if (node.nodeValue && node.nodeValue.includes('{{')) {
            nodesToProcess.push(node);
        }
    }

    nodesToProcess.forEach(textNode => {
        let text = textNode.nodeValue;
        let hasMatch = false;

        validPlaceholders.forEach(ph => {
            if (text.includes(ph)) {
                hasMatch = true;
            }
        });

        if (hasMatch) {
            let newHtml = text;
            validPlaceholders.forEach(ph => {
                if (newHtml.includes(ph)) {
                    const escaped = ph.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    const re = new RegExp(escaped, 'g');
                    newHtml = newHtml.replace(re, `<span class="placeholder-pill" contenteditable="false">${ph}</span>&nbsp;`);
                }
            });

            if (newHtml !== text) {
                const tempDiv = doc.createElement('div');
                tempDiv.innerHTML = newHtml;

                const frag = doc.createDocumentFragment();
                let lastNode = null;
                while (tempDiv.firstChild) {
                    lastNode = frag.appendChild(tempDiv.firstChild);
                }

                const parentNode = textNode.parentNode;
                parentNode.replaceChild(frag, textNode);
                modified = true;
                newlyInsertedLastNode = lastNode;
            }
        }
    });

    // 3. Move cursor position to the RIGHT (after) the newly formed placeholder pill & space
    if (newlyInsertedLastNode && editor.selection) {
        try {
            const range = doc.createRange();
            range.setStartAfter(newlyInsertedLastNode);
            range.collapse(true);
            editor.selection.setRng(range);
            editor.focus();
        } catch (e) {
            // Silently handle if range offset fails on specific DOM edge cases
        }
    }

    return modified;
}

export function initLetterEditor(editorSelector = '#letter-template-editor', selectSelector = '#placeholder-select') {
    const editorElement = document.querySelector(editorSelector);
    if (!editorElement) return;

    if (typeof tinymce === 'undefined') {
        console.warn('TinyMCE not loaded.');
        return;
    }

    // Destroy existing instance if present
    if (tinymce.get(editorSelector.replace('#', ''))) {
        tinymce.get(editorSelector.replace('#', '')).destroy();
    }

    tinymce.init({
        selector: editorSelector,
        height: 600,
        promotion: false,
        branding: false,
        menubar: 'file edit view insert format table help',
        plugins: 'table lists link code wordcount preview help',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link | code preview',
        content_style: `
            body { 
                font-family: "Times New Roman", Times, serif; 
                font-size: 12pt; 
                line-height: 1.3; 
                color: #000; 
                padding: 20px; 
            }
            .doc-title-main { 
                font-size: 15pt; 
                font-weight: bold; 
                text-align: center; 
                margin-bottom: 2pt; 
            }
            .doc-title-sub { 
                font-size: 12pt; 
                text-align: center; 
                margin-bottom: 12pt; 
            }
            .doc-text-lead { 
                font-size: 12pt; 
                margin-bottom: 4pt; 
            }
            .doc-text-justify { 
                font-size: 12pt; 
                text-align: justify; 
                margin-bottom: 8pt; 
            }
            .info-table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-top: 4pt; 
                margin-bottom: 8pt; 
            }
            .info-table td { 
                padding: 2pt 4pt; 
                vertical-align: top; 
            }
            .placeholder-pill {
                display: inline-block;
                background-color: #f3e8ff;
                color: #6b21a8;
                border: 1px dashed #c084fc;
                border-radius: 9999px;
                padding: 2px 10px;
                font-family: monospace;
                font-size: 11pt;
                font-weight: 600;
                user-select: all;
                cursor: pointer;
                margin: 0 2px;
            }
        `,
        setup: function (editor) {
            editor.on('init', function () {
                processPlaceholderFormatting(editor);
            });

            editor.on('keyup change Undo Redo ExecCommand NodeChange', function () {
                processPlaceholderFormatting(editor);
            });

            // Quick select helper listener
            const selectEl = document.querySelector(selectSelector);
            if (selectEl) {
                selectEl.addEventListener('change', function () {
                    const val = this.value;
                    if (!val || val === '+ SISIPKAN PLACEHOLDER') return;

                    const pillHtml = `<span class="placeholder-pill" contenteditable="false">${val}</span>&nbsp;`;
                    editor.insertContent(pillHtml);
                    this.value = '';
                    processPlaceholderFormatting(editor);
                });
            }
        }
    });
}


