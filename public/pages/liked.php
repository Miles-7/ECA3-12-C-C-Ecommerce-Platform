<?php
require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare(
    'SELECT l.listingID, l.title, l.description, l.price, l.itemCondition, l.category, l.location,
            li.filename AS cover,
            u.username AS sellerName, u.phoneNum AS sellerPhone, u.profile_upload AS sellerAvatar, u.rating AS sellerRating
     FROM saved s
     JOIN listing l ON l.listingID = s.listingID
     LEFT JOIN listing_images li ON li.listingID = l.listingID AND li.sortOrder = 0
     JOIN user u ON u.userID = l.sellerID
     WHERE s.buyerID = :uid AND l.status = "active"
     ORDER BY s.savedAt DESC'
);
$stmt->execute([':uid' => $_SESSION['user_id']]);
$saved = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conditionLabels = [
    'new'      => t('sell.cond_new'),
    'like_new' => t('sell.cond_like_new'),
    'good'     => t('sell.cond_good'),
    'fair'     => t('sell.cond_fair'),
    'parts'    => t('sell.cond_parts'),
];
?>

<div class="liked-page-wrapper">

    <div class="liked-hero">
        <h1 class="liked-hero-title">Saved Listings</h1>
        <p class="liked-hero-sub">
            <?= count($saved) ?> <?= count($saved) === 1 ? 'item' : 'items' ?> saved
        </p>
    </div>

    <?php if (empty($saved)): ?>
        <div class="liked-empty">
            <i class="ri-heart-line liked-empty-icon"></i>
            <p class="liked-empty-desc"><?= t('liked.empty_desc') ?></p>
            <a href="?page=allProducts" class="card-btn liked-empty-btn"><?= t('liked.browse_btn') ?></a>
        </div>
    <?php else: ?>
        <div class="listing-grid">
            <?php foreach ($saved as $item):
                $coverSrc  = $item['cover']
                    ? 'uploads/listings/' . $item['listingID'] . '/' . htmlspecialchars($item['cover'])
                    : null;
                $avatarSrc = $item['sellerAvatar']
                    ? 'uploads/avatars/' . htmlspecialchars($item['sellerAvatar'])
                    : null;
                $condLabel = $conditionLabels[$item['itemCondition']] ?? htmlspecialchars($item['itemCondition']);
            ?>
                <div class="product-card" data-listing-id="<?= htmlspecialchars($item['listingID']) ?>">

                    <div class="card-img">
                        <?php if ($coverSrc): ?>
                            <img src="<?= $coverSrc ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-placeholder"><i class="ri-image-line"></i></div>
                        <?php endif; ?>
                        <span class="card-condition"><?= $condLabel ?></span>
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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
