<?php
// Database initialization script for Render
// This will create tables if they don't exist

require_once 'classes/Database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Database connection failed");
    }
    
    echo "Connected to database successfully!\n";
    
    // Read and execute PostgreSQL schema
    $sql = file_get_contents('database_postgresql.sql');
    
    // Split by semicolon and execute each statement
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $conn->exec($statement);
                echo "Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (PDOException $e) {
                // Ignore errors for statements that might already exist
                if (strpos($e->getMessage(), 'already exists') === false) {
                    echo "Warning: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo "Database initialization completed!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
