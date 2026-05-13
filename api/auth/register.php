<?php
// handle register logic, return JSON

// 1. Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 2. Include database
require_once __DIR__ . '/../../config/database.php';

// 3. Get JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// 4. Validate input
if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

$name     = trim($data['name']);
$email    = trim($data['email']);
$password = $data['password'];
$lang     = isset($data['lang']) ? trim($data['lang']) : 'en';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email format'
    ]);
    exit;
}

// 5. Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 6. Generate UUID v4
$bytes    = random_bytes(16);
$bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
$bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
$uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

// 7. Insert into both user and seller tables atomically
try {
    $db->beginTransaction();

    $sql = "INSERT INTO user (userID, username, email, pass, lang, accountStatus)
            VALUES (:userID, :username, :email, :pass, :lang, 'active')";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':userID'   => $uuid,
        ':username' => $name,
        ':email'    => $email,
        ':pass'     => $hashed_password,
        ':lang'     => $lang
    ]);

    $stmt = $db->prepare("INSERT INTO seller (userID) VALUES (:userID)");
    $stmt->execute([':userID' => $uuid]);

    $db->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful'
    ]);
} catch (PDOException $e) {
    $db->rollBack();
    if ($e->getCode() == 23000) {
        echo json_encode([
            'success' => false,
            'message' => 'Email already registered'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed: ' . $e->getMessage()
        ]);
    }
}
