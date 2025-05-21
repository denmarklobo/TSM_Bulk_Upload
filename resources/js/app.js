import './bootstrap';

const modal = document.getElementById('addUserModal');
const addUserBtn = document.querySelector('.add-user');
const closeBtn = document.querySelector('.close-btn');

addUserBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
});

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', () => {
// Add event listeners to all ellipsis buttons
document.querySelectorAll('.menu-btn').forEach(button => {
button.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent event from bubbling up

    // Close all other dropdowns
    document.querySelectorAll('.dropdown-container').forEach(container => {
        if (container !== button.parentElement) {
            container.classList.remove('active');
        }
    });

    // Toggle the current dropdown
    const dropdown = button.parentElement;
    dropdown.classList.toggle('active');
});
});

// Close all dropdowns when clicking outside
window.addEventListener('click', () => {
document.querySelectorAll('.dropdown-container').forEach(container => {
    container.classList.remove('active');
});
});
});

document.addEventListener('DOMContentLoaded', () => {
const statusFilter = document.getElementById('status-filter');
const sortFilter = document.getElementById('sort-filter');
const tableBody = document.querySelector('.table tbody');

// Filter rows based on status
statusFilter.addEventListener('change', () => {
const selectedStatus = statusFilter.value;
const rows = tableBody.querySelectorAll('tr');

rows.forEach(row => {
    const statusCell = row.querySelector('td:nth-child(4)');
    const status = statusCell.textContent.trim().toLowerCase();

    if (selectedStatus === 'all' || status === selectedStatus) {
        row.style.display = ''; // Show row
    } else {
        row.style.display = 'none'; // Hide row
    }
});
});

// Sort rows based on ascending or descending order
sortFilter.addEventListener('change', () => {
const rows = Array.from(tableBody.querySelectorAll('tr'));
const sortOrder = sortFilter.value;

rows.sort((a, b) => {
    const nameA = a.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
    const nameB = b.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();

    if (sortOrder === 'ascending') {
        return nameA.localeCompare(nameB);
    } else {
        return nameB.localeCompare(nameA);
    }
});

// Append sorted rows back to the table body
rows.forEach(row => tableBody.appendChild(row));
});
});

document.addEventListener('DOMContentLoaded', () => {
const statusFilter = document.getElementById('status-filter');
const sortFilter = document.getElementById('sort-filter');
const tableBody = document.querySelector('.table tbody');
const paginationRange = document.getElementById('pagination-range');
const totalItems = document.getElementById('total-items');
const prevButton = document.querySelector('.pagination-prev');
const nextButton = document.querySelector('.pagination-next');

let currentPage = 1;
const itemsPerPage = 10;

// Function to update the table based on the current page and filters
function updateTable() {
const rows = Array.from(tableBody.querySelectorAll('tr'));
const filteredRows = rows.filter(row => {
    const statusCell = row.querySelector('td:nth-child(4)');
    const status = statusCell.textContent.trim().toLowerCase();
    const selectedStatus = statusFilter.value;

    return selectedStatus === 'all' || status === selectedStatus;
});

// Sort rows based on the selected sort order
const sortOrder = sortFilter.value;
filteredRows.sort((a, b) => {
    const nameA = a.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
    const nameB = b.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();

    if (sortOrder === 'ascending') {
        return nameA.localeCompare(nameB);
    } else {
        return nameB.localeCompare(nameA);
    }
});

// Calculate pagination
const totalFilteredItems = filteredRows.length;
const startIndex = (currentPage - 1) * itemsPerPage;
const endIndex = Math.min(startIndex + itemsPerPage, totalFilteredItems);

// Update pagination info
paginationRange.textContent = `${startIndex + 1} - ${endIndex}`;
totalItems.textContent = totalFilteredItems;

// Show only the rows for the current page
rows.forEach(row => (row.style.display = 'none')); // Hide all rows
filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = '')); // Show rows for the current page

// Enable/disable pagination buttons
prevButton.style.visibility = currentPage > 1 ? 'visible' : 'hidden';
nextButton.style.visibility = endIndex < totalFilteredItems ? 'visible' : 'hidden';
}

// Event listeners for filters
statusFilter.addEventListener('change', () => {
currentPage = 1; // Reset to the first page
updateTable();
});

sortFilter.addEventListener('change', () => {
updateTable();
});

// Event listeners for pagination
prevButton.addEventListener('click', () => {
if (currentPage > 1) {
    currentPage--;
    updateTable();
}
});

nextButton.addEventListener('click', () => {
const rows = Array.from(tableBody.querySelectorAll('tr'));
const filteredRows = rows.filter(row => {
    const statusCell = row.querySelector('td:nth-child(4)');
    const status = statusCell.textContent.trim().toLowerCase();
    const selectedStatus = statusFilter.value;

    return selectedStatus === 'all' || status === selectedStatus;
});

if (currentPage * itemsPerPage < filteredRows.length) {
    currentPage++;
    updateTable();
}
});

// Initial table update
updateTable();
});



















document.addEventListener('DOMContentLoaded', () => {
    const statusFilter = document.getElementById('status-filter');
    const logsFilter = document.getElementById('logs-filter');
    const tableBody = document.querySelector('.activity-table tbody');

    function filterRows() {
        const selectedStatus = statusFilter.value.toLowerCase();
        const selectedLogType = logsFilter.value.toLowerCase();
        const rows = tableBody.querySelectorAll('.log-row');

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status').toLowerCase();
            const rowLogType = row.getAttribute('data-log-type').toLowerCase();

            const matchesStatus = selectedStatus === 'all' || rowStatus === selectedStatus;
            const matchesLogType = selectedLogType === 'all' || rowLogType === selectedLogType;

            if (matchesStatus && matchesLogType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    statusFilter.addEventListener('change', filterRows);
    logsFilter.addEventListener('change', filterRows);

    filterRows();
});