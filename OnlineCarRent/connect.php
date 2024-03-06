<?php
// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carrent";

try {
    // Create a new PDO instance
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display an error message if connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>