

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');




if (session_status() === PHP_SESSION_NONE) session_start();


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

// Role check — admin only
if ($_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// NULL last — rated users sorted lowest first, unrated users at the bottom
$stmt = $db->prepare(
    'SELECT userID, username, email, rating, accountStatus, createdAt
     FROM user
     WHERE role = "user"
     ORDER BY rating IS NULL ASC, rating ASC'
);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'users' => $users]);
