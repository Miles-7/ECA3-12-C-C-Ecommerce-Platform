<?php
/*
=============================================================
  FRONTEND → BACKEND FLOW — REFERENCE EXAMPLES
  Stack: Vanilla JS fetch() → PHP + PDO (MySQL)
=============================================================

  This file is a reference guide, NOT a real API endpoint.
  All examples follow the patterns used in this project.

  CONTENTS
  ─────────────────────────────────────────────────────────
  1.  GET request   — read data, no body, params in URL
  2.  POST request  — write data, JSON body
  3.  POST request  — file upload (FormData)
  4.  Auth guard    — session check pattern
  5.  PDO patterns  — fetch one / fetch many / execute
=============================================================
*/


/* ============================================================
   1. GET REQUEST
   ─────────────────────────────────────────────────────────
   Use when: reading data without changing anything.
   Params go in the URL query string (?key=value).
   The PHP side reads them from $_GET.
============================================================ */

// ── JavaScript (frontend) ──────────────────────────────────
/*

    // Append params directly to the URL
    const userID = 'abc-123';

    const res    = await fetch(`../api/example/get_user.php?userID=${userID}`);
    const result = await res.json();

    if (result.success) {
        console.log(result.user);
    }

*/

// ── PHP (backend: api/example/get_user.php) ────────────────
/*

    <?php
    header('Content-Type: application/json');

    // Read param from URL
    $userID = trim($_GET['userID'] ?? '');

    if (empty($userID)) {
        echo json_encode(['success' => false, 'message' => 'Missing userID']);
        exit;
    }

    require_once __DIR__ . '/../../config/database.php';

    $stmt = $db->prepare('SELECT userID, username, email FROM user WHERE userID = :id');
    $stmt->execute([':id' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }

    echo json_encode(['success' => true, 'user' => $user]);

*/


/* ============================================================
   2. POST REQUEST — JSON BODY
   ─────────────────────────────────────────────────────────
   Use when: creating or updating data (no files).
   Data goes in the request body as JSON.
   The PHP side reads it from php://input, then json_decode().
============================================================ */

// ── JavaScript (frontend) ──────────────────────────────────
/*

    const res = await fetch('../api/example/update_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },   // REQUIRED for JSON body
        body: JSON.stringify({
            name:  'Alice',
            email: 'alice@example.com'
        })
    });

    const result = await res.json();
    console.log(result.message);

*/

// ── PHP (backend: api/example/update_user.php) ─────────────
/*

    <?php
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) session_start();

    // Auth guard — see section 4
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        exit;
    }

    // Decode JSON body — ?? [] means "default to empty array if null"
    $data  = json_decode(file_get_contents('php://input'), true) ?? [];
    $name  = trim($data['name']  ?? '');
    $email = trim($data['email'] ?? '');

    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'All fields required']);
        exit;
    }

    require_once __DIR__ . '/../../config/database.php';

    $stmt = $db->prepare('UPDATE user SET username = :name, email = :email WHERE userID = :id');
    $stmt->execute([
        ':name'  => $name,
        ':email' => $email,
        ':id'    => $_SESSION['user_id']
    ]);

    echo json_encode(['success' => true, 'message' => 'Profile updated']);

*/


/* ============================================================
   3. POST REQUEST — FILE UPLOAD (FormData)
   ─────────────────────────────────────────────────────────
   Use when: uploading images or mixed text + files.
   Data goes in FormData — do NOT set Content-Type header,
   the browser sets the multipart boundary automatically.
   PHP reads text fields from $_POST, files from $_FILES.
============================================================ */

// ── JavaScript (frontend) ──────────────────────────────────
/*

    const form   = document.getElementById('myForm');
    const file   = document.getElementById('fileInput').files[0];

    const body   = new FormData();
    body.append('title', 'My listing');
    body.append('price', 99.99);
    body.append('image', file);              // single file
    // body.append('images[0]', file1);      // multiple files (index them)
    // body.append('images[1]', file2);

    const res    = await fetch('../api/example/upload.php', {
        method: 'POST',
        body                                 // NO headers — let browser set multipart
    });

    const result = await res.json();
    console.log(result);

*/

// ── PHP (backend: api/example/upload.php) ─────────────────
/*

    <?php
    header('Content-Type: application/json');

    // Text fields come from $_POST
    $title = trim($_POST['title'] ?? '');
    $price = (float)($_POST['price'] ?? 0);

    // Single file
    $file = $_FILES['image'] ?? null;

    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Upload failed']);
        exit;
    }

    $uploadDir = __DIR__ . '/../../public/uploads/';
    $filename  = uniqid() . '_' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

    echo json_encode(['success' => true, 'filename' => $filename]);

    // ── Multiple files ($_FILES restructured) ────────────────
    // When appended as images[0], images[1]... PHP gives you:
    // $_FILES['images']['name'][0], $_FILES['images']['tmp_name'][0] etc.
    //
    // Restructure like this:
    //
    // $files = [];
    // foreach ($_FILES['images']['name'] as $i => $name) {
    //     $files[] = [
    //         'name'     => $name,
    //         'tmp_name' => $_FILES['images']['tmp_name'][$i],
    //         'error'    => $_FILES['images']['error'][$i],
    //     ];
    // }

*/


/* ============================================================
   4. AUTH GUARD (SESSION CHECK)
   ─────────────────────────────────────────────────────────
   Every protected API endpoint starts with this block.
   Sessions are started in index.php for page requests,
   so API files must start their own session if not started.
============================================================ */

/*

    if (session_status() === PHP_SESSION_NONE) session_start();

    // Basic auth — user must be logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        exit;
    }

    // Role check — admin only
    if ($_SESSION['user_role'] !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'Forbidden']);
        exit;
    }

*/


/* ============================================================
   5. PDO PATTERNS
   ─────────────────────────────────────────────────────────
   Always use prepared statements — never string interpolation.
   $db is available after: require_once __DIR__ . '/../../config/database.php';
============================================================ */

/*

    // ── Fetch a single row ───────────────────────────────────
    $stmt = $db->prepare('SELECT * FROM user WHERE userID = :id');
    $stmt->execute([':id' => $userID]);
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);   // array or false

    // ── Fetch a single value ─────────────────────────────────
    $stmt = $db->prepare('SELECT COUNT(*) FROM listing WHERE sellerID = :id');
    $stmt->execute([':id' => $userID]);
    $count = $stmt->fetchColumn();            // scalar value

    // ── Fetch all rows ───────────────────────────────────────
    $stmt = $db->prepare('SELECT * FROM listing WHERE status = "active" ORDER BY createdAt DESC');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  // array of arrays

    // ── Insert / update / delete ─────────────────────────────
    $stmt = $db->prepare('INSERT INTO listing (listingID, title, price) VALUES (:id, :title, :price)');
    $stmt->execute([':id' => $uuid, ':title' => $title, ':price' => $price]);

    // ── Transaction (all-or-nothing) ─────────────────────────
    try {
        $db->beginTransaction();

        $db->prepare('UPDATE user SET balance = balance - :amount WHERE userID = :id')
           ->execute([':amount' => $price, ':id' => $buyerID]);

        $db->prepare('INSERT INTO orders (orderID, ...) VALUES (:orderID, ...)')
           ->execute([...]);

        $db->commit();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        $db->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

*/
