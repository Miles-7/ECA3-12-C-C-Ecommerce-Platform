<?php
// Navigation component 
// When icons in the navbar are clicked, the url query string will be changed accordingly with the parameters provided
// The provided parameters will then be retrieved in index.php and the requested page will be injected
//
?>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">

<div class="main-nav">

    <a href='?page=home'> <img src='../public/images/logo2.png' id="logo"> </a>

    <div class="nav-item nav-search">
        <input type="search" placeholder=" Search for products" id="search-bar">
        <button id="search-btn"><i class="ri-search-line"></i></button>
    </div>

    <div class="nav-item">
        <a href="?page=sell">
            <button id="sell-btn">Sell Now</button>
        </a>

    </div>

    <div class="nav-item nav-right">
        <a href="?page=profile"><i class="ri-user-3-line"></i></a>
        <a href="?page=liked"><i class="ri-heart-line"></i></a>
        <div class="lang">
            <label for="lang"><i class="ri-global-line"></i></label>

            </select>
        </div>
    </div>

</div>