<?php
// Database setup script for Render
// Run this once after deployment to create tables

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Setup for Render</h2>";

try {
    require_once 'classes/Database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("<p style='color: red;'>❌ Database connection failed!</p>");
    }
    
    echo "<p style='color: green;'>✅ Database connected successfully!</p>";
    
    // Check if we're using PostgreSQL
    $isPostgreSQL = isset($_ENV['DATABASE_URL']) || (isset($_ENV['DB_HOST']) && strpos($_ENV['DB_HOST'], 'postgres') !== false);
    
    if ($isPostgreSQL) {
        echo "<p>Using PostgreSQL database</p>";
        $sql = file_get_contents('database_postgresql.sql');
    } else {
        echo "<p>Using MySQL database</p>";
        $sql = file_get_contents('database.sql');
    }
    
    // Split by semicolon and execute each statement
    $statements = explode(';', $sql);
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^--/', $statement)) {
            try {
                $conn->exec($statement);
                $success_count++;
                echo "<p>✅ Executed: " . substr($statement, 0, 50) . "...</p>";
            } catch (PDOException $e) {
                // Ignore errors for statements that might already exist
                if (strpos($e->getMessage(), 'already exists') === false && 
                    strpos($e->getMessage(), 'duplicate') === false) {
                    echo "<p style='color: orange;'>⚠️ Warning: " . $e->getMessage() . "</p>";
                    $error_count++;
                } else {
                    echo "<p>ℹ️ Info: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
    
    echo "<h3>Setup Summary:</h3>";
    echo "<p>✅ Successful statements: $success_count</p>";
    echo "<p>⚠️ Errors: $error_count</p>";
    
    // Test if users table exists
    $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "<p>📊 Users in database: " . $result['count'] . "</p>";
    
    if ($result['count'] > 0) {
        echo "<p style='color: green;'>🎉 Database setup completed successfully!</p>";
        echo "<p><a href='login.php'>Go to Login</a> | <a href='signup.php'>Go to Signup</a></p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Database setup completed, but no users found. You can now sign up!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
