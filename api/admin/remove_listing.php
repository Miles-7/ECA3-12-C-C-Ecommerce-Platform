<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$data      = json_decode(file_get_contents('php://input'), true) ?? [];
$listingID = trim($data['listingID'] ?? '');

if (empty($listingID)) {
    echo json_encode(['success' => false, 'message' => 'Missing listingID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare('UPDATE listing SET status = "removed" WHERE listingID = :id');
$stmt->execute([':id' => $listingID]);

echo json_encode(['success' => true]);
