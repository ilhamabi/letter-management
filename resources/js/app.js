import Alpine from 'alpinejs';
import { toggleModal, openModal, closeModal } from './modules/modal';
import { showSuccessToast } from './modules/toast';
import { initTableFilter } from './modules/filter';
import {
    handleRoleToggle,
    updateConfirmButtonState,
    updateApproveButtonState,
    confirmRejection,
    confirmApproval
} from './features/approval-detail';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Expose Global Helper Functions to Window
window.toggleModal = toggleModal;
window.openModal = openModal;
window.closeModal = closeModal;
window.showSuccessToast = showSuccessToast;
window.initTableFilter = initTableFilter;

// Expose Approval Feature Methods
window.handleRoleToggle = handleRoleToggle;
window.updateConfirmButtonState = updateConfirmButtonState;
window.updateApproveButtonState = updateApproveButtonState;
window.confirmRejection = confirmRejection;
window.confirmApproval = confirmApproval;
