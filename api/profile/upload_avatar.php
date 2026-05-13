<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No file received']);
    exit;
}



$file          = $_FILES['avatar'];
$allowedTypes  = ['image/jpeg', 'image/png', 'image/webp'];
$maxSize       = 5 * 1024 * 1024; // 5 MB

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Only JPG, PNG and WEBP images are allowed']);
    exit;
}

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File too large — maximum 5 MB']);
    exit;
}

$ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // see if the file is jpeg, png or webp
$filename  = $_SESSION['user_id'] . '.' . $ext;   // the file name will be the userID.extension  
$uploadDir = __DIR__ . '/../../public/uploads/avatars/';   // the dir to where the files will be uploaded 

if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare('UPDATE user SET profile_upload = :pic WHERE userID = :id');
$stmt->execute([':pic' => $filename, ':id' => $_SESSION['user_id']]);

echo json_encode(['success' => true, 'filename' => $filename]);
