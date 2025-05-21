<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('/asset/Dunbrae_Logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TSM Admin | Dunbrae System</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
</head>

<body>
    <div class="activity-container">
        <div class="activity-search-filtering">
            <input type="text" placeholder="Search..." class="activity-search-bar">
            <select id="status-filter" name="filter" class="activity-filter-select">
                <option value="all">Status</option>
                <option value="Successful">Successful</option>
                <option value="Failed">Failed</option>
            </select>
            <select id="logs-filter" class="activity-filter-select">
                <option value="all">Logs</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
        </div>

        <table class="activity-table">
            <thead>
                <tr>
                    <th>TSM User ID</th>
                    <th>Name</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 50) as $i)
                <tr class="log-row" data-log-type="{{ $i % 2 === 0 ? 'Admin' : 'User' }}" data-status="{{ $i % 3 === 0 ? 'Failed' : 'Successful' }}">
                    <td>TSM{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $i % 2 === 0 ? 'Admin User' : 'Regular User' }} {{ $i }}</td>
                    <td>{{ $i % 2 === 0 ? 'Performed Admin Action' : 'Performed User Action' }}</td>
                    <td class="{{ $i % 3 === 0 ? 'activity-status-suspended' : 'activity-status-active' }}">
                        {{ $i % 3 === 0 ? 'Failed' : 'Successful' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="pagination-info">
            <i class="fa fa-chevron-left pagination-prev"></i>
            Item per Page: 10 | &nbsp; <span id="pagination-range">1 - 10</span> of <span id="total-items">100</span> &nbsp; | &nbsp;
            <i class="fa fa-chevron-right pagination-next"></i>
        </p>
    </div>

    <script>
    </script>
</body>
</html>