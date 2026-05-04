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
        <div class="photos-section">
            <label class="photos-label"><?= t('sell.photos_label') ?> <span class="required">*</span></label>
            <p class="photos-hint"><?= t('sell.photos_hint') ?></p>

            <!-- Drop zone (visible when no images selected) -->
            <div class="drop-zone" id="dropZone">
                <input type="file" id="fileInput" accept="image/*" multiple>
                <div class="drop-zone-content">
                    <i class="ri-camera-line"></i>
                    <p class="drop-main"><?= t('sell.drop_main') ?></p>
                    <p class="drop-sub"><?= t('sell.drop_sub') ?></p>
                </div>
            </div>

            <!-- Preview grid (visible after images are selected) -->
            <div class="preview-grid" id="previewGrid"></div>
        </div>
        <div class="right-top">
            <i class="ri-shield-check-line"></i>
            <h2><?= t('sell.tips_title') ?></h2>
        </div>
        <div class="right-bottom">Bottom Right</div>
    </div>

</body>

</html>
