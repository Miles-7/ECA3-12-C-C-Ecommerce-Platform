<?php

$host   = "sql109.infinityfree.com";
$dbname = "if0_42090951_vuka_db";    // my database's name in phpMyAdmin
$user   = "if0_42090951";
$pass   = "HondaXr1622";

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
