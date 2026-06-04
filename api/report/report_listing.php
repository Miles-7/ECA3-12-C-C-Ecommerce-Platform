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
$reason    = trim($data['reason']    ?? '');

$allowedReasons = ['spam', 'counterfeit', 'inappropriate', 'scam', 'other'];

if (empty($listingID)) {
    echo json_encode(['success' => false, 'message' => 'Missing listing ID']);
    exit;
}

if (!in_array($reason, $allowedReasons)) {
    echo json_encode(['success' => false, 'message' => 'Invalid reason']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

function generateUUID(): string {
    $bytes    = random_bytes(16);
    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

try {
    $stmt = $db->prepare(
        'INSERT INTO report (reportID, listingID, reporterID, reason)
         VALUES (:reportID, :listingID, :reporterID, :reason)'
    );
    $stmt->execute([
        ':reportID'   => generateUUID(),
        ':listingID'  => $listingID,
        ':reporterID' => $_SESSION['user_id'],
        ':reason'     => $reason,
    ]);

    echo json_encode(['success' => true, 'message' => 'Report submitted']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to submit report: ' . $e->getMessage()]);
}
