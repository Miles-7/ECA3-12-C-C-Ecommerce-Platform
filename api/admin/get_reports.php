<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare(
    'SELECT r.reportID, r.reason, r.status, r.createdAt,
            l.listingID, l.title AS listingTitle,
            seller.username AS sellerName,
            reporter.username AS reporterName
     FROM report r
     JOIN listing l ON l.listingID = r.listingID
     JOIN user seller ON seller.userID = l.sellerID
     JOIN user reporter ON reporter.userID = r.reporterID
     ORDER BY r.createdAt DESC'
);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'reports' => $reports]);
