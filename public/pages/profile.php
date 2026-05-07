<?php
require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare('SELECT id, name, email, profile_picture, created_at FROM users WHERE id = :id');
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$avatarFile = $user['profile_picture'] ?? null;
$avatarSrc  = $avatarFile ? 'uploads/avatars/' . htmlspecialchars($avatarFile) : null;
$memberSince = date('F Y', strtotime($user['created_at']));
?>

<div class="profile-page-wrapper">

    <!-- ── Profile card ── -->
    <div class="profile-card">

        <!-- Banner -->
        <div class="profile-banner"></div>

        <!-- Avatar (overlaps banner) -->
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

        <!-- Name + meta -->
        <div class="profile-identity">
            <h1 class="profile-heading" id="profileHeading"><?= htmlspecialchars($user['name']) ?></h1>
            <p class="profile-meta"><?= t('profile.member_since') ?> <?= $memberSince ?></p>
        </div>

        <!-- Edit form -->
        <div class="profile-form-section">
            <h3 class="profile-section-title"><?= t('profile.edit_title') ?></h3>

            <form class="profile-form" id="profileForm">

                <div class="sell-field">
                    <label for="profileName"><?= t('profile.name_label') ?></label>
                    <input class="sell-input" type="text" id="profileName" name="name"
                           value="<?= htmlspecialchars($user['name']) ?>" required>
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

    <!-- ── My Listings ── -->
    <div class="profile-listings-section">
        <h3 class="profile-section-title"><?= t('profile.my_listings') ?></h3>

        <div class="empty-state empty-state--inline">
            <div class="empty-icon">
                <i class="ri-store-2-line"></i>
            </div>
            <h4 class="empty-title"><?= t('profile.no_listings_title') ?></h4>
            <p class="empty-desc"><?= t('profile.no_listings_desc') ?></p>
            <a href="?page=sell" class="card-btn"><?= t('profile.post_listing') ?></a>
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

    avatarInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) return;

        avatarImg.src = URL.createObjectURL(file);
        avatarImg.style.display = 'block';
        if (avatarPlaceholder) avatarPlaceholder.style.display = 'none';

        const body = new FormData();
        body.append('avatar', file);

        const res    = await fetch('../api/upload_avatar.php', { method: 'POST', body });
        const result = await res.json();

        if (!result.success) showMsg(result.message, 'error');
    });

    // ── Profile form ─────────────────────────────────────────────────
    document.getElementById('profileForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const name  = document.getElementById('profileName').value.trim();
        const email = document.getElementById('profileEmail').value.trim();

        const res    = await fetch('../api/update_profile.php', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ name, email })
        });
        const result = await res.json();

        showMsg(result.message, result.success ? 'success' : 'error');
        if (result.success) {
            document.getElementById('profileHeading').textContent = name;
        }
    });

    function showMsg(text, type) {
        const el = document.getElementById('profileMsg');
        el.textContent   = text;
        el.className     = 'profile-message ' + type;
        el.style.display = 'block';
        setTimeout(() => { el.style.display = 'none'; }, 4000);
    }
</script>
