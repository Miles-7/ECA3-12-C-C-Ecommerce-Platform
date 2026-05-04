<?php
// Navigation component
// When icons in the navbar are clicked, the url query string will be changed accordingly with the parameters provided
// The provided parameters will then be retrieved in index.php and the requested page will be injected
?>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">

<div class="main-nav">

    <a href='?page=home'> <img src='../public/images/logo2.png' id="logo"> </a>

    <div class="nav-item nav-search">
        <input type="search" placeholder="<?= t('nav.search_placeholder') ?>" id="search-bar">
        <button id="search-btn"><i class="ri-search-line"></i></button>
    </div>

    <div class="nav-item">
        <a href="?page=sell">
            <button id="sell-btn"><?= t('nav.sell_btn') ?></button>
        </a>
    </div>

    <div class="nav-item nav-right">
        <a href="?page=profile"><i class="ri-user-3-line"></i></a>
        <a href="?page=liked"><i class="ri-heart-line"></i></a>
        <div class="lang">
            <label for="lang-select"><i class="ri-global-line"></i></label>
            <select id="lang-select">
                <option value="en" <?= $current_lang === 'en' ? 'selected' : '' ?>>English</option>
                <option value="af" <?= $current_lang === 'af' ? 'selected' : '' ?>>Afrikaans</option>
                <option value="xh" <?= $current_lang === 'xh' ? 'selected' : '' ?>>isiXhosa</option>
                <option value="zu" <?= $current_lang === 'zu' ? 'selected' : '' ?>>isiZulu</option>
            </select>
        </div>
    </div>

</div>

<script>
    document.getElementById('lang-select').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('lang', this.value);
        window.location.href = url.toString();
    });
</script>
