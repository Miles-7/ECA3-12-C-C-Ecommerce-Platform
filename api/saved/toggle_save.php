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
    echo json_encode(['success' => false, 'message' => 'Missing listing ID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$buyerID = $_SESSION['user_id'];

// Check if already saved
$stmt = $db->prepare('SELECT 1 FROM saved WHERE buyerID = :bid AND listingID = :lid');
$stmt->execute([':bid' => $buyerID, ':lid' => $listingID]);
$alreadySaved = (bool)$stmt->fetchColumn();

try {
    $db->beginTransaction();

    if ($alreadySaved) {
        $stmt = $db->prepare('DELETE FROM saved WHERE buyerID = :bid AND listingID = :lid');
        $stmt->execute([':bid' => $buyerID, ':lid' => $listingID]);

        // GREATEST(0, ...) guards against the count going negative
        $stmt = $db->prepare('UPDATE buyer SET savedCount = GREATEST(0, savedCount - 1) WHERE userID = :id');
        $stmt->execute([':id' => $buyerID]);

        $saved = false;
    } else {
        $stmt = $db->prepare('INSERT INTO saved (buyerID, listingID) VALUES (:bid, :lid)');
        $stmt->execute([':bid' => $buyerID, ':lid' => $listingID]);

        $stmt = $db->prepare('UPDATE buyer SET savedCount = savedCount + 1 WHERE userID = :id');
        $stmt->execute([':id' => $buyerID]);

        $saved = true;
    }

    $db->commit();

    echo json_encode(['success' => true, 'saved' => $saved]);
} catch (PDOException $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed: ' . $e->getMessage()]);
}
