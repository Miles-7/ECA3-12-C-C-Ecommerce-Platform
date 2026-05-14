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

// Verify this user is the seller and order is in 'paid' state
$stmt = $db->prepare('SELECT sellerID, amount FROM orders WHERE orderID = :id AND status = "paid"');
$stmt->execute([':id' => $orderID]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or already shipped']);
    exit;
}

if ($order['sellerID'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Generate a mock tracking number
$trackingNumber = 'VK-' . strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));

// Generate UUID for shipment
$bytes      = random_bytes(16);
$bytes[6]   = chr(ord($bytes[6]) & 0x0f | 0x40);
$bytes[8]   = chr(ord($bytes[8]) & 0x3f | 0x80);
$shipmentID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

try {
    $db->beginTransaction();

    $stmt = $db->prepare(
        'INSERT INTO shipment (shipmentID, orderID, trackingNumber, status)
         VALUES (:shipmentID, :orderID, :trackingNumber, "in_transit")'
    );
    $stmt->execute([
        ':shipmentID'     => $shipmentID,
        ':orderID'        => $orderID,
        ':trackingNumber' => $trackingNumber,
    ]);

    $stmt = $db->prepare('UPDATE orders SET status = "shipped" WHERE orderID = :id');
    $stmt->execute([':id' => $orderID]);

    $db->commit();

    echo json_encode(['success' => true, 'trackingNumber' => $trackingNumber]);
} catch (PDOException $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'message' => 'Failed: ' . $e->getMessage()]);
}
