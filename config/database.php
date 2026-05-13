<?php

$host   = "localhost";
$dbname = "vuka_db";    // your database name in phpMyAdmin
$user   = "root";
$pass   = "";           // blank by default on XAMPP

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
