<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: https://nhom7-lapstore.onrender.com");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/models/User.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        http_response_code(500);
        echo json_encode(array("message" => "Database connection failed."));
        exit();
    }
    
    $user = new User($db);
    $stmt = $user->read();
    
    $users_arr = array();
    $users_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_item = array(
            "id" => $row['id'],
            "name" => $row['name']
        );
        array_push($users_arr["records"], $user_item);
    }
    
    echo json_encode($users_arr);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
?>
