<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$port = 3306;
$db = 'skincare_db';

$mysqli = mysqli_init();
if (!$mysqli) {
    echo 'mysqli_init failed';
    exit;
}

mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, 3);
$success = mysqli_real_connect($mysqli, $host, $user, $pass, $db, $port);
if (!$success) {
    printf('connect errno=%d msg=%s\n', mysqli_connect_errno(), mysqli_connect_error());
    exit;
}

echo 'Connected via explicit TCP to ' . $host . ':' . $port . '\n';
$mysqli->close();
?>