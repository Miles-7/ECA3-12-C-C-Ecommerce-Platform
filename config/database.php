<?php

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $host   = "localhost";
    $dbname = "vuka_db";
    $user   = "root";
    $pass   = "";
} else {
    $host   = "sql109.infinityfree.com";
    $dbname = "if0_42090951_vuka_db";
    $user   = "if0_42090951";
    $pass   = "HondaXr1622";
}

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
