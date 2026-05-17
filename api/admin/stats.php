<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// Platform totals
$totalUsers    = $db->query('SELECT COUNT(*) FROM user WHERE role = "user"')->fetchColumn();
$totalListings = $db->query('SELECT COUNT(*) FROM listing WHERE status = "active"')->fetchColumn();
$totalOrders   = $db->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$totalVolume   = $db->query('SELECT COALESCE(SUM(amount), 0) FROM orders')->fetchColumn();

// Recent signups (last 5 regular users)
$stmt = $db->prepare(
    'SELECT username, email, createdAt FROM user
     WHERE role = "user" ORDER BY createdAt DESC LIMIT 5'
);
$stmt->execute();
$recentUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recent orders (last 5)
$stmt = $db->prepare(
    'SELECT o.orderID, o.amount, o.status, o.createdAt,
            l.title AS listingTitle,
            b.username AS buyerName,
            s.username AS sellerName
     FROM orders o
     JOIN listing l ON l.listingID = o.listingID
     JOIN user b ON b.userID = o.buyerID
     JOIN user s ON s.userID = o.sellerID
     ORDER BY o.createdAt DESC LIMIT 5'
);
$stmt->execute();
$recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'stats'   => [
        'totalUsers'    => (int)$totalUsers,
        'totalListings' => (int)$totalListings,
        'totalOrders'   => (int)$totalOrders,
        'totalVolume'   => (float)$totalVolume,
    ],
    'recentUsers'  => $recentUsers,
    'recentOrders' => $recentOrders,
]);
