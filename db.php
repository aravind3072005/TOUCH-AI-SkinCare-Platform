<?php
$servername = "127.0.0.1";
$port = 3306;
$username = "root"; // default for XAMPP
$password = ""; // default for XAMPP
$dbname = "skincare_db"; // your database name

$conn = new mysqli($servername, $username, $password, '', $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!$conn->select_db($dbname)) {
    $createDbSql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!$conn->query($createDbSql)) {
        die("Database creation failed: " . $conn->error);
    }
    $conn->select_db($dbname);
}

$createTableSql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($createTableSql)) {
    die("Table creation failed: " . $conn->error);
}
?>
