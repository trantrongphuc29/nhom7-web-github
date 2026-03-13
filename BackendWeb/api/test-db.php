<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://nhom7-lapstore.onrender.com');

require_once dirname(__DIR__) . '/config/database.php';

$database = new Database();

// Test connection
$result = $database->testConnection();
$conn = $database->getConnection();

$response = [
    'status' => $result,
    'environment' => [
        'MYSQLHOST' => $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'not set',
        'MYSQLDATABASE' => $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'not set',
        'MYSQLUSER' => $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'not set',
        'MYSQLPORT' => $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? 'not set',
        'password_set' => !empty($_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD'))
    ]
];

if ($conn) {
    try {
        $stmt = $conn->query("SELECT 1 as test");
        $result = $stmt->fetch();
        $response['query_test'] = 'success';
    } catch (Exception $e) {
        $response['query_test'] = 'failed: ' . $e->getMessage();
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>