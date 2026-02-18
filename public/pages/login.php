<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuka Market | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="auth-page">

<div class="container" id="sign-up">
    <div class="brand">
        <h2 class="brand-name">Vuka Market</h2>
        <p class="brand-tagline">Rise. Sell. Thrive.</p>
    </div>
    <h1 class="form-title">Login</h1>
    <form id="loginForm" method="post" action="">
        <div class="input-group">
            <i class="ri-mail-fill"></i>
            <input type="email" name="email" id="email" placeholder="youremail@example.com" required>
            <label for="email">Email</label>
        </div>

        <div class="input-group">
            <i class="ri-lock-fill"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button type="submit" class="submit-btn">Login</button>
    </form>

    <div class="change-auth"> 
        Don't have an account? <a href="register.php">Sign Up!</a>
    </div>
</div>

<script>
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const formData = {
            email: email,
            password: password
        };

        try {
            const response = await fetch('../../api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
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