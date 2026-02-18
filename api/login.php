

// 1. Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');  
header('Access-Control-Allow-Headers: Content-Type');

// 2. include database
require_once '../config/database.php';

// 3. Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 4. Validate input 
if(!isset($data['email']) || !isset($data['password'])){  
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

// Get and sanitize data
$email = trim($data['email']);
$password = $data['password'];



// 5. Look for user in database
try{
    $sql = 'SELECT * FROM users WHERE email = :email';
    // prepare my statement / get my query ready to run
    // stmt is my prepared statement which I will execute
    $stmt = $db->prepare($sql); 
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(); // getting the user row (can check the password as well if I have the row)

    // Verify that the user actually exists
    if(!$user){
        echo json_encode([
            'success' => false, // if the user does not exist 
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // Check that the provided password is correct, if the user does exist
    // I will check if the password matches by using the built in password_verify() PhP function
    if(!password_verify($password, $user['password'])){
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }  

    // If the login is successful, the session will be started
    session_start();  
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];

    // Success response after a successful login has been verified 
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',  
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'] 
        ]
    ]);

} catch(PDOException $e){
    echo json_encode([
        'success' => false,
        'message' => 'Login failed: ' . $e->getMessage()  
    ]);
}

?>