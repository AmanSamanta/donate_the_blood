<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "donatetheblood"; // Replace with your database name

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: pink; font-size: 35px; text-align: left; font-weight:bold'>Connection successfully</p>";

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>