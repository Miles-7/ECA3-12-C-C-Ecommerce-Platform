<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data    = json_decode(file_get_contents('php://input'), true) ?? [];
$orderID = trim($data['orderID'] ?? '');

if (empty($orderID)) {
    echo json_encode(['success' => false, 'message' => 'Missing order ID']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// Verify this user is the buyer and order is in 'shipped' state
$stmt = $db->prepare('SELECT buyerID, sellerID, amount FROM orders WHERE orderID = :id AND status = "shipped"');
$stmt->execute([':id' => $orderID]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or not yet shipped']);
    exit;
}

if ($order['buyerID'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $db->beginTransaction();

    // Release funds to seller
    $stmt = $db->prepare('UPDATE user SET balance = balance + :amount WHERE userID = :id');
    $stmt->execute([':amount' => $order['amount'], ':id' => $order['sellerID']]);

    // Mark order as delivered
    $stmt = $db->prepare('UPDATE orders SET status = "delivered" WHERE orderID = :id');
    $stmt->execute([':id' => $orderID]);

    // Mark shipment as delivered
    $stmt = $db->prepare('UPDATE shipment SET status = "delivered", updatedAt = NOW() WHERE orderID = :id');
    $stmt->execute([':id' => $orderID]);

    $db->commit();

    echo json_encode(['success' => true, 'message' => 'Delivery confirmed, seller has been paid']);
} catch (PDOException $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed: ' . $e->getMessage()]);
}
