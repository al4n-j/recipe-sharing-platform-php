<?php
// Database connection parameters
$host = 'localhost';
$db = 'recipie';
$user = 'root'; // Change to your MySQL username
$pass = ''; // Change to your MySQL password

// Set up a DSN (Data Source Name) for PDO connection
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    // Create a PDO instance (PHP Data Object)
    $pdo = new PDO($dsn, $user, $pass);
    // Set the PDO error mode to exception to handle errors properly
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
