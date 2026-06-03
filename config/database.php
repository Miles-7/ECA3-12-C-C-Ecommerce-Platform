<?php

$host   = "localhost";
$dbname = "vuka_db";    // my database's name in phpMyAdmin
$user   = "root";
$pass   = "";

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
