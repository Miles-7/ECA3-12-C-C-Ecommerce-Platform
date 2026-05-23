<?php
require_once __DIR__ . '/../../config/database.php';

$listingID = $_GET['listingID'] ?? '';

// Redirect back home if no valid ID provided
if (empty($listingID)) {
    header('Location: ?page=home');
    exit;
}

// Fetch the listing
$stmt = $db->prepare(
    'SELECT l.listingID, l.sellerID, l.title, l.description, l.price, l.itemCondition, l.category, l.location, l.phoneNum,
            u.username AS sellerName, u.profile_upload AS sellerAvatar, u.rating AS sellerRating
     FROM listing l
     JOIN user u ON u.userID = l.sellerID
     WHERE l.listingID = :id AND l.status = "active"'
);
$stmt->execute([':id' => $listingID]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    header('Location: ?page=home');
    exit;
}

$currentUserID = $_SESSION['user_id'];
$isSeller      = $listing['sellerID'] === $currentUserID;

// Check if the current user has already rated this listing
$ratedStmt = $db->prepare('SELECT stars FROM rating WHERE listingID = :lid AND buyerID = :bid');
$ratedStmt->execute([':lid' => $listingID, ':bid' => $currentUserID]);
$existingRating = $ratedStmt->fetchColumn();

// Check if the current user has saved this listing
$savedStmt = $db->prepare('SELECT 1 FROM saved WHERE buyerID = :uid AND listingID = :lid');
$savedStmt->execute([':uid' => $currentUserID, ':lid' => $listingID]);
$isSaved = (bool)$savedStmt->fetchColumn();

// Fetch all images for this listing ordered by sortOrder
$imgStmt = $db->prepare(
    'SELECT filename FROM listing_images WHERE listingID = :id ORDER BY sortOrder ASC'
);
$imgStmt->execute([':id' => $listingID]);
$images = $imgStmt->fetchAll(PDO::FETCH_COLUMN);

// Build image paths
$imagePaths = array_map(
    fn($f) => 'uploads/listings/' . $listingID . '/' . htmlspecialchars($f),
    $images
);

// Fetch more listings from the same category (exclude current)
$moreStmt = $db->prepare(
    'SELECT l.listingID, l.title, l.description, l.price, l.itemCondition, l.category, l.location,
            li.filename AS cover,
            u.username AS sellerName, u.phoneNum AS sellerPhone, u.profile_upload AS sellerAvatar, u.rating AS sellerRating
     FROM listing l
     LEFT JOIN listing_images li ON li.listingID = l.listingID AND li.sortOrder = 0
     JOIN user u ON u.userID = l.sellerID
     WHERE l.status = "active" AND l.listingID != :id AND l.category = :cat
     ORDER BY l.createdAt DESC
     LIMIT 4'
);
$moreStmt->execute([':id' => $listingID, ':cat' => $listing['category']]);
$more = $moreStmt->fetchAll(PDO::FETCH_ASSOC);



$condLabel = $conditionLabels[$listing['itemCondition']] ?? htmlspecialchars($listing['itemCondition']);
?>

<div class="product-page">

    <a href="javascript:history.back()" class="product-back">
        <i class="ri-arrow-left-line"></i> <?= t('product.back') ?>
    </a>

    <div class="product-detail">

        <!-- ── Image gallery ── -->
        <div class="product-gallery">
            <?php if (!empty($imagePaths)): ?>
                <div class="gallery-main">
                    <img src="<?= $imagePaths[0] ?>" alt="<?= htmlspecialchars($listing['title']) ?>" id="galleryMain">
                </div>
                <?php if (count($imagePaths) > 1): ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($imagePaths as $i => $src): ?>
                            <div class="gallery-thumb <?= $i === 0 ? 'active' : '' ?>" data-src="<?= $src ?>">
                                <img src="<?= $src ?>" alt="Image <?= $i + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="gallery-main gallery-placeholder">
                    <i class="ri-image-line"></i>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── Listing details ── -->
        <div class="product-detail-body">

            <div class="product-badges">
                <span class="card-condition"><?= $condLabel ?></span>
                <span class="card-category"><?= htmlspecialchars($listing['category']) ?></span>
            </div>

            <h1 class="product-title"><?= htmlspecialchars($listing['title']) ?></h1>

            <p class="product-price">R <?= number_format((float)$listing['price'], 2) ?></p>

            <div class="product-location">
                <i class="ri-map-pin-2-line"></i>
                <span><?= htmlspecialchars($listing['location'] ?? '') ?></span>
            </div>

            <div class="product-description">
                <p class="product-desc-label"><?= t('sell.description_label') ?></p>
                <p class="product-desc"><?= htmlspecialchars($listing['description']) ?></p>
            </div>

            <?php $sellerAvatar = $listing['sellerAvatar']
                ? 'uploads/avatars/' . htmlspecialchars($listing['sellerAvatar'])
                : null; ?>
            <div class="product-seller">
                <div class="card-seller-avatar">
                    <?php if ($sellerAvatar): ?>
                        <img src="<?= $sellerAvatar ?>" alt="<?= htmlspecialchars($listing['sellerName']) ?>">
                    <?php else: ?>
                        <i class="ri-user-line"></i>
                    <?php endif; ?>
                </div>
                <div class="card-seller-details">
                    <span class="card-seller-name"><?= htmlspecialchars($listing['sellerName']) ?></span>
                    <?php if (!empty($listing['phoneNum'])): ?>
                        <span class="card-seller-phone"><?= htmlspecialchars($listing['phoneNum']) ?></span>
                    <?php endif; ?>
                    <div class="card-seller-stars">
                        <?php renderStars(isset($listing['sellerRating']) ? (float)$listing['sellerRating'] : null); ?>
                    </div>
                </div>
            </div>

            <div class="product-actions">
                <button class="product-buy-btn"><?= t('modal.buy_btn') ?></button>
                <?php if (!$isSeller): ?>
                    <button class="product-report-btn" id="reportBtn">
                        <i class="ri-flag-line"></i><?= t('modal.report_btn') ?>
                    </button>
                <?php endif; ?>
                <button class="product-save-btn <?= $isSaved ? 'saved' : '' ?>" id="saveBtn">
                    <i class="<?= $isSaved ? 'ri-heart-fill' : 'ri-heart-line' ?>"></i>
                </button>
            </div>

            <!-- ── Rate this seller ── -->
            <?php if (!$isSeller): ?>
                <div class="rate-seller">
                    <p class="rate-seller-label">
                        <?= $existingRating !== false ? 'Your rating' : 'Rate this seller' ?>
                    </p>
                    <div class="rate-stars" id="rateStars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= ($existingRating !== false && $i <= (int)$existingRating) ? 'ri-star-fill' : 'ri-star-line' ?>"
                                data-star="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <?php if ($existingRating !== false): ?>
                        <p class="rate-seller-note">You rated this seller <?= (int)$existingRating ?> / 5</p>
                    <?php else: ?>
                        <p class="rate-seller-note" id="rateMsg"></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- ── More from this category ─────────────────── -->
    <?php if (!empty($more)): ?>
        <section class="featured-section">

            <div class="featured-header">
                <h2 class="featured-title"><?= t('product.more_listings') ?></h2>
                <a href="?page=allProducts" class="featured-view-all">
                    <?= t('home.view_all') ?> <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="listing-grid">
                <?php foreach ($more as $item):
                    $coverSrc      = $item['cover']
                        ? 'uploads/listings/' . $item['listingID'] . '/' . htmlspecialchars($item['cover'])
                        : null;
                    $moreAvatarSrc = $item['sellerAvatar']
                        ? 'uploads/avatars/' . htmlspecialchars($item['sellerAvatar'])
                        : null;
                    $moreCondLabel = $conditionLabels[$item['itemCondition']] ?? htmlspecialchars($item['itemCondition']);
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
                            <span class="card-condition"><?= $moreCondLabel ?></span>
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
                                    <?php if ($moreAvatarSrc): ?>
                                        <img src="<?= $moreAvatarSrc ?>" alt="<?= htmlspecialchars($item['sellerName']) ?>">
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

        </section>
    <?php endif; ?>

    <div class="reportModel-container" id="reportModel-container">
        <div class="reportModel">

            <div class="reportModel-header">
                <span>Report this listing</span>
                <button class="reportModel-close" id="reportModel-close">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div class="reportModel-body">
                <label class="reportModel-label" for="reportReason">Why are you reporting this listing?</label>
                <select class="sell-select" id="reportReason">
                    <option value="" disabled selected>Select a reason</option>
                    <option value="spam">Spam</option>
                    <option value="counterfeit">Counterfeit</option>
                    <option value="inappropriate">Inappropriate content</option>
                    <option value="scam">Scam</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="reportModel-footer">
                <button class="reportModel-cancel-btn" id="reportModel-cancel">Cancel</button>
                <button class="reportModel-confirm-btn" id="reportModel-confirm">
                    <i class="ri-flag-line"></i> Report
                </button>
            </div>

        </div>
    </div>

    <script>
        // ── Gallery ──────────────────────────────────────────
        document.querySelectorAll('.gallery-thumb').forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                document.getElementById('galleryMain').src = this.dataset.src;
                document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // ── Star rating ──────────────────────────────────────
        const rateStars = document.getElementById('rateStars');
        const rateMsg = document.getElementById('rateMsg');
        const alreadyRated = <?= $existingRating !== false ? 'true' : 'false' ?>;

        if (rateStars && !alreadyRated) {
            const stars = rateStars.querySelectorAll('i');

            // Hover highlight
            stars.forEach(star => {
                star.addEventListener('mouseenter', function() {
                    const val = parseInt(this.dataset.star);
                    stars.forEach((s, i) => {
                        s.className = i < val ? 'ri-star-fill' : 'ri-star-line';
                    });
                });
            });

            rateStars.addEventListener('mouseleave', function() {
                stars.forEach(s => s.className = 'ri-star-line');
            });

            // Click to submit
            stars.forEach(star => {
                star.addEventListener('click', async function() {
                    const selectedStars = parseInt(this.dataset.star);

                    try {
                        const res = await fetch('../api/rating/submit_rating.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                listingID: '<?= htmlspecialchars($listingID) ?>',
                                stars: selectedStars
                            })
                        });
                        const result = await res.json();

                        if (result.success) {
                            // Lock stars at submitted value
                            stars.forEach((s, i) => {
                                s.className = i < selectedStars ? 'ri-star-fill' : 'ri-star-line';
                            });
                            rateStars.style.pointerEvents = 'none';
                            if (rateMsg) rateMsg.textContent = 'You rated this seller ' + selectedStars + ' / 5';
                        } else {
                            if (rateMsg) rateMsg.textContent = result.message;
                        }
                    } catch (err) {
                        if (rateMsg) rateMsg.textContent = 'Something went wrong, please try again.';
                    }
                });
            });
        }


        // ── Save / unsave ────────────────────────────────────
        const saveBtn = document.getElementById('saveBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', async function() {
                try {
                    const res = await fetch('../api/saved/toggle_save.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            listingID: '<?= htmlspecialchars($listingID) ?>'
                        })
                    });
                    const result = await res.json();
                    if (result.success) {
                        const icon = saveBtn.querySelector('i');
                        if (result.saved) {
                            icon.className = 'ri-heart-fill';
                            saveBtn.classList.add('saved');
                        } else {
                            icon.className = 'ri-heart-line';
                            saveBtn.classList.remove('saved');
                        }
                    }
                } catch (err) {
                    console.error('Save toggle failed');
                }
            });
        }

        // ── Buy ──────────────────────────────────────────────
        document.querySelector('.product-buy-btn').addEventListener('click', async function() {
            try {
                const res = await fetch('../api/order/create_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        listingID: '<?= htmlspecialchars($listingID) ?>'
                    })
                });
                const result = await res.json();

                if (result.success) {
                    alert('Purchase successful!');
                    window.location.href = '?page=orders';
                } else {
                    alert(result.message);
                }
            } catch (err) {
                alert('Something went wrong, please try again.');
            }
        });





        const reportContainer = document.getElementById('reportModel-container');

        function openReportModal()  { reportContainer.classList.add('open'); }
        function closeReportModal() { reportContainer.classList.remove('open'); }

        const reportBtn = document.getElementById('reportBtn');
        if (reportBtn) reportBtn.addEventListener('click', openReportModal);

        document.getElementById('reportModel-close').addEventListener('click', closeReportModal);
        document.getElementById('reportModel-cancel').addEventListener('click', closeReportModal);
        reportContainer.addEventListener('click', function(e) {
            if (e.target === reportContainer) closeReportModal();
        });
    </script>