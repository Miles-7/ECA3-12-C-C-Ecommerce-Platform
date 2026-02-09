<?php
/**
 * Site Header Component
 * Includes navigation and user menu
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buy and sell in your community - South African C2C Marketplace">
    <title><?php echo isset($page_title) ? $page_title : 'SA Marketplace'; ?></title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/styling/main.css">
    <link rel="stylesheet" href="/styling/responsive.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Font Awesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span><i class="fas fa-phone"></i> Support: 0800 123 456</span>
                    <span><i class="fas fa-envelope"></i> help@samarketplace.co.za</span>
                </div>
                <div class="top-bar-right">
                    <!-- Language Selector -->
                    <select id="language-selector" onchange="changeLanguage(this.value)">
                        <option value="en" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') ? 'selected' : ''; ?>>English</option>
                        <option value="zu" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'zu') ? 'selected' : ''; ?>>isiZulu</option>
                        <option value="xh" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'xh') ? 'selected' : ''; ?>>isiXhosa</option>
                        <option value="af" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'af') ? 'selected' : ''; ?>>Afrikaans</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="/index.php">
                        <img src="/assets/images/logo.png" alt="SA Marketplace" height="50">
                    </a>
                </div>

                <!-- Navigation -->
                <?php include __DIR__ . '/nav.php'; ?>

                <!-- User Menu -->
                <div class="user-menu">
                    <?php if ($is_logged_in): ?>
                        <!-- Logged In User -->
                        <a href="/pages/cart.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count" id="cart-count">0</span>
                        </a>
                        
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user-circle"></i>
                                <span><?php echo htmlspecialchars($username); ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/pages/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                <a href="/pages/profile.php"><i class="fas fa-user"></i> My Profile</a>
                                <a href="/pages/my-listings.php"><i class="fas fa-list"></i> My Listings</a>
                                <a href="/pages/messages.php"><i class="fas fa-envelope"></i> Messages</a>
                                <a href="/pages/orders.php"><i class="fas fa-box"></i> Orders</a>
                                <hr>
                                <a href="/pages/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Guest User -->
                        <a href="/pages/login.php" class="btn-secondary">Login</a>
                        <a href="/pages/register.php" class="btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <main class="main-content">