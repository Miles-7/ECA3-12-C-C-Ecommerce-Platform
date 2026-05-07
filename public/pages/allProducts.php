<?php
// hard code for now till i start backend
$listings = [
    [
        'title'       => 'iPhone 13 Pro — 256GB Sierra Blue',
        'description' => 'Barely used, no scratches. Comes with original box, charger and two cases. Battery health at 97%.',
        'price'       => 8500,
        'condition'   => 'like_new',
        'category'    => 'electronics',
        'location'    => 'Cape Town, WC',
        'img_bg'      => '#D9C5B2',
        'img_icon'    => 'ri-smartphone-line',
    ],
    [
        'title'       => 'Vintage Leather 3-Seater Couch',
        'description' => 'Rich tan leather, minor wear on armrests. Solid hardwood frame. Bought in 2019, moving sale.',
        'price'       => 2200,
        'condition'   => 'good',
        'category'    => 'furniture',
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#C9B49A',
        'img_icon'    => 'ri-sofa-line',
    ],
    [
        'title'       => 'Trek Marlin 7 Mountain Bike — Medium',
        'description' => '29" wheels, hydraulic disc brakes, recently serviced. Great condition for trail or commuting.',
        'price'       => 3800,
        'condition'   => 'good',
        'category'    => 'sports',
        'location'    => 'Durban, KZN',
        'img_bg'      => '#B5C4B1',
        'img_icon'    => 'ri-riding-line',
    ],
    [
        'title'       => 'Canon EOS 90D + 18-55mm Kit Lens',
        'description' => 'Low shutter count (~4k), full HD video. Includes 2 batteries, 64 GB SD card and carry bag.',
        'price'       => 12000,
        'condition'   => 'like_new',
        'category'    => 'electronics',
        'location'    => 'Pretoria, GP',
        'img_bg'      => '#C4B8A8',
        'img_icon'    => 'ri-camera-3-line',
    ],
    [
        'title'       => 'Nike Air Max 90 — Size 10',
        'description' => 'Worn twice, basically new. All original packaging included. No scuffs or sole wear.',
        'price'       => 1200,
        'condition'   => 'like_new',
        'category'    => 'clothing',
        'location'    => 'Bloemfontein, FS',
        'img_bg'      => '#C8D4C0',
        'img_icon'    => 'ri-footprint-line',
    ],
    [
        'title'       => 'IKEA BILLY Bookcase — White',
        'description' => 'Solid condition, some minor shelf scuffs. All fittings included. Disassembled for easy transport.',
        'price'       => 450,
        'condition'   => 'good',
        'category'    => 'furniture',
        'location'    => 'Cape Town, WC',
        'img_bg'      => '#D8CFC7',
        'img_icon'    => 'ri-book-shelf-line',
    ],
    [
        'title'       => 'PlayStation 5 DualSense Controller',
        'description' => 'Midnight Black edition. Light use, triggers and haptics work perfectly. No stick drift.',
        'price'       => 800,
        'condition'   => 'good',
        'category'    => 'electronics',
        'location'    => 'Durban, KZN',
        'img_bg'      => '#BFC8D4',
        'img_icon'    => 'ri-gamepad-line',
    ],
    [
        'title'       => 'The Alchemist — Paulo Coelho',
        'description' => 'Paperback, read once. No highlights or writing inside. Great condition for a used book.',
        'price'       => 50,
        'condition'   => 'like_new',
        'category'    => 'books',
        'location'    => 'Johannesburg, GP',
        'img_bg'      => '#D4C9B8',
        'img_icon'    => 'ri-book-open-line',
    ],
];

$conditionLabels = [
    'new'      => t('sell.cond_new'),
    'like_new' => t('sell.cond_like_new'),
    'good'     => t('sell.cond_good'),
    'fair'     => t('sell.cond_fair'),
    'parts'    => t('sell.cond_parts'),
];

$categoryLabels = [
    'electronics' => t('sell.cat_electronics'),
    'clothing'    => t('sell.cat_clothing'),
    'home'        => t('sell.cat_home'),
    'vehicles'    => t('sell.cat_vehicles'),
    'furniture'   => t('sell.cat_furniture'),
    'books'       => t('sell.cat_books'),
    'sports'      => t('sell.cat_sports'),
    'baby'        => t('sell.cat_baby'),
    'other'       => t('sell.cat_other'),
];
?>

<!-- ── Browse by Category ──────────────────────────── -->
<section class="category-section">

    <h2 class="featured-title"><?= t('home.browse_category') ?></h2>

    <div class="category-grid">
        <a href="#" class="category-chip" data-filter-cat="electronics">
            <div class="chip-icon"><i class="ri-smartphone-line"></i></div>
            <span><?= t('sell.cat_electronics') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="clothing">
            <div class="chip-icon"><i class="ri-shirt-line"></i></div>
            <span><?= t('sell.cat_clothing') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="home">
            <div class="chip-icon"><i class="ri-home-3-line"></i></div>
            <span><?= t('sell.cat_home') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="vehicles">
            <div class="chip-icon"><i class="ri-car-line"></i></div>
            <span><?= t('sell.cat_vehicles') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="furniture">
            <div class="chip-icon"><i class="ri-sofa-line"></i></div>
            <span><?= t('sell.cat_furniture') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="books">
            <div class="chip-icon"><i class="ri-book-open-line"></i></div>
            <span><?= t('sell.cat_books') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="sports">
            <div class="chip-icon"><i class="ri-football-line"></i></div>
            <span><?= t('sell.cat_sports') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="baby">
            <div class="chip-icon"><i class="ri-bear-smile-line"></i></div>
            <span><?= t('sell.cat_baby') ?></span>
        </a>
        <a href="#" class="category-chip" data-filter-cat="other">
            <div class="chip-icon"><i class="ri-apps-2-line"></i></div>
            <span><?= t('sell.cat_other') ?></span>
        </a>
    </div>

</section>

<!-- ── All Listings ─────────────────────────────────── -->
<section class="featured-section">

    <!-- Title row -->
    <div class="all-listings-header">
        <div class="all-listings-title-row">
            <h2 class="featured-title"><?= t('home.all_listings') ?></h2>
            <span class="results-count" id="resultsCount">
                <?= count($listings) ?> <?= t('filter.results') ?>
            </span>
        </div>

        <!-- Filter bar -->
        <div class="filter-bar">

            <div class="filter-group">
                <label class="filter-label"><?= t('sell.category_label') ?></label>
                <select class="filter-select" id="filterCategory">
                    <option value=""><?= t('filter.any_category') ?></option>
                    <?php foreach ($categoryLabels as $val => $label): ?>
                        <option value="<?= $val ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label"><?= t('sell.condition_label') ?></label>
                <select class="filter-select" id="filterCondition">
                    <option value=""><?= t('filter.any_condition') ?></option>
                    <?php foreach ($conditionLabels as $val => $label): ?>
                        <option value="<?= $val ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label"><?= t('sell.price_label') ?></label>
                <div class="filter-price-range">
                    <input class="filter-input filter-price" type="number"
                        id="filterPriceMin" placeholder="<?= t('filter.price_min') ?>" min="0">
                    <span class="price-range-sep">–</span>
                    <input class="filter-input filter-price" type="number"
                        id="filterPriceMax" placeholder="<?= t('filter.price_max') ?>" min="0">
                </div>
            </div>

            <div class="filter-group">
                <label class="filter-label"><?= t('sell.location_label') ?></label>
                <input class="filter-input" type="text" id="filterLocation"
                    placeholder="<?= t('sell.location_placeholder') ?>">
            </div>

            <button class="filter-clear" id="filterClear" type="button">
                <i class="ri-close-line"></i> <?= t('filter.clear') ?>
            </button>

        </div>
    </div>

    <!-- Listings grid -->
    <div class="listing-grid" id="listingsGrid">
        <?php foreach ($listings as $item): ?>
            <div class="product-card"
                data-category="<?= $item['category'] ?>"
                data-condition="<?= $item['condition'] ?>"
                data-price="<?= $item['price'] ?>"
                data-location="<?= htmlspecialchars($item['location']) ?>"
                data-search="<?= htmlspecialchars(strtolower($item['title'] . ' ' . $item['description'])) ?>"
                data-img-bg="<?= $item['img_bg'] ?>"
                data-img-icon="<?= $item['img_icon'] ?>">

                <div class="card-img" style="background-color: <?= $item['img_bg'] ?>">
                    <i class="<?= $item['img_icon'] ?>"></i>
                    <span class="card-condition"><?= $conditionLabels[$item['condition']] ?></span>
                </div>

                <div class="card-body">
                    <div class="card-meta">
                        <span class="card-category"><?= $categoryLabels[$item['category']] ?></span>
                        <span class="card-location">
                            <i class="ri-map-pin-2-line"></i><?= $item['location'] ?>
                        </span>
                    </div>

                    <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="card-desc"><?= htmlspecialchars($item['description']) ?></p>

                    <div class="card-footer">
                        <span class="card-price">R <?= number_format($item['price'], 0, '.', ' ') ?></span>
                        <button class="card-btn"><?= t('home.view_listing') ?></button>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty state when no results match -->
    <div class="filter-no-results" id="filterNoResults" style="display:none;">
        <i class="ri-search-2-line"></i>
        <p><?= t('filter.no_results') ?></p>
        <button class="filter-clear-inline" id="filterClearInline" type="button">
            <?= t('filter.clear') ?>
        </button>
    </div>

</section>

<script>
    const cards     = Array.from(document.querySelectorAll('#listingsGrid .product-card'));
    const countEl   = document.getElementById('resultsCount');
    const noResults = document.getElementById('filterNoResults');

    const fCat      = document.getElementById('filterCategory');
    const fCond     = document.getElementById('filterCondition');
    const fPriceMin = document.getElementById('filterPriceMin');
    const fPriceMax = document.getElementById('filterPriceMax');
    const fLoc      = document.getElementById('filterLocation');

    let activeSearch = '';

    function applyFilters() {
        const cat      = fCat.value;
        const cond     = fCond.value;
        const priceMin = fPriceMin.value !== '' ? parseFloat(fPriceMin.value) : null;
        const priceMax = fPriceMax.value !== '' ? parseFloat(fPriceMax.value) : null;
        const loc      = fLoc.value.trim().toLowerCase();
        const q        = activeSearch.toLowerCase();

        let visible = 0;

        cards.forEach(card => {
            const match =
                (!cat      || card.dataset.category  === cat)  &&
                (!cond     || card.dataset.condition  === cond) &&
                (priceMin === null || parseFloat(card.dataset.price) >= priceMin) &&
                (priceMax === null || parseFloat(card.dataset.price) <= priceMax) &&
                (!loc      || card.dataset.location.includes(loc)) &&
                (!q        || card.dataset.search.includes(q));

            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        countEl.textContent     = visible + ' <?= t('filter.results') ?>';
        noResults.style.display = visible === 0 ? 'flex' : 'none';
    }

    // Called by the nav search bar when already on this page
    function applySearch(q) {
        activeSearch = q;
        document.getElementById('search-bar').value = q;
        applyFilters();
    }

    function clearFilters() {
        fCat.value = fCond.value = fLoc.value = fPriceMin.value = fPriceMax.value = '';
        activeSearch = '';
        document.getElementById('search-bar').value = '';
        document.querySelectorAll('.category-chip').forEach(c => c.classList.remove('chip-active'));
        applyFilters();
    }

    // Live filtering on filter bar inputs
    [fCat, fCond, fPriceMin, fPriceMax].forEach(el => el.addEventListener('change', applyFilters));
    fLoc.addEventListener('input', applyFilters);

    document.getElementById('filterClear').addEventListener('click', clearFilters);
    document.getElementById('filterClearInline').addEventListener('click', clearFilters);

    // Category chips wire up to the filter select
    document.querySelectorAll('.category-chip[data-filter-cat]').forEach(chip => {
        chip.addEventListener('click', function (e) {
            e.preventDefault();
            const val = this.dataset.filterCat;
            document.querySelectorAll('.category-chip').forEach(c => c.classList.remove('chip-active'));
            if (fCat.value === val) {
                fCat.value = '';
            } else {
                fCat.value = val;
                this.classList.add('chip-active');
            }
            applyFilters();
        });
    });

    // On page load: apply any URL params (search query or category filter)
    (function () {
        const params = new URLSearchParams(window.location.search);

        const q = params.get('q');
        if (q) applySearch(decodeURIComponent(q));

        const cat = params.get('cat');
        if (cat) {
            fCat.value = cat;
            const activeChip = document.querySelector(`.category-chip[data-filter-cat="${cat}"]`);
            if (activeChip) activeChip.classList.add('chip-active');
            applyFilters();
        }
    })();
</script>