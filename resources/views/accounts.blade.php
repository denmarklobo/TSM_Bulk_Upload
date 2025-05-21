<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('/asset/Dunbrae_Logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TSM Upload | Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/accounts.css') }}">
</head>

<body>
    <div class="accounts-container">
        <div class="search-filtering">
            <input type="text" placeholder="Search..." class="search-bar">
            <p class="add-user"><i class="fa fa-plus"></i> Add User</p>
            <div class="filtering">
                <select id="status-filter" name="filter" class="filter-select space">
                    <option value="all">Status</option>
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                </select>
            
                <select id="sort-filter" class="filter-select">
                    <option value="ascending">Ascending</option>
                    <option value="descending">Descending</option>
                </select>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>TSM User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 50) as $i)
                <tr>
                    <td>TSM{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $i % 2 === 0 ? 'John Doe' : 'Jane Smith' }} {{ $i }}</td>
                    <td>{{ $i % 2 === 0 ? 'johndoe' : 'janesmith' }}{{ $i }}@example.com</td>
                    <td class="{{ $i % 3 === 0 ? 'status-suspended' : 'status-active' }}">
                        {{ $i % 3 === 0 ? 'Suspended' : 'Active' }}
                    </td>
                    <td>
                        <div class="dropdown-container">
                            <button class="action-btn menu-btn">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item">
                                    <span class="circle red"></span> Remove
                                </button>
                                <button class="dropdown-item">
                                    <span class="circle orange"></span> Suspend
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <p class="pagination-info">
            <i class="fa fa-chevron-left pagination-prev"></i>
            Item per Page: 10 &nbsp; | &nbsp; <span id="pagination-range">1 - 10</span> of <span id="total-items">100</span> &nbsp; | &nbsp;
            <i class="fa fa-chevron-right pagination-next"></i>
        </p>     
        <div class="modal" id="addUserModal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <form>
                    <label for="tsm-code">TSM User ID</label>
                    <input type="text" id="tsm-code" name="tsm-code" required>
        
                    <label for="fullname">Fullname</label>
                    <input type="text" id="fullname" name="fullname"required>
        
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
        
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
        
                    <p type="submit" class="submit-btn">Add User</p>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    </script>
</body>
</html>
