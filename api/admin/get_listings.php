<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare(
    'SELECT l.listingID, l.title, l.price, l.category, l.status, l.createdAt,
            u.username AS sellerName, u.email AS sellerEmail
     FROM listing l
     JOIN user u ON u.userID = l.sellerID
     ORDER BY l.createdAt DESC'
);
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'listings' => $listings]);
