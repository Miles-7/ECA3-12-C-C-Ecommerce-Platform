<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');



// check for user ID to confirm the user is authenticated
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}


// JSON format to send the data, now decode with json_decode !!!!!!!!!!!   ALWAYS DECODE IF ENCODED WITH JSON 
$data      = json_decode(file_get_contents('php://input'), true) ?? [];
$listingID = trim($data['listingID'] ?? '');

if (!$listingID) {
    echo json_encode(['success' => false, 'message' => 'No listingID found']);
    exit;
}



// require db to fetch all relevant listing info from db 
require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare('SELECT * FROM listing WHERE listingID = :id AND sellerID = :sellerID');
$stmt->execute([':id' => $listingID, ':sellerID' => $_SESSION['user_id']]);
$listingInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listingInfo) {
    echo json_encode(['success' => false, 'message' => 'No listing found']);
    exit;
}

$imgStmt = $db->prepare(
    'SELECT filename, sortOrder FROM listing_images WHERE listingID = :id ORDER BY sortOrder ASC'
);
$imgStmt->execute([':id' => $listingID]);
$images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'listingInfo' => $listingInfo, 'images' => $images]);
