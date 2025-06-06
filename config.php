<?php
// config.php - Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql)) {
    $conn->select_db($dbname);
} else {
    die("Error creating database: " . $conn->error);
}
?>