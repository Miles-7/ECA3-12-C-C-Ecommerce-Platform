<?php require __DIR__ . '/../../src/helpers/lang.php'; ?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('login.title') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../styling/main.css">
</head>

<body class="auth-page">

    <div class="container" id="sign-up">
        <h1 class="form-title"><?= t('login.title') ?></h1>
        <form id="loginForm" method="post" action="">
            <div class="input-group">
                <i class="ri-mail-fill"></i>
                <input type="email" name="email" id="email" placeholder="<?= t('login.email_placeholder') ?>" required>
                <label for="email"></label>
            </div>

            <div class="input-group">
                <i class="ri-lock-fill"></i>
                <input type="password" name="password" id="password" placeholder="<?= t('login.password_placeholder') ?>" required>
                <label for="password"></label>
            </div>

            <button type="submit" class="submit-btn"><?= t('login.submit') ?></button>
        </form>

        <div class="change-auth">
            <?= t('login.no_account') ?> <a href="register.php"><?= t('login.sign_up') ?></a>
        </div>

        <div class="lang-selector">
            <i class="ri-global-line"></i>
            <select id="lang-select">
                <option value="en" <?= $current_lang === 'en' ? 'selected' : '' ?>>English</option>
                <option value="af" <?= $current_lang === 'af' ? 'selected' : '' ?>>Afrikaans</option>
                <option value="xh" <?= $current_lang === 'xh' ? 'selected' : '' ?>>isiXhosa</option>
                <option value="zu" <?= $current_lang === 'zu' ? 'selected' : '' ?>>isiZulu</option>
            </select>
        </div>
    </div>

    <script>
        document.getElementById('lang-select').addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('lang', this.value);
            window.location.href = url.toString();
        });

        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const formData = { email, password };

            try {
                const response = await fetch('../../api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    if (result.user.role === 'admin') {
                        window.location.href = 'adminDashboard.php';
                    } else {
                        window.location.href = '../index.php';
                    }
                } else {
                    alert('<?= t('login.error') ?>: ' + result.message);
                }

            } catch (error) {
                alert('<?= t('login.error') ?>: ' + error.message);
            }
        });
    </script>

</body>

</html>
