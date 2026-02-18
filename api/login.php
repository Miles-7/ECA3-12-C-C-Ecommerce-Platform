<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuka Market | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="auth-page">

<div class="auth-wrapper">
    <div class="auth-panel-left">
        <div class="panel-content">
            <div class="logo-mark">V</div>
            <h1 class="panel-title">Vuka Market</h1>
            <p class="panel-sub">Rise. Sell. Thrive.</p>
            <div class="panel-divider"></div>
            <p class="panel-desc">South Africa's C-2-C marketplace built for the hustle. Connect, sell, and grow your business digitally.</p>
            <div class="panel-stats">
                <div class="stat">
                    <span class="stat-num">R900B</span>
                    <span class="stat-label">Township Economy</span>
                </div>
                <div class="stat">
                    <span class="stat-num">100%</span>
                    <span class="stat-label">Local Platform</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-panel-right">
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">Welcome back</h2>
                <p class="form-subtitle">Sign in to your Vuka account</p>
            </div>

            <form id="loginForm" method="post" action="">
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="ri-mail-line"></i>
                        <input type="email" name="email" id="email" placeholder="youremail@example.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="ri-lock-line"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <span>Login</span>
                    <i class="ri-arrow-right-line"></i>
                </button>
            </form>

            <div class="change-auth">
                Don't have an account? <a href="register.php">Sign Up</a>
            </div>
        </div>
    </div>
</div>

<script>
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const formData = { email, password };

        try {
            const response = await fetch('../../api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                alert('Login successful! Welcome ' + result.user.name);
                window.location.href = '../index.php';
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Error: ' + error.message);
        }
    });
</script>

</body>
</html>