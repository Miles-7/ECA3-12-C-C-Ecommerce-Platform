<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data      = json_decode(file_get_contents('php://input'), true) ?? [];
$listingID = trim($data['listingID'] ?? '');

if (empty($listingID)) {
    echo json_encode(['success' => false, 'message' => 'Missing listing ID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare(
    'UPDATE listing SET status = "removed" WHERE listingID = :id AND sellerID = :sellerID'
);
$stmt->execute([':id' => $listingID, ':sellerID' => $_SESSION['user_id']]);

if ($stmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'message' => 'Listing not found or not yours']);
    exit;
}

echo json_encode(['success' => true]);
