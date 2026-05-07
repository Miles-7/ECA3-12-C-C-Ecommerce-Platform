<footer class="site-footer">
    <div class="footer-inner">

        <div class="footer-brand">
            <span class="footer-logo">Vuka</span>
            <p class="footer-tagline"><?= t('footer.tagline') ?></p>
        </div>

        <div class="footer-links">
            <div class="footer-col">
                <h4><?= t('footer.explore') ?></h4>
                <a href="?page=home"><?= t('footer.home') ?></a>
                <a href="?page=sell"><?= t('footer.sell_item') ?></a>
                <a href="?page=liked"><?= t('footer.liked_items') ?></a>
            </div>
            <div class="footer-col">
                <h4><?= t('footer.support') ?></h4>
                <a href="#"><?= t('footer.help_centre') ?></a>
                <a href="#"><?= t('footer.safety_tips') ?></a>
                <a href="#"><?= t('footer.contact') ?></a>
            </div>
            <div class="footer-col">
                <h4><?= t('footer.legal') ?></h4>
                <a href="#"><?= t('footer.terms') ?></a>
                <a href="#"><?= t('footer.privacy') ?></a>
                <a href="#"><?= t('footer.cookies') ?></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> Vuka. <?= t('footer.copyright') ?></span>
    </div>
</footer>
