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
$stars     = (int)($data['stars']     ?? 0);

if (empty($listingID) || $stars < 1 || $stars > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid rating data']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// Fetch the listing to get the sellerID
$stmt = $db->prepare('SELECT sellerID FROM listing WHERE listingID = :id AND status = "active"');
$stmt->execute([':id' => $listingID]);
$listing = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    echo json_encode(['success' => false, 'message' => 'Listing not found']);
    exit;
}

$buyerID  = $_SESSION['user_id'];
$sellerID = $listing['sellerID'];

if ($buyerID === $sellerID) {
    echo json_encode(['success' => false, 'message' => 'You cannot rate your own listing']);
    exit;
}

// Generate UUID
$bytes    = random_bytes(16);
$bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
$bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
$ratingID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

try {
    $db->beginTransaction();

    // Insert the rating (unique key prevents duplicates)
    $stmt = $db->prepare(
        'INSERT INTO rating (ratingID, listingID, sellerID, buyerID, stars)
         VALUES (:ratingID, :listingID, :sellerID, :buyerID, :stars)'
    );
    $stmt->execute([
        ':ratingID'  => $ratingID,
        ':listingID' => $listingID,
        ':sellerID'  => $sellerID,
        ':buyerID'   => $buyerID,
        ':stars'     => $stars,
    ]);

    // Recalculate and update the seller's average rating
    $stmt = $db->prepare(
        'UPDATE user SET rating = (
            SELECT ROUND(AVG(stars), 2) FROM rating WHERE sellerID = :sellerID
         ) WHERE userID = :sellerID'
    );
    $stmt->execute([':sellerID' => $sellerID]);

    $db->commit();

    echo json_encode(['success' => true, 'message' => 'Rating submitted']);
} catch (PDOException $e) {
    $db->rollBack();
    if ($e->getCode() == 23000) {
        echo json_encode(['success' => false, 'message' => 'You have already rated this listing']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit rating: ' . $e->getMessage()]);
    }
}
