<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$data   = json_decode(file_get_contents('php://input'), true) ?? [];
$userID = trim($data['userID'] ?? '');

if (empty($userID)) {
    echo json_encode(['success' => false, 'message' => 'Missing userID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// Fetch current status
$stmt = $db->prepare('SELECT accountStatus FROM user WHERE userID = :id AND role = "user"');
$stmt->execute([':id' => $userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

$newStatus = $user['accountStatus'] === 'ban' ? 'active' : 'ban';

$stmt = $db->prepare('UPDATE user SET accountStatus = :status WHERE userID = :id');
$stmt->execute([':status' => $newStatus, ':id' => $userID]);

echo json_encode(['success' => true, 'newStatus' => $newStatus]);
