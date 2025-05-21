<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('/asset/Dunbrae_Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/upload.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>TSM | Dunbrae System</title>
    <style>
        #progressText {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/upload" class="navbar-logo">
                <img src="{{ asset('/asset/Dunbrae_Logo_White.png') }}" alt="Logo" class="navbar-logo-img">
            </a>
                <div class="navbar-right">
                    <a href="javascript:void(0);" class="logout-btn" id="logoutBtn">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </div>

        </div>
    </nav>

    <div class="upload-container">
        <form id="tsmForm" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="right-panel">
                <div class="file-upload-container">
                    <input type="file" name="files[]" id="fileInput" class="file-input" accept=".csv">
                    <input type="hidden" name="tsm_employee_code" id="tsm_employee_code">
                    <input type="hidden" name="email" id="email">
                    <input type="hidden" name="name" id="name">
                    <div class="file-upload-text">
                        <img src="{{ asset('/asset/Upload_Icon.png') }}" alt="Logo" class="Upload-Icon-img">
                        <p>Drag and Drop to File Upload</p>
                        <div class="line-separator">
                            <div class="line"></div>
                            <p>or</p>
                            <div class="line"></div>
                        </div>
                        <label for="fileInput" class="browse-btn">Browse File</label>
                    </div>
                </div>
                <div class="notes">
                    <p class="file-upload-note">Use this form to upload file in .csv format</p>
                    <p class="file-upload-note">Note: One (1) .csv file at a time</p>
                </div>
            </div>

            <div class="left-panel">
                <div class="upload-status" style="display: none;"> <!-- Initially hidden -->
                    <div class="upload-status-content">
                        <div class="icon">
                            <button type="button" class="remove-file-btn"><i class="fa fa-times"></i></button>
                            <img src="{{ asset('/asset/Csv_Icon.png') }}" alt="Logo" class="Csv_Icon-img">
                        </div>
                        <div>
                            <div class="file-name-container">
                                <span class="file-name-text"></span>
                            </div>
                            <div>
                                <img src="{{ asset('/asset/Completed_Icon.png') }}" alt="Completed" class="Completed-Icon-img" id="completedIcon" style="display: none;">
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-text" id="progressText">0%</div> <!-- Percent text -->
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn" id="submitBtn">Submit</button>
            </div>
        </form>
    </div>

    <script>
document.getElementById('tsmForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const tsmCode = localStorage.getItem('tsm_employee_code');
    const email = localStorage.getItem('email');
    const name = localStorage.getItem('name');
    const token = localStorage.getItem('auth_token');name

    if (!tsmCode) {
        Swal.fire('Error', 'TSM Employee Code is missing. Please log in again.', 'error');
        return;
    }

    if (!token) {
        Swal.fire('Error', 'Token not found. Please log in again.', 'error');
        return;
    }

    document.getElementById('tsm_employee_code').value = tsmCode;
    document.getElementById('email').value = email;
    document.getElementById('name').value = name;
    formData.append('tsm_employee_code', tsmCode);
    formData.append('email', email);
    formData.append('name', name);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://127.0.0.1:8000/submit-tsm-notes', true);
    xhr.setRequestHeader('Authorization', `Bearer ${token}`);

    // Show the progress text when the Submit button is clicked
    document.getElementById('progressText').style.display = 'block';

    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            const percent = Math.round((event.loaded / event.total) * 100);
            document.getElementById('progressText').textContent = percent + '%'; // Update percentage text
        }
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            if (xhr.status === 200) {
                Swal.fire({
                    title: 'Upload Successful',
                    text: response.success || 'Upload completed.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset display after success
                    resetUploadStatus();
                });
            } else {
                Swal.fire('Upload Failed', response.message || 'Something went wrong.', 'error');
            }
        }
    };

    // Show the upload status once the submission begins
    document.querySelector('.upload-status').style.display = 'block';

    xhr.send(formData);
});

        // File upload handling
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const fileName = file?.name || '';
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (file && fileExtension !== 'csv') {
                Swal.fire({
                    title: 'Invalid File Type',
                    text: "Only .csv files are allowed.",
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                document.getElementById('fileInput').value = '';
                return;
            }

            const fileNameDisplay = document.createElement('div');
            fileNameDisplay.classList.add('file-name-display');

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button'; // Add this line
            removeBtn.classList.add('remove-file-btn');
            removeBtn.innerHTML = '<i class="fa fa-times"></i>';


            const fileNameText = document.createElement('span');
            fileNameText.classList.add('file-name-text');
            fileNameText.textContent = fileName;

            removeBtn.addEventListener('click', function () {
                fileNameDisplay.remove();
                document.getElementById('fileInput').value = '';
                resetUploadStatus();
            });

            fileNameDisplay.appendChild(removeBtn);
            fileNameDisplay.appendChild(fileNameText);

            const fileNameContainer = document.querySelector('.file-name-container');
            fileNameContainer.innerHTML = '';
            fileNameContainer.appendChild(fileNameDisplay);

            document.querySelector('.upload-status').style.display = 'block';
        });

        document.querySelectorAll('.remove-file-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                resetUploadStatus();
            });
        });

        // Reset the upload status
        function resetUploadStatus() {
            document.querySelector('.file-name-container').innerHTML = '';
            document.getElementById('fileInput').value = '';
            document.getElementById('progressText').textContent = '0%'; // Reset percentage text
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('completedIcon').style.display = 'none';
            document.querySelector('.upload-status').style.display = 'none'; // Hide the status
        }

        document.addEventListener('DOMContentLoaded', function () {
    const authToken = localStorage.getItem('auth_token');

    if (!authToken) {
        // Redirect to login page if no token found
        window.location.href = '/login'; // Change as needed
    }
});

        // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('http://127.0.0.1:8000/api/userlogout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Logout failed');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message);

                const keysToRemove = [
                    'auth_token',
                    'email',
                    'loglevel',
                    'name',
                    'role',
                    'tsm_employee_code'
                ];

                keysToRemove.forEach(key => localStorage.removeItem(key));

                window.location.href = '/login'; // Change if needed
            })
            .catch(error => {
                console.error('Error during logout:', error);
                Swal.fire('Error', 'Failed to logout. Please try again.', 'error');
            });
        }
    });
});

    </script>
</body>
</html>
