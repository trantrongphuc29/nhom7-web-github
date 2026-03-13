<?php
class Database {
    private $host = "yamabiko.proxy.rlwy.net";
    private $db_name = "railway";
    private $username = "root";
    private $password = "tmuuuJNnbqWChcmFgaZHYfLVLMCTCdis";
    private $port = "55443";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );

            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>