<?php
// first pull in database connection
require_once '../database.php';

//sql query to create table
$sql = "CREATE TABLE IF NOT EXISTS users(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP)";

try {
    $db->exec($sql);
    echo "Users table created successfully!";
} catch(PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}

?>


