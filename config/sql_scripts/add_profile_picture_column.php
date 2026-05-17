<?php

require_once __DIR__ . '/../database.php';

$columns = array_column(
    $db->query('PRAGMA table_info(users)')->fetchAll(),
    'name'
);

if (!in_array('profile_picture', $columns)) {
    $db->exec('ALTER TABLE users ADD COLUMN profile_picture TEXT DEFAULT NULL');
    echo 'profile_picture column added.';
} else {
    echo 'Column already exists — nothing to do.';
}
