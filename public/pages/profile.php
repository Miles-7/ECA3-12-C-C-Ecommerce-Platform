<?php
require_once __DIR__ . '/../../config/database.php';

$userID = $_SESSION['user_id'];

$stmt = $db->prepare('SELECT userID, username, email, profile_upload, createdAt, balance FROM user WHERE userID = :id');
$stmt->execute([':id' => $userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$avatarFile  = $user['profile_upload'] ?? null;
$avatarSrc   = $avatarFile ? 'uploads/avatars/' . htmlspecialchars($avatarFile) : null;
$memberSince = date('F Y', strtotime($user['createdAt']));

// My listings
$listStmt = $db->prepare(
    'SELECT l.listingID, l.title, l.price, l.status, l.createdAt,
            li.filename AS cover
     FROM listing l
     LEFT JOIN listing_images li ON li.listingID = l.listingID AND li.sortOrder = 0
     WHERE l.sellerID = :id
     ORDER BY l.createdAt DESC'
);
$listStmt->execute([':id' => $userID]);
$myListings = $listStmt->fetchAll(PDO::FETCH_ASSOC);

// Buying orders
$buyStmt = $db->prepare(
    'SELECT o.orderID, o.amount, o.status, o.createdAt,
            l.title AS listingTitle,
            u.username AS sellerName
     FROM orders o
     JOIN listing l ON l.listingID = o.listingID
     JOIN user u ON u.userID = o.sellerID
     WHERE o.buyerID = :id
     ORDER BY o.createdAt DESC'
);
$buyStmt->execute([':id' => $userID]);
$buyingOrders = $buyStmt->fetchAll(PDO::FETCH_ASSOC);

// Selling orders
$sellStmt = $db->prepare(
    'SELECT o.orderID, o.amount, o.status, o.createdAt,
            l.title AS listingTitle,
            u.username AS buyerName
     FROM orders o
     JOIN listing l ON l.listingID = o.listingID
     JOIN user u ON u.userID = o.buyerID
     WHERE o.sellerID = :id
     ORDER BY o.createdAt DESC'
);
$sellStmt->execute([':id' => $userID]);
$sellingOrders = $sellStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="profile-page-wrapper">

    <!-- ── Profile card ── -->
    <div class="profile-card">

        <div class="profile-banner"></div>

        <div class="profile-avatar-section">
            <div class="avatar-wrapper" id="avatarWrapper">
                <?php if ($avatarSrc): ?>
                    <img src="<?= $avatarSrc ?>" alt="Profile picture" class="avatar-img" id="avatarImg">
                    <div class="avatar-placeholder" id="avatarPlaceholder" style="display:none;">
                        <i class="ri-user-3-line"></i>
                    </div>
                <?php else: ?>
                    <img src="" alt="" class="avatar-img" id="avatarImg" style="display:none;">
                    <div class="avatar-placeholder" id="avatarPlaceholder">
                        <i class="ri-user-3-line"></i>
                    </div>
                <?php endif; ?>
                <div class="avatar-overlay"><i class="ri-camera-line"></i></div>
                <input type="file" id="avatarInput" accept="image/*" style="display:none;">
            </div>
            <p class="avatar-hint"><?= t('profile.avatar_hint') ?></p>
        </div>

        <div class="profile-identity">
            <h1 class="profile-heading" id="profileHeading"><?= htmlspecialchars($user['username']) ?></h1>
            <p class="profile-meta"><?= t('profile.member_since') ?> <?= $memberSince ?></p>
            <div class="profile-balance">
                <i class="ri-wallet-3-line"></i>
                <span>Balance: <strong>R <?= number_format((float)$user['balance'], 2) ?></strong></span>
            </div>
        </div>

        <div class="profile-form-section">
            <h3 class="profile-section-title"><?= t('profile.edit_title') ?></h3>

            <form class="profile-form" id="profileForm">

                <div class="sell-field">
                    <label for="profileName"><?= t('profile.name_label') ?></label>
                    <input class="sell-input" type="text" id="profileName" name="name"
                        value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="sell-field">
                    <label for="profileEmail"><?= t('profile.email_label') ?></label>
                    <input class="sell-input" type="email" id="profileEmail" name="email"
                        value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div id="profileMsg" class="profile-message" style="display:none;"></div>

                <button type="submit" class="sell-submit"><?= t('profile.save_btn') ?></button>

            </form>
        </div>

    </div>

    <!-- ── Tabs ── -->
    <div class="profile-tabs-section">

        <div class="profile-tabs">
            <button class="profile-tab active" data-tab="listings"><?= t('profile.my_listings') ?></button>
            <button class="profile-tab" data-tab="buying">Buying (<?= count($buyingOrders) ?>)</button>
            <button class="profile-tab" data-tab="selling">Selling (<?= count($sellingOrders) ?>)</button>
        </div>

        <!-- My Listings tab -->
        <div class="profile-tab-panel" id="tab-listings">
            <?php if (empty($myListings)): ?>
                <div class="empty-state empty-state--inline">
                    <div class="empty-icon"><i class="ri-store-2-line"></i></div>
                    <h4 class="empty-title"><?= t('profile.no_listings_title') ?></h4>
                    <p class="empty-desc"><?= t('profile.no_listings_desc') ?></p>
                    <a href="?page=sell" class="card-btn"><?= t('profile.post_listing') ?></a>
                </div>
            <?php else: ?>
                <div class="order-list">
                    <?php foreach ($myListings as $item):
                        $coverSrc = $item['cover']
                            ? 'uploads/listings/' . $item['listingID'] . '/' . htmlspecialchars($item['cover'])
                            : null;
                    ?>
                        <div class="order-card">
                            <div class="order-card-img">
                                <?php if ($coverSrc): ?>
                                    <img src="<?= $coverSrc ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php else: ?>
                                    <div class="order-img-placeholder"><i class="ri-image-line"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="order-card-body">
                                <p class="order-card-title"><?= htmlspecialchars($item['title']) ?></p>
                                <p class="order-card-sub">R <?= number_format((float)$item['price'], 2) ?></p>
                            </div>
                            <span class="order-status order-status--<?= $item['status'] ?>">
                                <?= ucfirst($item['status']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Buying tab -->
        <div class="profile-tab-panel" id="tab-buying" style="display:none;">
            <?php if (empty($buyingOrders)): ?>
                <div class="empty-state empty-state--inline">
                    <div class="empty-icon"><i class="ri-shopping-bag-line"></i></div>
                    <h4 class="empty-title">No purchases yet</h4>
                    <p class="empty-desc">Items you buy will appear here.</p>
                    <a href="?page=allProducts" class="card-btn">Browse listings</a>
                </div>
            <?php else: ?>
                <div class="order-list">
                    <?php foreach ($buyingOrders as $order): ?>
                        <div class="order-card" id="buy-order-<?= htmlspecialchars($order['orderID']) ?>">
                            <div class="order-card-body">
                                <p class="order-card-title"><?= htmlspecialchars($order['listingTitle']) ?></p>
                                <p class="order-card-sub">Seller: <?= htmlspecialchars($order['sellerName']) ?> &nbsp;·&nbsp; R <?= number_format((float)$order['amount'], 2) ?></p>
                                <p class="order-card-sub"><?= date('d M Y', strtotime($order['createdAt'])) ?></p>
                            </div>
                            <div class="order-card-actions">
                                <span class="order-status order-status--<?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                                <?php if ($order['status'] === 'shipped'): ?>
                                    <button class="card-btn confirm-delivery-btn"
                                        data-order-id="<?= htmlspecialchars($order['orderID']) ?>">
                                        Mark as Received
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Selling tab -->
        <div class="profile-tab-panel" id="tab-selling" style="display:none;">
            <?php if (empty($sellingOrders)): ?>
                <div class="empty-state empty-state--inline">
                    <div class="empty-icon"><i class="ri-truck-line"></i></div>
                    <h4 class="empty-title">No sales yet</h4>
                    <p class="empty-desc">Orders from buyers will appear here.</p>
                </div>
            <?php else: ?>
                <div class="order-list">
                    <?php foreach ($sellingOrders as $order): ?>
                        <div class="order-card" id="sell-order-<?= htmlspecialchars($order['orderID']) ?>">
                            <div class="order-card-body">
                                <p class="order-card-title"><?= htmlspecialchars($order['listingTitle']) ?></p>
                                <p class="order-card-sub">Buyer: <?= htmlspecialchars($order['buyerName']) ?> &nbsp;·&nbsp; R <?= number_format((float)$order['amount'], 2) ?></p>
                                <p class="order-card-sub"><?= date('d M Y', strtotime($order['createdAt'])) ?></p>
                            </div>
                            <div class="order-card-actions">
                                <span class="order-status order-status--<?= $order['status'] ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                                <?php if ($order['status'] === 'paid'): ?>
                                    <button class="card-btn ship-order-btn"
                                        data-order-id="<?= htmlspecialchars($order['orderID']) ?>">
                                        Mark as Shipped
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<script>
    // ── Avatar ───────────────────────────────────────────────────────
    const avatarWrapper     = document.getElementById('avatarWrapper');
    const avatarInput       = document.getElementById('avatarInput');
    const avatarImg         = document.getElementById('avatarImg');
    const avatarPlaceholder = document.getElementById('avatarPlaceholder');

    avatarWrapper.addEventListener('click', () => avatarInput.click());

    avatarInput.addEventListener('change', async function() {
        const file = this.files[0];
        if (!file) return;

        avatarImg.src = URL.createObjectURL(file);
        avatarImg.style.display = 'block';
        if (avatarPlaceholder) avatarPlaceholder.style.display = 'none';

        const body = new FormData();
        body.append('avatar', file);

        try {
            const res    = await fetch('../api/profile/upload_avatar.php', { method: 'POST', body });
            const result = await res.json();
            if (!result.success) showMsg(result.message, 'error');
        } catch (err) {
            showMsg('Avatar upload failed, please try again.', 'error');
        }
    });

    // ── Profile form ─────────────────────────────────────────────────
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const name  = document.getElementById('profileName').value.trim();
        const email = document.getElementById('profileEmail').value.trim();
        try {
            const res    = await fetch('../api/profile/update_profile.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email })
            });
            const result = await res.json();
            showMsg(result.message, result.success ? 'success' : 'error');
            if (result.success) document.getElementById('profileHeading').textContent = name;
        } catch (err) {
            showMsg('Something went wrong, please try again.', 'error');
        }
    });

    function showMsg(text, type) {
        const el = document.getElementById('profileMsg');
        el.textContent = text;
        el.className = 'profile-message ' + type;
        el.style.display = 'block';
        setTimeout(() => el.style.display = 'none', 4000);
    }

    // ── Tabs ─────────────────────────────────────────────────────────
    document.querySelectorAll('.profile-tab').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.profile-tab-panel').forEach(p => p.style.display = 'none');
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
        });
    });

    // ── Ship order ───────────────────────────────────────────────────
    document.querySelectorAll('.ship-order-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const orderID = this.dataset.orderId;
            this.disabled = true;
            try {
                const res    = await fetch('../api/order/ship_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ orderID })
                });
                const result = await res.json();
                if (result.success) {
                    const card = document.getElementById('sell-order-' + orderID);
                    card.querySelector('.order-status').textContent = 'Shipped';
                    card.querySelector('.order-status').className = 'order-status order-status--shipped';
                    this.remove();
                } else {
                    alert(result.message);
                    this.disabled = false;
                }
            } catch (err) {
                alert('Something went wrong, please try again.');
                this.disabled = false;
            }
        });
    });

    // ── Confirm delivery ─────────────────────────────────────────────
    document.querySelectorAll('.confirm-delivery-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const orderID = this.dataset.orderId;
            this.disabled = true;
            try {
                const res    = await fetch('../api/order/confirm_delivery.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ orderID })
                });
                const result = await res.json();
                if (result.success) {
                    const card = document.getElementById('buy-order-' + orderID);
                    card.querySelector('.order-status').textContent = 'Delivered';
                    card.querySelector('.order-status').className = 'order-status order-status--delivered';
                    this.remove();
                } else {
                    alert(result.message);
                    this.disabled = false;
                }
            } catch (err) {
                alert('Something went wrong, please try again.');
                this.disabled = false;
            }
        });
    });
</script>
