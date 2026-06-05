<?php

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $host   = "localhost";
    $dbname = "vuka_db";
    $user   = "root";
    $pass   = "";
} else {
    $host   = "fdb1032.awardspace.net";
    $dbname = "4765427_vuka";
    $user   = "4765427_vuka";
    $pass   = "HondaXr1622";
}

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
