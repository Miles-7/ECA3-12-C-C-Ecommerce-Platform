<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="auth-page">

    <div class="container" id="sign-up">
        <h1 class="form-title">Register</h1>
        <form id="registerForm" method="post" action="">
            <div class="input-group">
                <i class="ri-user-fill"></i>
                <input type="text" name="name" id="name" placeholder="Username" required>
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

        // listener for register form
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // get form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // create data object
            const formData = {
                name: name,
                email: email,
                password: password
            };

            try {
                // sending data to api 
                const response = await fetch('../../api/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                // get response 
                const result = await response.json();

                // handle response
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