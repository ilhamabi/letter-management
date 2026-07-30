import { toggleModal } from '../modules/modal';
import { showSuccessToast } from '../modules/toast';

export function handleRoleToggle(roleId) {
    const group = document.getElementById(`group-${roleId}`);
    const fields = document.getElementById(`fields-${roleId}`);
    if (!group || !fields) return;
    const checkbox = group.querySelector('.role-checkbox');

    if (checkbox && checkbox.checked) {
        group.classList.add('border-error');
        group.classList.remove('border-gray-200');
        fields.classList.remove('hidden');
    } else {
        group.classList.remove('border-error');
        group.classList.add('border-gray-200');
        fields.classList.add('hidden');
    }
    updateConfirmButtonState();
}

export function updateConfirmButtonState() {
    const checkboxes = document.querySelectorAll('.role-checkbox');
    const confirmBtn = document.getElementById('confirm-reject-btn');
    if (!confirmBtn) return;
    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
    confirmBtn.disabled = !anyChecked;
}

export function updateApproveButtonState() {
    const checkboxes = document.querySelectorAll('.approve-role-checkbox');
    const confirmBtn = document.getElementById('confirm-approve-btn');
    if (!confirmBtn) return;
    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
    confirmBtn.disabled = !anyChecked;
}

export function confirmRejection() {
    toggleModal('reject-modal', false);
    showSuccessToast('Dokumen ditolak');
}

export function confirmApproval() {
    toggleModal('approve-modal', false);
    showSuccessToast('Dokumen berhasil disetujui!');
}
