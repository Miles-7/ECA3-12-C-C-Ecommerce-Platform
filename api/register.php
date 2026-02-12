<?php
// handle register logic, return JSON

// 1. Headers (JSON, CORS)
header('Content-type: application/json');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 2. Include database
require_once '../config/database.php';

// 3. Get JSON input
$json = file_get_contents("php://input"); // reads raw post data from request
$data = json_decode($json, true);


// 4. validate input 

// Check if required fields exist
if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

// Get and sanitize data
$name = trim($data['name']);
$email = trim($data['email']);
$password = $data['password'];


// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email format'
    ]);
    exit;
}


// 5. Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 6. Try to insert into database
try {
    // Prepare SQL statement
    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $db->prepare($sql);
    
    // Execute with data
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashed_password
    ]);
    
    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful'
    ]);
    
} catch(PDOException $e) {
    // Check if email already exists
    if ($e->getCode() == 23000) { // UNIQUE constraint violation
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


?>