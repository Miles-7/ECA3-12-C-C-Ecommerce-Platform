<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/main.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <title>Sell Page</title>
</head>

<body id="sell-body">

    <div class="sell_hero_container">
        <div id="sell_hero"><?= t('sell.hero') ?></div>
        <div id="sell_subhero"><?= t('sell.subhero') ?></div>
    </div>

    <div class="item_upload_container">

        <!-- Left: photo upload + listing form -->
        <div class="sell-left">

            <div class="photos-section">
                <label class="photos-label"><?= t('sell.photos_label') ?> <span class="required">*</span></label>
                <p class="photos-hint"><?= t('sell.photos_hint') ?></p>

                <div class="drop-zone" id="dropZone">
                    <input type="file" id="fileInput" accept="image/*" multiple>
                    <div class="drop-zone-content">
                        <i class="ri-camera-line"></i>
                        <p class="drop-main"><?= t('sell.drop_main') ?></p>
                        <p class="drop-sub"><?= t('sell.drop_sub') ?></p>
                    </div>
                </div>

                <div class="preview-grid" id="previewGrid"></div>
            </div>

            <form class="sell-form" method="post" action="">

                <div class="sell-field">
                    <label for="item-title"><?= t('sell.title_label') ?> <span class="required">*</span></label>
                    <input class="sell-input" type="text" id="item-title" name="title"
                        placeholder="<?= t('sell.title_placeholder') ?>" required>
                </div>

                <div class="sell-field">
                    <label for="item-description"><?= t('sell.description_label') ?> <span class="required">*</span></label>
                    <textarea class="sell-textarea" id="item-description" name="description"
                        placeholder="<?= t('sell.description_placeholder') ?>" required></textarea>
                </div>

                <div class="sell-row">
                    <div class="sell-field">
                        <label for="item-category"><?= t('sell.category_label') ?> <span class="required">*</span></label>
                        <select class="sell-select" id="item-category" name="category" required>
                            <option value="" disabled selected><?= t('sell.category_default') ?></option>
                            <option value="electronics"><?= t('sell.cat_electronics') ?></option>
                            <option value="clothing"><?= t('sell.cat_clothing') ?></option>
                            <option value="home"><?= t('sell.cat_home') ?></option>
                            <option value="vehicles"><?= t('sell.cat_vehicles') ?></option>
                            <option value="furniture"><?= t('sell.cat_furniture') ?></option>
                            <option value="books"><?= t('sell.cat_books') ?></option>
                            <option value="sports"><?= t('sell.cat_sports') ?></option>
                            <option value="baby"><?= t('sell.cat_baby') ?></option>
                            <option value="other"><?= t('sell.cat_other') ?></option>
                        </select>
                    </div>

                    <div class="sell-field">
                        <label for="item-condition"><?= t('sell.condition_label') ?> <span class="required">*</span></label>
                        <select class="sell-select" id="item-condition" name="condition" required>
                            <option value="" disabled selected><?= t('sell.condition_default') ?></option>
                            <option value="new"><?= t('sell.cond_new') ?></option>
                            <option value="like_new"><?= t('sell.cond_like_new') ?></option>
                            <option value="good"><?= t('sell.cond_good') ?></option>
                            <option value="fair"><?= t('sell.cond_fair') ?></option>
                            <option value="parts"><?= t('sell.cond_parts') ?></option>
                        </select>
                    </div>
                </div>

                <div class="sell-row">
                    <div class="sell-field">
                        <label for="item-price"><?= t('sell.price_label') ?> <span class="required">*</span></label>
                        <div class="price-wrapper">
                            <span class="price-prefix">R</span>
                            <input class="sell-input" type="number" id="item-price" name="price"
                                placeholder="<?= t('sell.price_placeholder') ?>" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="sell-field">
                        <label for="item-location"><?= t('sell.location_label') ?> <span class="required">*</span></label>
                        <input class="sell-input" type="text" id="item-location" name="location"
                            placeholder="<?= t('sell.location_placeholder') ?>" required>
                    </div>
                </div>

                <div class="sell-field">
                    <label for="item-phone">
                        <?= t('sell.phone_label') ?>
                        <span class="optional">(<?= t('sell.phone_optional') ?>)</span>
                    </label>
                    <input class="sell-input" type="tel" id="item-phone" name="phone"
                        placeholder="<?= t('sell.phone_placeholder') ?>">
                </div>

                <button type="submit" class="sell-submit"><?= t('sell.submit_btn') ?></button>

            </form>
        </div>

        <!-- Right col row 1: selling tips -->
        <div class="sell-right">
            <div class="tips-card">
                <div class="tips-header">
                    <i class="ri-shield-check-line"></i>
                    <h2><?= t('sell.tips_title') ?></h2>
                </div>
                <ul class="tips-list">
                    <li><i class="ri-camera-line"></i><?= t('sell.tip_1') ?></li>
                    <li><i class="ri-price-tag-3-line"></i><?= t('sell.tip_2') ?></li>
                    <li><i class="ri-check-double-line"></i><?= t('sell.tip_3') ?></li>
                    <li><i class="ri-message-3-line"></i><?= t('sell.tip_4') ?></li>
                    <li><i class="ri-map-pin-line"></i><?= t('sell.tip_5') ?></li>
                </ul>
            </div>
        </div>

        <!-- Right col row 2: safety reminders -->
        <div class="safety-reminders">
            <div class="safety-card">
                <div class="tips-header">
                    <i class="ri-error-warning-line"></i>
                    <h2><?= t('sell.safety_title') ?></h2>
                </div>
                <ul class="tips-list">
                    <li><i class="ri-bank-card-line"></i><?= t('sell.safety_1') ?></li>
                    <li><i class="ri-secure-payment-line"></i><?= t('sell.safety_2') ?></li>
                    <li><i class="ri-map-pin-2-line"></i><?= t('sell.safety_3') ?></li>
                    <li><i class="ri-group-line"></i><?= t('sell.safety_4') ?></li>
                    <li><i class="ri-alert-line"></i><?= t('sell.safety_5') ?></li>
                </ul>
            </div>
        </div>

    </div>

    <script>
        const MAX_PHOTOS = 5;
        let photos = [];

        const dropZone   = document.getElementById('dropZone');
        const fileInput  = document.getElementById('fileInput');
        const previewGrid = document.getElementById('previewGrid');

        // ── Initial drop zone ────────────────────────────────────────
        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', e => {
            addFiles(Array.from(e.target.files));
            fileInput.value = '';
        });

        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const images = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            addFiles(images);
        });

        // ── Core logic ───────────────────────────────────────────────
        function addFiles(files) {
            const slots = MAX_PHOTOS - photos.length;
            photos = [...photos, ...files.slice(0, slots)];
            render();
        }

        function removePhoto(index) {
            URL.revokeObjectURL(photos[index]._objectURL);
            photos.splice(index, 1);
            render();
        }

        function render() {
            previewGrid.innerHTML = '';

            if (photos.length === 0) {
                previewGrid.style.display = 'none';
                dropZone.style.display    = '';
                return;
            }

            previewGrid.style.display = 'flex';
            dropZone.style.display    = 'none';

            photos.forEach((file, i) => {
                // reuse or create object URL
                if (!file._objectURL) file._objectURL = URL.createObjectURL(file);

                const item = document.createElement('div');
                item.className = 'preview-item';

                const img = document.createElement('img');
                img.src = file._objectURL;
                img.alt = file.name;
                item.appendChild(img);

                if (i === 0) {
                    const badge = document.createElement('span');
                    badge.className = 'cover-badge';
                    badge.textContent = 'Cover';
                    item.appendChild(badge);
                }

                const removeBtn = document.createElement('button');
                removeBtn.type      = 'button';
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', () => removePhoto(i));
                item.appendChild(removeBtn);

                previewGrid.appendChild(item);
            });

            // "Add more" tile — only shown when under the limit
            if (photos.length < MAX_PHOTOS) {
                const tile = document.createElement('div');
                tile.className = 'add-more-tile';

                const icon = document.createElement('i');
                icon.className = 'ri-add-line';
                tile.appendChild(icon);

                const label = document.createElement('span');
                label.textContent = 'Add more';
                tile.appendChild(label);

                const moreInput = document.createElement('input');
                moreInput.type     = 'file';
                moreInput.accept   = 'image/*';
                moreInput.multiple = true;
                moreInput.addEventListener('change', e => {
                    addFiles(Array.from(e.target.files));
                    moreInput.value = '';
                });
                tile.appendChild(moreInput);

                previewGrid.appendChild(tile);
            }
        }
    </script>

</body>

</html>
