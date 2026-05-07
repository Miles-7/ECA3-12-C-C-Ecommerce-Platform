<?php
$title     = htmlspecialchars($_GET['title']     ?? '', ENT_QUOTES);
$desc      = htmlspecialchars($_GET['desc']      ?? '', ENT_QUOTES);
$price     = htmlspecialchars($_GET['price']     ?? '', ENT_QUOTES);
$condition = htmlspecialchars($_GET['condition'] ?? '', ENT_QUOTES);
$category  = htmlspecialchars($_GET['category']  ?? '', ENT_QUOTES);
$location  = htmlspecialchars($_GET['location']  ?? '', ENT_QUOTES);
$img_bg    = preg_match('/^#[0-9a-fA-F]{3,6}$/', $_GET['img_bg']   ?? '') ? $_GET['img_bg']   : '#D9C5B2';
$img_icon  = preg_match('/^[a-z0-9-]+$/',         $_GET['img_icon'] ?? '') ? $_GET['img_icon'] : 'ri-price-tag-3-line';

$more = [
    [
        'title'       => 'Vintage Leather 3-Seater Couch',
        'description' => 'Rich tan leather, minor wear on armrests. Solid hardwood frame. Bought in 2019, moving sale.',
        'price'       => 'R 2 200',
        'condition'   => t('sell.cond_good'),
        'category'    => t('sell.cat_furniture'),
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#C9B49A',
        'img_icon'    => 'ri-sofa-line',
    ],
    [
        'title'       => 'Trek Marlin 7 Mountain Bike — Medium',
        'description' => '29" wheels, hydraulic disc brakes, recently serviced. Great condition for trail or commuting.',
        'price'       => 'R 3 800',
        'condition'   => t('sell.cond_good'),
        'category'    => t('sell.cat_sports'),
        'location'    => 'Durban, KZN',
        'img_bg'      => '#B5C4B1',
        'img_icon'    => 'ri-riding-line',
    ],
    [
        'title'       => 'Canon EOS 90D + 18-55mm Kit Lens',
        'description' => 'Low shutter count (~4k), full HD video. Includes 2 batteries, 64 GB SD card and carry bag.',
        'price'       => 'R 12 000',
        'condition'   => t('sell.cond_like_new'),
        'category'    => t('sell.cat_electronics'),
        'location'    => 'Pretoria, GP',
        'img_bg'      => '#C4B8A8',
        'img_icon'    => 'ri-camera-3-line',
    ],
    [
        'title'       => 'Nike Air Max 90 — Size 10',
        'description' => 'Worn twice, basically new. All original packaging included. No scuffs or sole wear.',
        'price'       => 'R 1 200',
        'condition'   => t('sell.cond_like_new'),
        'category'    => t('sell.cat_clothing'),
        'location'    => 'Bloemfontein, FS',
        'img_bg'      => '#C8D4C0',
        'img_icon'    => 'ri-footprint-line',
    ],
];
?>

<div class="product-page">

    <a href="javascript:history.back()" class="product-back">
        <i class="ri-arrow-left-line"></i> <?= t('product.back') ?>
    </a>

    <div class="product-detail">

        <div class="product-detail-img" style="background-color: <?= $img_bg ?>">
            <i class="<?= $img_icon ?>"></i>
        </div>

        <div class="product-detail-body">

            <div class="product-badges">
                <span class="card-condition"><?= $condition ?></span>
                <span class="card-category"><?= $category ?></span>
            </div>

            <h1 class="product-title"><?= $title ?></h1>

            <p class="product-price"><?= $price ?></p>

            <div class="product-location">
                <i class="ri-map-pin-2-line"></i>
                <span><?= $location ?></span>
            </div>

            <div class="product-description">
                <p class="product-desc-label"><?= t('sell.description_label') ?></p>
                <p class="product-desc"><?= $desc ?></p>
            </div>

            <div class="product-actions">
                <button class="product-buy-btn"><?= t('modal.buy_btn') ?></button>
                <button class="product-msg-btn">
                    <i class="ri-message-3-line"></i><?= t('modal.message_btn') ?>
                </button>
            </div>

        </div>
    </div>

    <!-- ── More Listings ─────────────────────────── -->
    <section class="featured-section">

        <div class="featured-header">
            <h2 class="featured-title"><?= t('product.more_listings') ?></h2>
            <a href="?page=allProducts" class="featured-view-all">
                <?= t('home.view_all') ?> <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        <div class="listing-grid">
            <?php foreach ($more as $item): ?>
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
                            <span class="card-price"><?= $item['price'] ?></span>
                            <button class="card-btn"><?= t('home.view_listing') ?></button>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </section>

</div>
