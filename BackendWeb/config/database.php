<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        // Sử dụng environment variables từ Railway
        $this->host = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'yamabiko.proxy.rlwy.net';
        $this->db_name = $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'railway';
        $this->username = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'root';
        $this->password = $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD') ?? 'tmuuuJNnbqWChcmFgaZHYfLVLMCTCdis';
        $this->port = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT') ?? '55443';
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8";
            
            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                ]
            );

        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            error_log("DSN: mysql:host={$this->host};port={$this->port};dbname={$this->db_name}");
            return null;
        }

        return $this->conn;
    }

    public function testConnection() {
        $conn = $this->getConnection();
        if ($conn) {
            return "Connection successful";
        } else {
            return "Connection failed";
        }
    }
}
?>