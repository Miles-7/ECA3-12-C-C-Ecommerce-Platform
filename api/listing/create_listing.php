<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

// 1. Read text fields from $_POST (multipart/form-data, not JSON)
$title         = trim($_POST['title']       ?? '');
$description   = trim($_POST['description'] ?? '');
$category      = trim($_POST['category']    ?? '');
$itemCondition = trim($_POST['condition']   ?? '');
$price         = trim($_POST['price']       ?? '');
$location      = trim($_POST['location']    ?? '');
$phoneNum      = trim($_POST['phoneNum']    ?? '');

// 2. Validate required fields
if (empty($title) || empty($description) || empty($category) || empty($itemCondition) || empty($price)) {
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
    exit;
}

if (!is_numeric($price) || (float)$price < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid price']);
    exit;
}

// 3. Validate images
if (empty($_FILES['images']['name'][0])) {
    echo json_encode(['success' => false, 'message' => 'At least one image is required']);
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$maxSize      = 5 * 1024 * 1024; // 5 MB

// Restructure $_FILES into a simple list for easier iteration
$files = [];
foreach ($_FILES['images']['name'] as $i => $name) {
    if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;
    $files[] = [
        'name'     => $name,
        'type'     => $_FILES['images']['type'][$i],
        'tmp_name' => $_FILES['images']['tmp_name'][$i],
        'size'     => $_FILES['images']['size'][$i],
    ];
}

if (empty($files)) {
    echo json_encode(['success' => false, 'message' => 'No valid images received']);
    exit;
}

foreach ($files as $file) {
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Only JPG, PNG, and WEBP images are allowed']);
        exit;
    }
    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'Each image must be under 5 MB']);
        exit;
    }
}

require_once __DIR__ . '/../../config/database.php';

function generateUUID(): string {
    $bytes    = random_bytes(16);
    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

$listingID = generateUUID();

// 4. Create the per-listing upload directory
$uploadDir = __DIR__ . '/../../public/uploads/listings/' . $listingID . '/';
if (!mkdir($uploadDir, 0755, true)) {
    echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
    exit;
}

// 5. Insert the listing row
try {
    $stmt = $db->prepare(
        'INSERT INTO listing (listingID, sellerID, title, description, price, category, itemCondition, phoneNum, location, status)
         VALUES (:listingID, :sellerID, :title, :description, :price, :category, :itemCondition, :phoneNum, :location, "active")'
    );
    $stmt->execute([
        ':listingID'     => $listingID,
        ':sellerID'      => $_SESSION['user_id'],
        ':title'         => $title,
        ':description'   => $description,
        ':price'         => (float) $price,
        ':category'      => $category,
        ':itemCondition' => $itemCondition,
        ':phoneNum'      => $phoneNum ?: null,
        ':location'      => $location ?: null,
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to create listing: ' . $e->getMessage()]);
    exit;
}

// 6. Save each image — index 0 is the cover (sortOrder = 0)
try {
    $imgStmt = $db->prepare(
        'INSERT INTO listing_images (imageID, listingID, filename, sortOrder)
         VALUES (:imageID, :listingID, :filename, :sortOrder)'
    );

    foreach ($files as $i => $file) {
        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = $i . '_' . generateUUID() . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            echo json_encode(['success' => false, 'message' => 'Failed to save image ' . ($i + 1)]);
            exit;
        }

        $imgStmt->execute([
            ':imageID'   => generateUUID(),
            ':listingID' => $listingID,
            ':filename'  => $filename,
            ':sortOrder' => $i,
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to save images: ' . $e->getMessage()]);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Listing created successfully', 'listingID' => $listingID]);
