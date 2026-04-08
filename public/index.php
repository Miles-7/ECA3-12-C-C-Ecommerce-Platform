<?php

// Entry point of the application
// This file assembles the page using components
session_start();
if (!isset($_SESSION['user_id'])) {
    // use relative path, not absolute path when redirecting!
    header('Location: pages/register.php');
    exit;
}



// Read which page is requested, if the page is invalid then set the value to home
$page = $_GET['page'] ?? 'home';

// For security purposes, a whitelist of the allowed pages
$allowed_pages = ['home', 'profile', 'liked', 'sell'];

// check if the provided page via user input is in fact in the array of allowed pages
if (!in_array($page, $allowed_pages)) {
    $page = 'home'; // redirect back to home 
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>

    <!-- Main stylesheet -->
    <link rel="stylesheet" href="styling/main.css">
</head>

<body>

    <?php
    // inject my header component 
    require __DIR__ . '/../src/components/header.php';
    ?>

    <main>
        <?php

        # using a switch case to inject the selected page in the navbar after retrieving it from the url query string 
        switch ($page) {
            case "profile":
                require __DIR__ . '/pages/profile.php';
                break;

            case "sell":
                require __DIR__ . '/pages/sell.php';
                break;

            case "liked":
                require __DIR__ . '/pages/liked.php';
                break;

            case "profile":
                require __DIR__ . '/pages/profile.php';
                break;

            case "home":
                require __DIR__ . '/pages/home.php';
                break;
        }

        ?>

    </main>

</body>

</html>