/**
 * Modal Management Utility
 */
export function toggleModal(id, show) {
    const modal = document.getElementById(id);
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        
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
        document.querySelectorAll('[id$="-modal"]:not(.hidden)').forEach(modal => {
            modal.classList.add('hidden');
        });
    }
}

// Global listener to close active modal on Escape key press
if (typeof window !== 'undefined') {
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === 'Esc') {
            closeModal();
        }
    });
}
