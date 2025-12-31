<?php
// db.php
$host = "localhost";
$dbname = "school_db"; // Requirement: database named school_db 
$username = "root";
$password = "";

try {
    // Using PDO to connect PHP to MySQL [cite: 9]
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set error mode to exception to help with debugging [cite: 10]
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Success message [cite: 10]
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    // Failure message [cite: 10]
    die("Connection failed: " . $e->getMessage());
}
?>