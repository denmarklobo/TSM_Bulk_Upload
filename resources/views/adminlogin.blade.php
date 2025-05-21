<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('/asset/Dunbrae_Logo.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>TSM Admin | Dunbrae System</title>
</head>

<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="floating-shapes"></div>
            <img src="{{ asset('/asset/Login_Vector.png') }}" alt="Login Art" class="login-image">
        </div>
        <div class="right-panel">
            <div class="login-form">
                <img src="{{ asset('/asset/Dunbrae_Text_Logo.png') }}" alt="Login Art" class="Dunbrae_Text_logo">
                
                <form method="POST" id="login-form">
                    @csrf
                    <div class="input-group">
                        <label for="email" class="input-label">Email</label>
                        <i class="fa fa-user"></i>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password" class="input-label">Password</label>
                        <i class="fa fa-lock"></i>
                        <input type="password" name="password" id="password" required>
                    </div>
                
                    <div class="remember-me-row">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="remember-label">Remember Me</label>
                    </div>
                
                    <button type="submit" class="login-btn">Login</button>
                </form>
                <!-- WOW ERROR MESSAGE -->
                <div id="error-message" style="display:none; color: red; text-align: center; margin-top: 20px"></div>

                <div class="line-separator">
                    <div class="line"></div>
                    <img src="{{ asset('/asset/Dunbrae_Logo.png') }}" alt="Separator Logo" class="separator-logo">
                    <div class="line"></div>
                </div>  
            </div>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.input-group input');
        
        inputs.forEach(input => {
            const icon = input.previousElementSibling;
            input.addEventListener('input', function () {
                if (input.value) {
                    icon.classList.add('input-icon-hidden');
                } else {
                    icon.classList.remove('input-icon-hidden'); 
                }
            });
        });
    
        window.addEventListener('DOMContentLoaded', () => {
            const savedEmail = localStorage.getItem('remembered_email');
            const rememberMeChecked = localStorage.getItem('remember_me') === 'true';
    
            if (savedEmail && rememberMeChecked) {
                document.getElementById('email').value = savedEmail;
                document.getElementById('remember').checked = true;
            }
        });

        const container = document.querySelector('.floating-shapes');
        const shapeTypes = ['circle', 'square', 'triangle', 'star'];

        for (let i = 0; i < 60; i++) {
            const shape = document.createElement('span');
            const shapeType = shapeTypes[Math.floor(Math.random() * shapeTypes.length)];

            shape.classList.add(`shape-${shapeType}`);

            const size = Math.random() * 20 + 14;
            const left = Math.random() * 100;
            const duration = Math.random() * 8 + 6;
            const delay = Math.random() * 10;

            if (shapeType === 'circle' || shapeType === 'square') {
                shape.style.width = `${size}px`;
                shape.style.height = `${size}px`;
            } else if (shapeType === 'star') {
                shape.innerHTML = '★';
            }

            shape.style.left = `${left}%`;
            shape.style.animationDuration = `${duration}s`;
            shape.style.animationDelay = `${delay}s`;

            container.appendChild(shape);
        }
        document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let remember = document.getElementById('remember').checked;
    let errorMessage = document.getElementById('error-message');

    errorMessage.style.display = 'none';
    errorMessage.textContent = '';

    if (remember) {
        localStorage.setItem('remembered_email', email);
        localStorage.setItem('remember_me', 'true');
    } else {
        localStorage.removeItem('remembered_email');
        localStorage.removeItem('remember_me');
    }

    fetch('http://127.0.0.1:8000/adminlogin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password,
        }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Login response:', data);
        if (data.message === 'Login successful') {
            // Ensure the redirection URL is correct
            window.location.href = data.redirect_to;  // Redirect to the correct URL
        } else {
            errorMessage.style.display = 'block';
            errorMessage.textContent = data.message || 'Invalid credentials.';
        }
    })
    .catch(error => {
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'An error occurred. Please try again later.';
    });
});
    </script>

</body>
</html>
