// include headers

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true) ?? [];

$reason = $data['reason'];


require_once __DIR__ . '/../../config/database.php';
