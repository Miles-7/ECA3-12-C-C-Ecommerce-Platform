
 <?php
// Entry point of the application
// This file assembles the page using components
session_start();
if(!isset($_SESSION['user_id'])){
    // use relative path, not absolute path when redirecting!
    header('Location: pages/register.php');
    exit;

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
    <h2> Welcome </h2>
    
</main>

</body>
</html>