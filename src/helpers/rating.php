<?php

function renderStars(?float $rating): void {
    if ($rating === null) {
        echo '<i class="ri-star-line"></i><i class="ri-star-line"></i><i class="ri-star-line"></i>'
           . '<i class="ri-star-line"></i><i class="ri-star-line"></i>'
           . '<span>No ratings</span>';
        return;
    }

    // Round to nearest 0.5 for visual display
    $rounded = round($rating * 2) / 2;
    $full    = (int) floor($rounded);
    $half    = ($rounded - $full) >= 0.5;
    $empty   = 5 - $full - ($half ? 1 : 0);

    for ($i = 0; $i < $full;  $i++) echo '<i class="ri-star-fill"></i>';
    if ($half)                        echo '<i class="ri-star-half-line"></i>';
    for ($i = 0; $i < $empty; $i++) echo '<i class="ri-star-line"></i>';

    echo '<span>' . number_format($rating, 1) . ' / 5</span>';
}
