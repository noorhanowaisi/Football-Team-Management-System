<?php
// db.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

try {
    // Create a PDO object
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If an error occurs, handle it here
    echo "Connection failed: " . $e->getMessage();
    exit();
}
