<?php
/**
 * Main Navigation Component
 */
?>
<nav class="main-nav" id="main-nav">
    <ul class="nav-list">
        <li><a href="/index.php" class="nav-link">Home</a></li>
        <li><a href="/pages/products.php" class="nav-link">Browse</a></li>
        
        <!-- Categories Dropdown -->
        <li class="dropdown">
            <a href="#" class="nav-link">Categories <i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-menu">
                <a href="/pages/products.php?category=electronics">Electronics</a>
                <a href="/pages/products.php?category=clothing">Clothing & Fashion</a>
                <a href="/pages/products.php?category=home">Home & Garden</a>
                <a href="/pages/products.php?category=beauty">Beauty & Health</a>
                <a href="/pages/products.php?category=toys">Toys & Kids</a>
                <a href="/pages/products.php?category=sports">Sports & Outdoors</a>
                <a href="/pages/products.php?category=books">Books & Media</a>
                <a href="/pages/products.php?category=other">Other</a>
            </div>
        </li>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="/pages/sell.php" class="nav-link btn-sell">
                <i class="fas fa-plus-circle"></i> Sell Item
            </a></li>
        <?php endif; ?>
        
        <li><a href="/pages/how-it-works.php" class="nav-link">How It Works</a></li>
        <li><a href="/pages/contact.php" class="nav-link">Contact</a></li>
    </ul>
</nav>