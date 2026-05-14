<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data      = json_decode(file_get_contents('php://input'), true) ?? [];
$listingID = trim($data['listingID'] ?? '');

if (empty($listingID)) {
    echo json_encode(['success' => false, 'message' => 'No listing ID parsed']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// Fetch listing price and seller
$stmt = $db->prepare('SELECT price, sellerID FROM listing WHERE listingID = :id AND status = "active"');
$stmt->execute([':id' => $listingID]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    echo json_encode(['success' => false, 'message' => 'Listing not found or no longer available']);
    exit;
}

$buyerID  = $_SESSION['user_id'];
$sellerID = $listing['sellerID'];
$amount   = (float)$listing['price'];

if ($buyerID === $sellerID) {
    echo json_encode(['success' => false, 'message' => 'You cannot purchase your own listing']);
    exit;
}

// Check buyer balance
$stmt = $db->prepare('SELECT balance FROM user WHERE userID = :id');
$stmt->execute([':id' => $buyerID]);
$buyer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buyer || (float)$buyer['balance'] < $amount) {
    echo json_encode(['success' => false, 'message' => 'Insufficient balance']);
    exit;
}

// Generate UUID for order
$bytes    = random_bytes(16);
$bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
$bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
$orderID  = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

try {
    $db->beginTransaction();

    // Deduct from buyer (funds held implicitly in the order record until delivery confirmed)
    $stmt = $db->prepare('UPDATE user SET balance = balance - :amount WHERE userID = :id');
    $stmt->execute([':amount' => $amount, ':id' => $buyerID]);

    // Create order record
    $stmt = $db->prepare(
        'INSERT INTO orders (orderID, listingID, sellerID, buyerID, amount, status)
         VALUES (:orderID, :listingID, :sellerID, :buyerID, :amount, "paid")'
    );
    $stmt->execute([
        ':orderID'   => $orderID,
        ':listingID' => $listingID,
        ':sellerID'  => $sellerID,
        ':buyerID'   => $buyerID,
        ':amount'    => $amount,
    ]);

    // Mark listing as sold so it no longer appears in active listings
    $stmt = $db->prepare('UPDATE listing SET status = "sold" WHERE listingID = :id');
    $stmt->execute([':id' => $listingID]);

    $db->commit();

    echo json_encode(['success' => true, 'message' => 'Purchase successful', 'orderID' => $orderID]);
} catch (PDOException $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => 'Purchase failed: ' . $e->getMessage()]);
}
