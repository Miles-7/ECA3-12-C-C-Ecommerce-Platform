<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];

if (empty($data)) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

$listingID          = trim($data['listingID']          ?? '');
$listingTitle       = trim($data['listingTitle']       ?? '');
$listingPrice       = trim($data['listingPrice']       ?? '');
$listingCategory    = trim($data['listingCategory']    ?? '');
$listingCondition   = trim($data['listingCondition']   ?? '');
$listingDescription = trim($data['listingDescription'] ?? '');
$listingLocation    = trim($data['listingLocation']    ?? '');
$listingPhoneNum    = trim($data['listingPhoneNum']    ?? '');

if (empty($listingID)) {
    echo json_encode(['success' => false, 'message' => 'Missing listing ID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

try {
    $stmt = $db->prepare(
        'UPDATE listing
         SET title = :title, price = :price, category = :category,
             itemCondition = :condition, description = :description,
             location = :location, phoneNum = :phoneNum,
             status = "active"
         WHERE listingID = :id AND sellerID = :sellerID'
    );
    $stmt->execute([
        ':title'       => $listingTitle,
        ':price'       => $listingPrice,
        ':category'    => $listingCategory,
        ':condition'   => $listingCondition,
        ':description' => $listingDescription,
        ':location'    => $listingLocation,
        ':phoneNum'    => $listingPhoneNum,
        ':id'          => $listingID,
        ':sellerID'    => $_SESSION['user_id']
    ]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
