/**
 * Modal Management Utility
 */
export function toggleModal(id, show) {
    const modal = document.getElementById(id);
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        if (id === 'reject-modal') {
            const checkboxes = modal.querySelectorAll('.role-checkbox');
            checkboxes.forEach(cb => {
                const onChangeAttr = cb.getAttribute('onchange');
                if (onChangeAttr) {
                    const match = onChangeAttr.match(/'([^']+)'/);
                    if (match && window.handleRoleToggle) {
                        window.handleRoleToggle(match[1]);
                    }
                }
            });
        }

        if (window.updateConfirmButtonState) window.updateConfirmButtonState();
        if (window.updateApproveButtonState) window.updateApproveButtonState();
    } else {
        modal.classList.add('hidden');
        // Only remove overflow-hidden if no other modals are visible
        const visibleModals = document.querySelectorAll('[id*="modal"]:not(.hidden)');
        if (visibleModals.length === 0) {
            document.body.classList.remove('overflow-hidden');
        }
    }
}

export function openModal(id) {
    toggleModal(id, true);
}

export function closeModal(id) {
    if (id) {
        toggleModal(id, false);
    } else {
        // Close any active visible modal dialogs
        document.querySelectorAll('[id*="modal"]:not(.hidden)').forEach(modal => {
            modal.classList.add('hidden');
        });
    }
}

// Global listener to close active modal on Escape key press or link navigation
if (typeof window !== 'undefined') {
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === 'Esc') {
            closeModal();
        }
    });

    document.addEventListener('click', (e) => {
        const activeModals = document.querySelectorAll('[id*="modal"]:not(.hidden)');
        if (activeModals.length > 0) {
            const link = e.target.closest('a[href]');
            if (link && link.getAttribute('href') && !link.getAttribute('href').startsWith('#') && !link.getAttribute('href').startsWith('javascript:')) {
                closeModal();
            }
        }
    });
}
