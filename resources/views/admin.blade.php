<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('/asset/Dunbrae_Logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TSM Upload | Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accounts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('asset/Dunbrae_Full_logo.png') }}" alt="Dunbrae_Logo" class="header-logo">
            </div>
<div class="user-info">
    <i class="fa fa-user"></i>
    <span class="user-name">Admin</span>
    <i class="fa fa-sign-out-alt logout" id="adminLogoutIcon" style="cursor:pointer;"></i>
</div>
        </div>
        <hr class="divider">

        <!-- Tabs Section -->
        <div class="sub-header">
            <p class="tab active" data-tab="manage-account">
                <i class="fa fa-user"></i> Manage Account
            </p>
            <p class="tab" data-tab="activity-logs">
                <i class="fa fa-list"></i> Activity Logs
            </p>
        </div>

        <!-- Manage Account Section --> 
        <div id="manage-account" class="tab-content active">
            <div class="accounts-container">
                <div class="search-filtering">
                    <input type="text" placeholder="Search..." class="search-bar" id="search-bar">
                    <p class="add-user"><i class="fa fa-plus"></i> Add User</p>
                    <div class="filtering">
                        <select id="status-filter" name="filter" class="filter-select space">
                            <option value="all">All</option>
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>TSM User ID</th>
                            <th>Fullname</th>
                            <th>Email Address</th>
                            <th>Account Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="manage-account-table-body">
                        <!-- Dynamic user rows will be inserted here -->
                    </tbody>
                </table>
                                <p class="pagination-info">
                    <i class="fa fa-chevron-left pagination-prev-manage-account" style="margin-right: 20px"></i>
                    Item per Page: 10 &nbsp; | &nbsp; <span id="manage-account-pagination-range">1 - 20</span> of <span id="manage-account-total-items">50</span> &nbsp; &nbsp;
                    <i class="fa fa-chevron-right pagination-next-manage-account" style="margin-left: 10px"></i>
                </p>
            </div>
        </div>


            </div>
        </div>



        <!-- Activity Logs Section -->
        <div id="activity-logs" class="tab-content">
            <div class="activity-container">
                <div class="activity-search-filtering">
                    <input type="text" placeholder="Search..." class="activity-search-bar">
                        <select id="status-filter" name="filter" class="activity-filter-select">
                            <option value="all">All</option>
                            <option value="successful">Successful</option>
                            <option value="failed">Failed</option>
                        </select>
                </div>
                <table class="activity-table">
                <thead>
                    <tr>
                        <th>TSM User ID</th>
                        <th>Fullname</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>File Name</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                    <tbody id="activity-logs-table-body">
                        <!-- Dynamic content will be injected here via JavaScript -->
                    </tbody>
                </table>
        
                <p class="pagination-info">
                    <i class="fa fa-chevron-left pagination-prev-activity-logs" style="margin-right: 20px"></i>
                    Item per Page: 10 &nbsp; | &nbsp; <span id="activity-logs-pagination-range">1 - 10</span> of <span id="activity-logs-total-items">50</span> &nbsp; &nbsp;
                    <i class="fa fa-chevron-right pagination-next-activity-logs" style="margin-left: 10px"></i>
                </p>
            </div>
        </div>
    </div>


    <!-- Modal for Adding User -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form>
                <label for="tsm_employee_code">TSM User ID</label>
                <input type="text" id="tsm_employee_code" name="tsm_employee_code" required>
    
                <label for="name">name</label>
                <input type="text" id="name" name="name" required>
    
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
    
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
    
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
                <small id="password-error" class="error-message"></small>

                <p type="submit" class="submit-btn">Add User</p>
            </form>
        </div>
    </div>


    <!----------------------------- JS for Navbar -------------------------------->
    <script>
                document.addEventListener('DOMContentLoaded', function () {
    const authToken = localStorage.getItem('role');

    if (!authToken) {
        // Redirect to login page if no token found
        window.location.href = '/login'; // Change as needed
    }
});

        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.sub-header .tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    this.classList.add('active');
                    const targetTab = this.getAttribute('data-tab');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
        const dropdownBtn = document.querySelector('.dropdown-btn');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        // Toggle dropdown menu visibility when the button is clicked
        dropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent event bubbling
            dropdownMenu.classList.toggle('active'); // Toggle the 'active' class
        });

        // Close the dropdown menu when clicking outside
        window.addEventListener('click', () => {
            dropdownMenu.classList.remove('active'); // Remove the 'active' class
        });
    });


     document.getElementById('adminLogoutIcon').addEventListener('click', () => {
    Swal.fire({
      title: 'Are you sure you want to log out?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, log me out',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        localStorage.clear();
        Swal.fire({
          title: 'Logged out!',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          // Redirect to login page (change URL as needed)
          window.location.href = '/login';
        });
      }
    });
  });

    </script>

    <!----------------------------- JS for Manage Account -------------------------------->
    <script>

document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('search-bar');
    const statusFilter = document.getElementById('status-filter');
    const manageAccountTableBody = document.getElementById('manage-account-table-body');
    const manageAccountPaginationRange = document.getElementById('manage-account-pagination-range');
    const manageAccountTotalItems = document.getElementById('manage-account-total-items');
    const itemsPerPage = 20;
    let manageAccountCurrentPage = 1;

    function filterManageAccountRows() {
        const rows = Array.from(manageAccountTableBody.querySelectorAll('tr'));
        const selectedStatus = statusFilter.value.toLowerCase();
        const searchQuery = searchBar.value.trim().toLowerCase();

        // Filter rows based on search query and status
        return rows.filter(row => {
            const tsmUserId = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
            const name = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();
            const status = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();
            const matchesSearch = tsmUserId.includes(searchQuery) || name.includes(searchQuery) || email.includes(searchQuery);
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

            return matchesSearch && matchesStatus;
        });
    }

    function paginateManageAccountTable(filteredRows) {
        const total = filteredRows.length;
        const startIndex = (manageAccountCurrentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, total);

        // Hide all rows and display only the rows for the current page
        Array.from(manageAccountTableBody.querySelectorAll('tr')).forEach(row => (row.style.display = 'none'));
        filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = ''));

        // Update pagination info
        manageAccountPaginationRange.textContent = total === 0 ? '0 - 0' : `${startIndex + 1} - ${endIndex}`;
        manageAccountTotalItems.textContent = total;
    }

    function updateManageAccountTable() {
        const filteredRows = filterManageAccountRows();
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / itemsPerPage));
        if (manageAccountCurrentPage > totalPages) {
            manageAccountCurrentPage = totalPages;
        }
        paginateManageAccountTable(filteredRows);
    }

    // Event listeners for search and filter
    searchBar.addEventListener('input', () => {
        manageAccountCurrentPage = 1;
        updateManageAccountTable();
    });

    statusFilter.addEventListener('change', () => {
        manageAccountCurrentPage = 1;
        updateManageAccountTable();
    });

    // Pagination controls
    document.querySelector('.pagination-prev-manage-account').addEventListener('click', () => {
        if (manageAccountCurrentPage > 1) {
            manageAccountCurrentPage--;
            updateManageAccountTable();
        }
    });

    document.querySelector('.pagination-next-manage-account').addEventListener('click', () => {
        const filteredRows = filterManageAccountRows();
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (manageAccountCurrentPage < totalPages) {
            manageAccountCurrentPage++;
            updateManageAccountTable();
        }
    });

window.updateManageAccountTable = updateManageAccountTable;

    document.querySelector('.pagination-next-manage-account').addEventListener('click', () => {
        const rows = Array.from(manageAccountTableBody.querySelectorAll('tr'));
        const filteredRows = rows.filter(row => {
            const tsmUserId = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
            const name = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();
            const status = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();

            const matchesSearch = tsmUserId.includes(searchBar.value.trim().toLowerCase()) ||
                                  name.includes(searchBar.value.trim().toLowerCase()) ||
                                  email.includes(searchBar.value.trim().toLowerCase());
            const matchesStatus = statusFilter.value === 'all' || status === statusFilter.value;

            return matchesSearch && matchesStatus;
        });

        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (manageAccountCurrentPage < totalPages) {
            manageAccountCurrentPage++;
            filterAndSortManageAccountRows();
        }
    });

    // Initial load
    filterAndSortManageAccountRows();
});
        // Modal for Adding User
        document.addEventListener('DOMContentLoaded', () => {
    // Modal for Adding User
    const addUserBtn = document.querySelector('.add-user');
    const modal = document.getElementById('addUserModal');
    const closeBtn = document.querySelector('.close-btn');
    const manageAccountTableBody = document.querySelector('#manage-account-table-body');



    addUserBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Tabs Logic
    const tabs = document.querySelectorAll('.sub-header .tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            this.classList.add('active');
            const targetTab = this.getAttribute('data-tab');
            document.getElementById(targetTab).classList.add('active');
        });
    });

    // Dropdown Logic (if any dropdowns exist)
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        window.addEventListener('click', () => {
            dropdownMenu.classList.remove('active');
        });
    }

    // Fetch Users and Populate Manage Account Table
    const API_URL = 'http://127.0.0.1:8000/api/users';
const SUSPEND_URL = 'http://127.0.0.1:8000/api/user'; // base for /{id}/suspend or /{id}/enable
const tableBody = document.getElementById('manage-account-table-body');

function loadUsers() {
    fetch(API_URL)
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = '';

            data.data.forEach(user => {
                const tr = document.createElement('tr');

                const statusClass = user.status === 1 ? 'status-active' : 'status-suspended';
                const statusText = user.status === 1 ? 'Active' : 'Suspended';
                const statusColor = user.status === 1 ? 'green' : 'orange';

                tr.innerHTML = `
                    <td>${user.tsm_employee_code}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td class="${statusClass}">
                        <span class="circle ${statusColor}"></span>
                        ${statusText}
                    </td>
                    <td>
                        <div class="dropdown-container">
                            <button class="action-btn menu-btn">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item toggle-status-btn" data-user-id="${user.id}" data-action="${user.status === 1 ? 'suspend' : 'enable'}">
                                    <span class="circle ${user.status === 1 ? 'orange' : 'green'}"></span>
                                    ${user.status === 1 ? 'Suspend' : 'Activate'}
                                </button>
                            </div>
                        </div>
                    </td>
                `;

                tableBody.appendChild(tr);
            });

            initDropdownMenus();
            initToggleStatusButtons();

            if (typeof filterAndSortManageAccountRows === 'function') {
                filterAndSortManageAccountRows();
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

function initDropdownMenus() {
    const menuButtons = document.querySelectorAll('.menu-btn');

    menuButtons.forEach(button => {
        const dropdownMenu = button.nextElementSibling;

        button.addEventListener('click', (e) => {
            e.stopPropagation();

            document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('active');
                }
            });

            dropdownMenu.classList.toggle('active');
        });
    });

    window.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    });
}

function initToggleStatusButtons() {
    const toggleButtons = document.querySelectorAll('.toggle-status-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');
            const action = button.getAttribute('data-action');

            fetch(`${SUSPEND_URL}/${userId}/${action}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': 'Bearer your-token' if needed
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update status');
                }
                return response.json();
            })
            .then(data => {
                alert(`User successfully ${action}ed`);
                loadUsers(); // refresh the table
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update user status');
            });
        });
    });
}

// Initial load
loadUsers();

    const itemsPerPage = 20;
    let manageAccountCurrentPage = 1;

    function paginateManageAccountTable(tableBody, paginationRange, totalItems, currentPage, filteredRows) {
        const total = filteredRows.length;

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, total);

        Array.from(tableBody.querySelectorAll('tr')).forEach(row => (row.style.display = 'none'));
        filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = ''));

        paginationRange.textContent = `${startIndex + 1} - ${endIndex}`;
        totalItems.textContent = total;
    }

    function filterAndSortManageAccountRows() {
        const rows = Array.from(manageAccountTableBody.querySelectorAll('tr'));
        const selectedStatus = statusFilter.value;
        const sortOrder = sortFilter.value;
        const searchQuery = searchBar.value.trim().toLowerCase();

        let filteredRows = rows.filter(row => {
            const tsmUserId = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
            const name = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();
            const statusCell = row.querySelector('td:nth-child(4)');
            const status = statusCell.textContent.trim().toLowerCase();

            const matchesSearch = tsmUserId.includes(searchQuery) || name.includes(searchQuery) || email.includes(searchQuery);
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

            return matchesSearch && matchesStatus;
        });

        filteredRows.sort((a, b) => {
            const nameA = a.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            const nameB = b.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            if (sortOrder === 'ascending') {
                return nameA.localeCompare(nameB);
            } else {
                return nameB.localeCompare(nameA);
            }
        });

        paginateManageAccountTable(manageAccountTableBody, manageAccountPaginationRange, manageAccountTotalItems, manageAccountCurrentPage, filteredRows);
    }

    statusFilter.addEventListener('change', () => {
        manageAccountCurrentPage = 1;
        filterAndSortManageAccountRows();
    });

    sortFilter.addEventListener('change', () => {
        manageAccountCurrentPage = 1;
        filterAndSortManageAccountRows();
    });

    searchBar.addEventListener('input', () => {
        manageAccountCurrentPage = 1;
        filterAndSortManageAccountRows();
    });

    filterAndSortManageAccountRows();

    document.querySelector('.pagination-prev-manage-account').addEventListener('click', () => {
        if (manageAccountCurrentPage > 1) {
            manageAccountCurrentPage--;
            filterAndSortManageAccountRows();
        }
    });

    document.querySelector('.pagination-next-manage-account').addEventListener('click', () => {
        const rows = Array.from(manageAccountTableBody.querySelectorAll('tr'));
        const filteredRows = rows.filter(row => {
            const tsmUserId = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase();
            const name = row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();
            const statusCell = row.querySelector('td:nth-child(4)');
            const status = statusCell.textContent.trim().toLowerCase();

            const matchesSearch = tsmUserId.includes(searchBar.value.trim().toLowerCase()) ||
                                  name.includes(searchBar.value.trim().toLowerCase()) ||
                                  email.includes(searchBar.value.trim().toLowerCase());
            const matchesStatus = statusFilter.value === 'all' || status === statusFilter.value;

            return matchesSearch && matchesStatus;
        });

        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (manageAccountCurrentPage < totalPages) {
            manageAccountCurrentPage++;
            filterAndSortManageAccountRows();
        }
    });
});
        

        // Remove - Suspend - Activate - Dropdown Menu
        document.addEventListener('DOMContentLoaded', () => {
    const menuButtons = document.querySelectorAll('.menu-btn');

    menuButtons.forEach(button => {
        const dropdownMenu = button.nextElementSibling;

        button.addEventListener('click', (e) => {
            e.stopPropagation();

            document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('active');
                }
            });

            dropdownMenu.classList.toggle('active');
        });

        // Add event listeners to suspend and enable options
        dropdownMenu.querySelectorAll('.suspend-user, .enable-user').forEach(option => {
            option.addEventListener('click', (e) => {
                e.stopPropagation();
                const userId = option.getAttribute('data-user-id');
                const action = option.classList.contains('suspend-user') ? 'suspend' : 'enable';
                
                fetch(`http://127.0.0.1:8000/api/user/${userId}/${action}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        // Add token if needed
                        // 'Authorization': 'Bearer YOUR_TOKEN'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert(`User ${action}d successfully`);
                    // Optionally reload or update UI
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update user status');
                });
            });
        });
    });

    window.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    });
});
    </script>

    <!----------------------------- JS for Activity -------------------------------->
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const activityLogsTableBody = document.getElementById('activity-logs-table-body');
    const activityLogsPaginationRange = document.getElementById('activity-logs-pagination-range');
    const activityLogsTotalItems = document.getElementById('activity-logs-total-items');
    const activityStatusFilter = document.getElementById('status-filter');
    const activitySearchBar = document.querySelector('.activity-search-bar'); // Fixed

    const itemsPerPage = 20;
    let activityLogsCurrentPage = 1;
    let activityLogsData = [];

    function renderActivityRows(data) {
        activityLogsTableBody.innerHTML = '';
        data.forEach(log => {
            const row = document.createElement('tr');

            const statusClass = (log.status || '').toLowerCase() === 'failed' 
                ? 'activity-status-suspended' 
                : 'activity-status-active';

            const dateTime = new Date(log.created_at).toLocaleString();

            row.innerHTML = `
                <td>${log.user || ''}</td>
                <td>${log.name || ''}</td>
                <td>${log.action || ''}</td>
                <td class="${statusClass}">${log.status || ''}</td>
                <td>${log.file_name || ''}</td>
                <td>${dateTime}</td>
            `;

            activityLogsTableBody.appendChild(row);
        });
    }

    function paginateActivityLogsTable() {
        const filteredRows = filterActivityLogsData();
        const total = filteredRows.length;
        const startIndex = (activityLogsCurrentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, total);

        renderActivityRows(filteredRows.slice(startIndex, endIndex));

        activityLogsPaginationRange.textContent = `${startIndex + 1} - ${endIndex}`;
        activityLogsTotalItems.textContent = total;
    }

function filterActivityLogsData() {
    const selectedStatus = activityStatusFilter.value.toLowerCase(); // Get the selected status
    const searchQuery = activitySearchBar.value.trim().toLowerCase(); // Get the search query

    return activityLogsData.filter(log => {
        const status = (log.status || '').toLowerCase(); // Convert log status to lowercase
        const action = (log.action || '').toLowerCase(); // Convert log action to lowercase
        const user = (log.user || '').toLowerCase(); // Convert log user to lowercase
        const name = (log.name || '').toLowerCase(); // Convert log name to lowercase

        // Check if the log matches the search query
        const matchesSearch = user.includes(searchQuery) || name.includes(searchQuery) || action.includes(searchQuery);

        // Check if the log matches the selected status
        const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

        return matchesSearch && matchesStatus; // Return logs that match both conditions
    });
}

    async function fetchActivityLogs() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/activities'); // Updated endpoint
            if (!response.ok) {
                throw new Error('Failed to fetch activity logs');
            }

            const data = await response.json();
            activityLogsData = data.data || data || []; // Handles both array and paginated structures
            paginateActivityLogsTable();
        } catch (error) {
            console.error('Error fetching activity logs:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch activity logs. Please try again later.'
            });
        }
    }

    // Event Listeners
    activityStatusFilter.addEventListener('change', () => {
        activityLogsCurrentPage = 1;
        paginateActivityLogsTable();
    });

    activitySearchBar.addEventListener('input', () => {
        activityLogsCurrentPage = 1;
        paginateActivityLogsTable();
    });

    document.querySelector('.pagination-prev-activity-logs').addEventListener('click', () => {
        if (activityLogsCurrentPage > 1) {
            activityLogsCurrentPage--;
            paginateActivityLogsTable();
        }
    });

    document.querySelector('.pagination-next-activity-logs').addEventListener('click', () => {
        const totalPages = Math.ceil(filterActivityLogsData().length / itemsPerPage);
        if (activityLogsCurrentPage < totalPages) {
            activityLogsCurrentPage++;
            paginateActivityLogsTable();
        }
    });

    // Initial Fetch
    fetchActivityLogs();
});



    document.querySelector('.pagination-next-activity-logs').addEventListener('click', () => {
        const rows = Array.from(activityLogsTableBody.querySelectorAll('tr'));
        const filteredRows = rows.filter(row => {
            const statusCell = row.querySelector('td:nth-child(4)');
            const logTypeCell = row.querySelector('td:nth-child(3)');
            const userIdCell = row.querySelector('td:nth-child(1)');
            const nameCell = row.querySelector('td:nth-child(2)');
            const emailCell = row.querySelector('td:nth-child(3)');
            const status = statusCell.textContent.trim().toLowerCase();
            const logType = logTypeCell.textContent.trim().toLowerCase();
            const userId = userIdCell.textContent.trim().toLowerCase();
            const name = nameCell.textContent.trim().toLowerCase();
            const email = emailCell.textContent.trim().toLowerCase();

            const matchesSearch = userId.includes(activitySearchBar.value.trim().toLowerCase()) || name.includes(activitySearchBar.value.trim().toLowerCase()) || email.includes(activitySearchBar.value.trim().toLowerCase());
            const matchesStatus = activityStatusFilter.value === 'all' || status === activityStatusFilter.value;
            const matchesLogType = activityLogsFilter.value === 'all' || logType.includes(activityLogsFilter.value);

            return matchesSearch && matchesStatus && matchesLogType;
        });

        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (activityLogsCurrentPage < totalPages) {
            activityLogsCurrentPage++;
            paginateActivityLogsTable();
        }
    });




    document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.querySelector('.submit-btn');
    const modal = document.getElementById('addUserModal');
    const form = modal.querySelector('form');
    const passwordError = document.getElementById('password-error');

    submitBtn.addEventListener('click', () => {
        const tsmCode = form.querySelector('#tsm_employee_code').value.trim();
        const fullname = form.querySelector('#name').value.trim();
        const email = form.querySelector('#email').value.trim();
        const password = form.querySelector('#password').value.trim();
        const confirmPassword = form.querySelector('#password_confirm').value.trim();

        // Reset error
        passwordError.style.display = 'none';
        passwordError.textContent = '';

        // Validation
        if (!tsmCode || !fullname || !email || !password || !confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Fields',
                text: 'Please fill in all the fields.'
            });
            return;
        }

        if (password !== confirmPassword) {
            passwordError.textContent = 'Passwords do not match';
            passwordError.style.display = 'block';
            form.querySelector('#password_confirm').classList.add('error');
            return;
        } else {
            form.querySelector('#password_confirm').classList.remove('error');
        }

        // Confirmation Prompt
        Swal.fire({
            title: 'Add New User?',
            text: 'Are you sure you want to add this user to the system?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add user',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send data to backend
                fetch('http://127.0.0.1:8000/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        tsm_employee_code: tsmCode,
                        name: fullname,
                        email: email,
                        password: password,
                        password_confirmation: confirmPassword
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to register user.');
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'User Added',
                        text: 'The new user has been successfully added.'
                    }).then(() => {
                        form.reset();
                        modal.style.display = 'none';
                          // Directly append the user to the table
        const user = data.data; // Adjust if your API wraps it differently
        const tr = document.createElement('tr');

        const statusClass = user.status === 1 ? 'status-active' : 'status-suspended';
        const statusText = user.status === 1 ? 'Active' : 'Suspended';
        const statusColor = user.status === 1 ? 'green' : 'orange';

        tr.innerHTML = `
            <td>${user.tsm_employee_code}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td class="${statusClass}">
                <span class="circle ${statusColor}"></span>
                ${statusText}
            </td>
            <td>    
                <div class="dropdown-container">
                    <button class="action-btn menu-btn">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item toggle-status-btn" data-user-id="${user.id}" data-action="${user.status === 1 ? 'suspend' : 'enable'}">
                            <span class="circle ${user.status === 1 ? 'orange' : 'green'}"></span>
                            ${user.status === 1 ? 'Suspend' : 'Activate'}
                        </button>
                    </div>
                </div>
            </td>
        `;

        tableBody.appendChild(tr);
        initDropdownMenus();       
        initToggleStatusButtons(); 
    });
})
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: error.message
                    });
                });
            }
        });
    });
});
    </script>
</body>
</html>