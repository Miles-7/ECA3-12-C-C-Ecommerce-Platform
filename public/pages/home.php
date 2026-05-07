<?php

// hard code for now till i start backend
$recent = [
    [
        'title'       => 'Nike Air Max 90 — Size 10',
        'description' => 'Worn twice, basically new. All original packaging included. No scuffs or sole wear.',
        'price'       => '1 200',
        'condition'   => 'Like New',
        'category'    => 'Clothing',
        'location'    => 'Bloemfontein, FS',
        'img_bg'      => '#C8D4C0',
        'img_icon'    => 'ri-footprint-line',
    ],
    [
        'title'       => 'IKEA BILLY Bookcase — White',
        'description' => 'Solid condition, some minor shelf scuffs. All fittings included. Disassembled for easy transport.',
        'price'       => '450',
        'condition'   => 'Good',
        'category'    => 'Furniture',
        'location'    => 'Cape Town, WC',
        'img_bg'      => '#D8CFC7',
        'img_icon'    => 'ri-book-shelf-line',
    ],
    [
        'title'       => 'PlayStation 5 DualSense Controller',
        'description' => 'Midnight Black edition. Light use, triggers and haptics work perfectly. No stick drift.',
        'price'       => '800',
        'condition'   => 'Good',
        'category'    => 'Electronics',
        'location'    => 'Durban, KZN',
        'img_bg'      => '#BFC8D4',
        'img_icon'    => 'ri-gamepad-line',
    ],
    [
        'title'       => 'The Alchemist — Paulo Coelho',
        'description' => 'Paperback, read once. No highlights or writing inside. Great condition for a used book.',
        'price'       => '50',
        'condition'   => 'Like New',
        'category'    => 'Books',
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#D4C9B8',
        'img_icon'    => 'ri-book-open-line',
    ],
    [
        'title'       => 'Nike Air Max 90 — Size 10',
        'description' => 'Worn twice, basically new. All original packaging included. No scuffs or sole wear.',
        'price'       => '1 200',
        'condition'   => 'Like New',
        'category'    => 'Clothing',
        'location'    => 'Bloemfontein, FS',
        'img_bg'      => '#C8D4C0',
        'img_icon'    => 'ri-footprint-line',
    ],
    [
        'title'       => 'IKEA BILLY Bookcase — White',
        'description' => 'Solid condition, some minor shelf scuffs. All fittings included. Disassembled for easy transport.',
        'price'       => '450',
        'condition'   => 'Good',
        'category'    => 'Furniture',
        'location'    => 'Cape Town, WC',
        'img_bg'      => '#D8CFC7',
        'img_icon'    => 'ri-book-shelf-line',
    ],
    [
        'title'       => 'PlayStation 5 DualSense Controller',
        'description' => 'Midnight Black edition. Light use, triggers and haptics work perfectly. No stick drift.',
        'price'       => '800',
        'condition'   => 'Good',
        'category'    => 'Electronics',
        'location'    => 'Durban, KZN',
        'img_bg'      => '#BFC8D4',
        'img_icon'    => 'ri-gamepad-line',
    ],
    [
        'title'       => 'The Alchemist — Paulo Coelho',
        'description' => 'Paperback, read once. No highlights or writing inside. Great condition for a used book.',
        'price'       => '50',
        'condition'   => 'Like New',
        'category'    => 'Books',
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#D4C9B8',
        'img_icon'    => 'ri-book-open-line',
    ],
];

$featured = [
    [
        'title'       => 'iPhone 13 Pro — 256GB Sierra Blue',
        'description' => 'Barely used, no scratches. Comes with original box, charger and two cases. Battery health at 97%.',
        'price'       => '8 500',
        'condition'   => 'Like New',
        'category'    => 'Electronics',
        'location'    => 'Cape Town, WC',
        'img_bg'      => '#D9C5B2',
        'img_icon'    => 'ri-smartphone-line',
    ],
    [
        'title'       => 'Vintage Leather 3-Seater Couch',
        'description' => 'Rich tan leather, minor wear on armrests. Solid hardwood frame. Bought in 2019, moving sale.',
        'price'       => '2 200',
        'condition'   => 'Good',
        'category'    => 'Furniture',
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#C9B49A',
        'img_icon'    => 'ri-sofa-line',
    ],
    [
        'title'       => 'Trek Marlin 7 Mountain Bike — Medium',
        'description' => '29" wheels, hydraulic disc brakes, recently serviced. Great condition for trail or commuting.',
        'price'       => '3 800',
        'condition'   => 'Good',
        'category'    => 'Sports',
        'location'    => 'Durban, KZN',
        'img_bg'      => '#B5C4B1',
        'img_icon'    => 'ri-riding-line',
    ],
    [
        'title'       => 'Canon EOS 90D + 18-55mm Kit Lens',
        'description' => 'Low shutter count (~4k), full HD video. Includes 2 batteries, 64 GB SD card and carry bag.',
        'price'       => '12 000',
        'condition'   => 'Like New',
        'category'    => 'Electronics',
        'location'    => 'Pretoria, GP',
        'img_bg'      => '#C4B8A8',
        'img_icon'    => 'ri-camera-3-line',
    ],
];
?>

<div class="hero_container">
    <div id="hero_title"><?= t('home.hero_title') ?></div>
</div>

<!-- ── Browse by Category ──────────────────────────── -->
<section class="category-section">

    <h2 class="featured-title"><?= t('home.browse_category') ?></h2>

    <div class="category-grid">
        <a href="?page=allProducts&cat=electronics" class="category-chip">
            <div class="chip-icon"><i class="ri-smartphone-line"></i></div>
            <span><?= t('sell.cat_electronics') ?></span>
        </a>
        <a href="?page=allProducts&cat=clothing" class="category-chip">
            <div class="chip-icon"><i class="ri-shirt-line"></i></div>
            <span><?= t('sell.cat_clothing') ?></span>
        </a>
        <a href="?page=allProducts&cat=home" class="category-chip">
            <div class="chip-icon"><i class="ri-home-3-line"></i></div>
            <span><?= t('sell.cat_home') ?></span>
        </a>
        <a href="?page=allProducts&cat=vehicles" class="category-chip">
            <div class="chip-icon"><i class="ri-car-line"></i></div>
            <span><?= t('sell.cat_vehicles') ?></span>
        </a>
        <a href="?page=allProducts&cat=furniture" class="category-chip">
            <div class="chip-icon"><i class="ri-sofa-line"></i></div>
            <span><?= t('sell.cat_furniture') ?></span>
        </a>
        <a href="?page=allProducts&cat=books" class="category-chip">
            <div class="chip-icon"><i class="ri-book-open-line"></i></div>
            <span><?= t('sell.cat_books') ?></span>
        </a>
        <a href="?page=allProducts&cat=sports" class="category-chip">
            <div class="chip-icon"><i class="ri-football-line"></i></div>
            <span><?= t('sell.cat_sports') ?></span>
        </a>
        <a href="?page=allProducts&cat=baby" class="category-chip">
            <div class="chip-icon"><i class="ri-bear-smile-line"></i></div>
            <span><?= t('sell.cat_baby') ?></span>
        </a>
        <a href="?page=allProducts&cat=other" class="category-chip">
            <div class="chip-icon"><i class="ri-apps-2-line"></i></div>
            <span><?= t('sell.cat_other') ?></span>
        </a>
    </div>

</section>

<!-- ── Featured Listings ───────────────────────────── -->
<section class="featured-section">

    <div class="featured-header">
        <h2 class="featured-title"><?= t('home.featured_title') ?></h2>
        <a href="?page=allProducts" class="featured-view-all"><?= t('home.view_all') ?> <i class="ri-arrow-right-line"></i></a>
    </div>

    <div class="listing-grid">
        <?php foreach ($featured as $item): ?>
            <div class="product-card"
                 data-img-bg="<?= $item['img_bg'] ?>"
                 data-img-icon="<?= $item['img_icon'] ?>"
                 data-location="<?= htmlspecialchars($item['location']) ?>">

                <div class="card-img" style="background-color: <?= $item['img_bg'] ?>">
                    <i class="<?= $item['img_icon'] ?>"></i>
                    <span class="card-condition"><?= $item['condition'] ?></span>
                </div>

                <div class="card-body">
                    <div class="card-meta">
                        <span class="card-category"><?= $item['category'] ?></span>
                        <span class="card-location">
                            <i class="ri-map-pin-2-line"></i><?= $item['location'] ?>
                        </span>
                    </div>

                    <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="card-desc"><?= htmlspecialchars($item['description']) ?></p>

                    <div class="card-footer">
                        <span class="card-price">R <?= $item['price'] ?></span>
                        <button class="card-btn"><?= t('home.view_listing') ?></button>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</section>

<!-- ── Slogan Banner ────────────────────────────────── -->
<section class="slogan-banner">
    <p class="slogan-eyebrow"><?= t('home.slogan_eyebrow') ?></p>
    <h2 class="slogan-heading"><?= t('home.slogan') ?></h2>
    <p class="slogan-sub"><?= t('home.slogan_sub') ?></p>
    <a href="?page=allProducts" class="slogan-cta"><?= t('home.view_all') ?> <i class="ri-arrow-right-line"></i></a>
</section>

<!-- ── Recent Listings ──────────────────────────────── -->
<section class="featured-section">

    <div class="featured-header">
        <h2 class="featured-title"><?= t('home.recent_title') ?></h2>
        <a href="?page=allProducts" class="featured-view-all"><?= t('home.view_all') ?> <i class="ri-arrow-right-line"></i></a>
    </div>

    <div class="listing-grid">
        <?php foreach ($recent as $item): ?>
            <div class="product-card"
                 data-img-bg="<?= $item['img_bg'] ?>"
                 data-img-icon="<?= $item['img_icon'] ?>"
                 data-location="<?= htmlspecialchars($item['location']) ?>">

                <div class="card-img" style="background-color: <?= $item['img_bg'] ?>">
                    <i class="<?= $item['img_icon'] ?>"></i>
                    <span class="card-condition"><?= $item['condition'] ?></span>
                </div>

                <div class="card-body">
                    <div class="card-meta">
                        <span class="card-category"><?= $item['category'] ?></span>
                        <span class="card-location">
                            <i class="ri-map-pin-2-line"></i><?= $item['location'] ?>
                        </span>
                    </div>

                    <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="card-desc"><?= htmlspecialchars($item['description']) ?></p>

                    <div class="card-footer">
                        <span class="card-price">R <?= $item['price'] ?></span>
                        <button class="card-btn"><?= t('home.view_listing') ?></button>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</section>