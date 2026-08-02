/**
 * Letter Template Editor Feature Module (TinyMCE Integration)
 * Matched with standard A4 letter layout from resources/views/letter/letter-style.css
 */

export const placeholderGroups = [
    {
        name: 'Data Mahasiswa',
        items: [
            { text: 'Nama Mahasiswa', value: '{{Nama Mahasiswa}}' },
            { text: 'NIM', value: '{{NIM}}' },
            { text: 'Program Studi', value: '{{Program Studi}}' },
            { text: 'Semester', value: '{{Semester}}' },
        ]
    },
    {
        name: 'Data Surat',
        items: [
            { text: 'Nomor Surat', value: '{{Nomor Surat}}' },
            { text: 'Tanggal', value: '{{Tanggal}}' },
            { text: 'Tahun Akademik', value: '{{Tahun Akademik}}' },
        ]
    },
    {
        name: 'Data Pejabat',
        items: [
            { text: 'Nama Kaprodi', value: '{{Nama Kaprodi}}' },
            { text: 'NIP Kaprodi', value: '{{NIP Kaprodi}}' },
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

    if (typeof tinymce !== 'undefined') {
        // Destroy previous instance if re-initializing
        if (tinymce.get(editorElement.id)) {
            tinymce.get(editorElement.id).destroy();
        }

        tinymce.init({
            selector: editorSelector,
            height: 680,
            menubar: 'file edit view insert format table help',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table placeholder_menu | removeformat code preview',
            font_size_formats: '8pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt 36pt',
            font_family_formats: 'Times New Roman=Times New Roman,Times,serif; Arial=arial,helvetica,sans-serif; Montserrat=montserrat,sans-serif; Inter=inter,sans-serif',
            content_style: `
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
                
                html {
                    background-color: #F8FAFC;
                    padding: 24px 0;
                }

                body {
                    background-color: #FFFFFF;
                    width: 595pt;
                    max-width: 95%;
                    min-height: 720pt;
                    margin: 0 auto;
                    padding: 48pt 54pt;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                    border: 1px solid #E2E8F0;
                    box-sizing: border-box;
                    font-family: "Times New Roman", Times, serif;
                    font-size: 12pt;
                    line-height: 1.35;
                    color: #000000;
                }

                p {
                    margin-top: 0;
                    margin-bottom: 12pt;
                    line-height: 1.35;
                }

                table {
                    border-collapse: collapse;
                    margin-top: 6pt;
                    margin-bottom: 12pt;
                    font-size: 12pt;
                    font-family: "Times New Roman", Times, serif;
                }

                .placeholder-pill {
                    display: inline-block;
                    padding: 2px 8px;
                    border-radius: 12px;
                    background-color: #F3E8FF;
                    color: #431E6D;
                    font-size: 10pt;
                    font-weight: 600;
                    font-family: 'Inter', sans-serif;
                    margin: 0 2px;
                    border: 1px solid #E9D5FF;
                    user-select: all;
                    line-height: 1.2;
                }
            `,
            branding: false,
            promotion: false,
            setup: function (editor) {
                // Register Custom Variable Toolbar Menu Button
                editor.ui.registry.addMenuButton('placeholder_menu', {
                    text: '+ Variable Surat',
                    icon: 'plus',
                    fetch: function (callback) {
                        const items = placeholderGroups.map(group => ({
                            type: 'nestedmenuitem',
                            text: group.name,
                            getSubmenuItems: function () {
                                return group.items.map(item => ({
                                    type: 'menuitem',
                                    text: item.text,
                                    onAction: function () {
                                        editor.insertContent(`<span class="placeholder-pill" contenteditable="false">${item.value}</span>&nbsp;`);
                                        editor.focus();
                                    }
                                }));
                            }
                        }));
                        callback(items);
                    }
                });

                // Auto-detect typed placeholders on keyup, paste, and init
                editor.on('keyup', function (e) {
                    if (e.key === '}' || e.key === ' ' || e.key === 'Enter') {
                        processPlaceholderFormatting(editor);
                    }
                });

                editor.on('init SetContent Change', function () {
                    processPlaceholderFormatting(editor);
                });
            }
        });
    }

    // Attach listener for Quick Helper Dropdown Select
    const placeholderSelect = document.querySelector(selectSelector);
    if (placeholderSelect && !placeholderSelect.dataset.listenerAttached) {
        placeholderSelect.dataset.listenerAttached = 'true';
        placeholderSelect.addEventListener('change', function () {
            const val = this.value;
            if (!val || val.startsWith('+')) return;

            const pillHtml = `<span class="placeholder-pill" contenteditable="false">${val}</span>&nbsp;`;
            if (window.tinymce && tinymce.get(editorElement.id)) {
                const ed = tinymce.get(editorElement.id);
                ed.insertContent(pillHtml);
                ed.focus();
                processPlaceholderFormatting(ed);
            }
            this.selectedIndex = 0;
        });
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initLetterEditor();
});
