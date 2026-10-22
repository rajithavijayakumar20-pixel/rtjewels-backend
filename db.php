<?php
// Database Configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "rt_jewels_db";

// MySQL Connection
$conn = new mysqli($host, $user, $password, $dbname);

// Connection Check
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$conn->set_charset("utf8");
?>
