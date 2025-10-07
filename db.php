<?php
// Define database connection constants
define('DB_SERVER', 'localhost');        // Database server hostname
define('DB_PORT', '5432');                // PostgreSQL port number
define('DB_USERNAME', 'postgres');        // Database username
define('DB_PASSWORD', 'Syaako44');        // Database password
define('DB_NAME', 'nayre_login_db');      // Database name

// Attempt to establish database connection using PDO (PHP Data Objects)
try {
    // Create a new PDO instance for PostgreSQL database connection
    $pdo = new PDO("pgsql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set error mode to throw exceptions for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, terminate the script and display error message
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>