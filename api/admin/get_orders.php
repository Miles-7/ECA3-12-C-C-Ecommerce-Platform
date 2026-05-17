<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stmt = $db->prepare(
    'SELECT o.orderID, o.amount, o.status, o.createdAt,
            l.title AS listingTitle,
            b.username AS buyerName,
            s.username AS sellerName
     FROM orders o
     JOIN listing l ON l.listingID = o.listingID
     JOIN user b ON b.userID = o.buyerID
     JOIN user s ON s.userID = o.sellerID
     ORDER BY o.createdAt DESC'
);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'orders' => $orders]);
