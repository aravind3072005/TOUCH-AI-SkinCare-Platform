<?php
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'skincare_db';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo 'Connection failed: ' . $conn->connect_error;
    exit;
}

echo 'Connected successfully to ' . $dbname;
$conn->close();
?>