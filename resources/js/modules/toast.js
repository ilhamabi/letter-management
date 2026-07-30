/**
 * Toast Notification Utility
 */
export function showSuccessToast(message) {
    const toast = document.getElementById('success-toast');
    if (!toast) return;
    
    if (message) {
        const fontBoldEl = toast.querySelector('.font-bold');
        if (fontBoldEl) fontBoldEl.textContent = message;
    }

    toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 3000);
}
