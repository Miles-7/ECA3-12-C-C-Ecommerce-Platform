<?php
// Navigation component
// When icons in the navbar are clicked, the url query string will be changed accordingly with the parameters provided
// The provided parameters will then be retrieved in index.php and the requested page will be injected
?>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">

<div class="main-nav">

    <a href='?page=home'> <img src='../public/images/logo2.png' id="logo"> </a>

    <div class="nav-item nav-search">
        <input type="search" placeholder="<?= t('nav.search_placeholder') ?>"
               id="search-bar" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button id="search-btn"><i class="ri-search-line"></i></button>
    </div>

    <div class="nav-item">
        <a href="?page=sell">
            <button id="sell-btn"><?= t('nav.sell_btn') ?></button>
        </a>
    </div>

    <button id="burger-btn" aria-label="<?= t('nav.menu_label') ?>"><i class="ri-menu-line"></i></button>

    <div class="nav-item nav-right">
        <a href="?page=profile"><i class="ri-user-3-line"></i></a>
        <a href="?page=liked"><i class="ri-heart-line"></i></a>
        <div class="lang">
            <label for="lang-select"><i class="ri-global-line"></i></label>
            <?php $active_lang = $_SESSION['lang'] ?? 'en'; ?>
            <select id="lang-select">
                <option value="en" <?= $active_lang === 'en' ? 'selected' : '' ?>>English</option>
                <option value="af" <?= $active_lang === 'af' ? 'selected' : '' ?>>Afrikaans</option>
                <option value="xh" <?= $active_lang === 'xh' ? 'selected' : '' ?>>isiXhosa</option>
                <option value="zu" <?= $active_lang === 'zu' ? 'selected' : '' ?>>isiZulu</option>
            </select>
        </div>
    </div>

</div>

<script>
    const burgerBtn = document.getElementById('burger-btn');
    const navRight = document.querySelector('.nav-right');

    burgerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        navRight.classList.toggle('nav-open');
    });

    document.addEventListener('click', function (e) {
        if (!navRight.contains(e.target) && !burgerBtn.contains(e.target)) {
            navRight.classList.remove('nav-open');
        }
    });

    // ── Search ───────────────────────────────────────────────────
    function doSearch() {
        const q = document.getElementById('search-bar').value.trim();
        if (!q) return;

        const url = new URL(window.location.href);

        if (url.searchParams.get('page') === 'allProducts' && typeof applySearch === 'function') {
            // Already on allProducts — filter in place
            applySearch(q);
        } else {
            // Navigate to allProducts with the query
            url.searchParams.set('page', 'allProducts');
            url.searchParams.set('q', encodeURIComponent(q));
            window.location.href = url.toString();
        }
    }

    document.getElementById('search-btn').addEventListener('click', doSearch);
    document.getElementById('search-bar').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') doSearch();
    });

    document.getElementById('lang-select').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('lang', this.value);
        window.location.href = url.toString();
    });
</script>
