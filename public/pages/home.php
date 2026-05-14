<?php
require_once __DIR__ . '/../../config/database.php';

// Featured — all active listings
$featuredStmt = $db->prepare(
    'SELECT l.listingID, l.title, l.description, l.price, l.itemCondition, l.category, l.location,
            li.filename AS cover,
            u.username AS sellerName, u.phoneNum AS sellerPhone, u.profile_upload AS sellerAvatar, u.rating AS sellerRating
     FROM listing l
     LEFT JOIN listing_images li ON li.listingID = l.listingID AND li.sortOrder = 0
     JOIN user u ON u.userID = l.sellerID
     WHERE l.status = "active"
     ORDER BY l.createdAt DESC'
);
$featuredStmt->execute();
$featured = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

// Recent — 8 most recently added
$recentStmt = $db->prepare(
    'SELECT l.listingID, l.title, l.description, l.price, l.itemCondition, l.category, l.location,
            li.filename AS cover,
            u.username AS sellerName, u.phoneNum AS sellerPhone, u.profile_upload AS sellerAvatar, u.rating AS sellerRating
     FROM listing l
     LEFT JOIN listing_images li ON li.listingID = l.listingID AND li.sortOrder = 0
     JOIN user u ON u.userID = l.sellerID
     WHERE l.status = "active"
     ORDER BY l.createdAt DESC
     LIMIT 8'
);
$recentStmt->execute();
$recent = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

function renderCard(array $item): void {
    $coverSrc     = $item['cover']
        ? 'uploads/listings/' . $item['listingID'] . '/' . htmlspecialchars($item['cover'])
        : null;
    $avatarSrc    = $item['sellerAvatar']
        ? 'uploads/avatars/' . htmlspecialchars($item['sellerAvatar'])
        : null;
    ?>
    <div class="product-card"
         data-listing-id="<?= htmlspecialchars($item['listingID']) ?>"
         data-location="<?= htmlspecialchars($item['location'] ?? '') ?>">

        <div class="card-img">
            <?php if ($coverSrc): ?>
                <img src="<?= $coverSrc ?>" alt="<?= htmlspecialchars($item['title']) ?>">
            <?php else: ?>
                <div class="card-img-placeholder"><i class="ri-image-line"></i></div>
            <?php endif; ?>
            <span class="card-condition"><?= htmlspecialchars($item['itemCondition']) ?></span>
        </div>

        <div class="card-body">
            <div class="card-meta">
                <span class="card-category"><?= htmlspecialchars($item['category']) ?></span>
                <span class="card-location">
                    <i class="ri-map-pin-2-line"></i><?= htmlspecialchars($item['location'] ?? '') ?>
                </span>
            </div>

            <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
            <p class="card-desc"><?= htmlspecialchars($item['description']) ?></p>

            <div class="card-footer">
                <span class="card-price">R <?= number_format((float)$item['price'], 2) ?></span>
                <button class="card-btn"><?= t('home.view_listing') ?></button>
            </div>

            <div class="card-seller">
                <div class="card-seller-avatar">
                    <?php if ($avatarSrc): ?>
                        <img src="<?= $avatarSrc ?>" alt="<?= htmlspecialchars($item['sellerName']) ?>">
                    <?php else: ?>
                        <i class="ri-user-line"></i>
                    <?php endif; ?>
                </div>
                <div class="card-seller-details">
                    <span class="card-seller-name"><?= htmlspecialchars($item['sellerName']) ?></span>
                    <?php if (!empty($item['sellerPhone'])): ?>
                        <span class="card-seller-phone"><?= htmlspecialchars($item['sellerPhone']) ?></span>
                    <?php endif; ?>
                    <div class="card-seller-stars">
                        <?php renderStars(isset($item['sellerRating']) ? (float)$item['sellerRating'] : null); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
}
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
        <?php if (empty($featured)): ?>
            <p class="empty-listings"><?= t('home.no_listings') ?></p>
        <?php else: ?>
            <?php foreach ($featured as $item): ?>
                <?php renderCard($item); ?>
            <?php endforeach; ?>
        <?php endif; ?>
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
        <?php if (empty($recent)): ?>
            <p class="empty-listings"><?= t('home.no_listings') ?></p>
        <?php else: ?>
            <?php foreach ($recent as $item): ?>
                <?php renderCard($item); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>
