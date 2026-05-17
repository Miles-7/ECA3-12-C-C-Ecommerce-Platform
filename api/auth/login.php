<?php

// 1. Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 2. Include database
require_once __DIR__ . '/../../config/database.php';

// 3. Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 4. Validate input
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

// Get and sanitize data
$email    = trim($data['email']);
$password = $data['password'];


// 5. Look for user in database
try {
    $sql  = 'SELECT * FROM user WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify that the user actually exists
    if (!$user) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // Check that the provided password is correct
    if (!password_verify($password, $user['pass'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // Check that user is not banned
    if ($user['accountStatus'] == 'ban' || $user['accountStatus'] == 'inactive') {
        echo json_encode([
            'success' => false,
            'message' => 'Account banned or inactive'
        ]);
    }


    // Start session on successful login
    session_start();
    $_SESSION['user_id']    = $user['userID'];
    $_SESSION['user_name']  = $user['username'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role']  = $user['role'];

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user'    => [
            'id'    => $user['userID'],
            'name'  => $user['username'],
            'email' => $user['email'],
            'role'  => $user['role']
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Login failed: ' . $e->getMessage()
    ]);
}
