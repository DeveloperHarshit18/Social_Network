<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private $isPostgreSQL = false;

    public function __construct() {
        // Get database credentials from environment variables or use defaults
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->db_name = $_ENV['DB_NAME'] ?? 'social_network';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
        
        // For Render, check if we're using PostgreSQL
        $this->isPostgreSQL = isset($_ENV['DATABASE_URL']) || (isset($_ENV['DB_HOST']) && strpos($_ENV['DB_HOST'], 'postgres') !== false);
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            if ($this->isPostgreSQL) {
                // PostgreSQL connection for Render
                $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->db_name;
            } else {
                // MySQL connection
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            }
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }

    public function prepare($sql) {
        return $this->getConnection()->prepare($sql);
    }

    public function lastInsertId() {
        return $this->getConnection()->lastInsertId();
    }
}
?>
