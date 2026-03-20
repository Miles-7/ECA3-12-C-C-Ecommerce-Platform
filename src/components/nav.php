<?php
// Navigation component 
// When icons in the navbar are clicked, the url query string will be changed accordingly with the parameters provided
// The provided parameters will then be retrieved in index.php and the requested page will be injected
?>


<link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">

<div class="main-nav">

    <a href='?page=home'> <img src='../public/images/vuka1.png' id="logo"> </a>

    <div class="nav-item nav-search">


        <input type="search" placeholder=" Search for products" id="search-bar">
        <button id="search-btn"><img src="../public/svgs/search-line.svg" width='18' height='18'> </button>

    </div>

    <div class="nav-item">
        <button id="sell-btn"> Sell Now</button>
    </div>

    <div class="nav-item">
        <a href="?page=profile"> <img src="../public/svgs/user-3-line.svg" width='24' height='24'> </a>
        <a href="?page=liked"> <img src="../public/svgs/heart-line.svg" width='24' height='24'></a>
        <div class="lang">
            <a> <img src="../public/svgs/global-line.svg" width='16' height='16'></a>
        </div>
    </div>

</div>