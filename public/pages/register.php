<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuka Market | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="auth-page">

<div class="container" id="sign-up">
    <div class="brand">
        <h2 class="brand-name">Vuka Market</h2>
        <p class="brand-tagline">Rise. Sell. Thrive.</p>
    </div>
    <h1 class="form-title">Register</h1>
    <form id="registerForm" method="post" action="">
        <div class="input-group">
            <i class="ri-user-fill"></i>
            <input type="text" name="name" id="name" placeholder="Full name" required>
            <label for="name">Full Name</label>
        </div>

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

        <button type="submit" class="submit-btn">Register</button>
    </form>

    <div class="change-auth"> 
        Already have an account? <a href="login.php">Sign In</a>
    </div>
</div>

<script>
    const registerForm = document.getElementById('registerForm');

    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const formData = {
            name: name,
            email: email,
            password: password
        };

        try {
            const response = await fetch('../../api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                alert('Registration successful! Redirecting to login...');
                window.location.href = 'login.php'; 
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