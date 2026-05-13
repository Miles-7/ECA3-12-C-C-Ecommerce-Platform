<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data  = json_decode(file_get_contents('php://input'), true) ?? [];
$name  = trim($data['name']  ?? '');
$email = trim($data['email'] ?? '');

if (empty($name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Name and email are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// check email isn't taken by a different account
$stmt = $db->prepare('SELECT userID FROM user WHERE email = :email AND userID != :id');
$stmt->execute([':email' => $email, ':id' => $_SESSION['user_id']]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'That email address is already in use']);
    exit;
}

$stmt = $db->prepare('UPDATE user SET username = :name, email = :email WHERE userID = :id');
$stmt->execute([':name' => $name, ':email' => $email, ':id' => $_SESSION['user_id']]);

$_SESSION['user_name']  = $name;
$_SESSION['user_email'] = $email;

echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
