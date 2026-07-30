/**
 * Table Search, Filter, and Sort Utility
 */
export function initTableFilter(config = {}) {
    const {
        searchInputId = 'searchInput',
        tableBodyId = 'tableBody',
        rowSelector = '.data-row',
        noResultsRowId = 'noResultsRow',
        displayCountId = 'displayCount',
        displayLabelId = 'displayLabel',
        resetBtnId = 'resetFilterBtn',
    } = config;

    const searchInput = document.getElementById(searchInputId);
    const tableBody = document.getElementById(tableBodyId);
    const noResultsRow = document.getElementById(noResultsRowId);
    const displayCount = document.getElementById(displayCountId);
    const displayLabel = document.getElementById(displayLabelId);
    const resetBtn = document.getElementById(resetBtnId);

    if (!tableBody) return;

    function filterAndSort() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const rows = Array.from(tableBody.querySelectorAll(rowSelector));
        const visibleRows = [];

        rows.forEach(row => {
            const textContent = row.textContent.toLowerCase();
            const matchesQuery = !query || textContent.includes(query);

            if (matchesQuery) {
                row.style.display = '';
                visibleRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        if (noResultsRow) {
            noResultsRow.style.display = (visibleRows.length === 0 && rows.length > 0) ? '' : 'none';
        }

        if (displayCount) displayCount.textContent = visibleRows.length;
    }

    if (searchInput) searchInput.addEventListener('input', filterAndSort);
    if (resetBtn) {
        resetBtn.addEventListener('click', (e) => {
            if (e) e.preventDefault();
            if (searchInput) searchInput.value = '';
            filterAndSort();
        });
    }

    filterAndSort();
}
