<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$port = 3306;
$db = 'mysql';
$mysqli = mysqli_init();
if (!$mysqli) {
    echo 'mysqli_init failed';
    exit(1);
}

mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, 3);
if (!mysqli_real_connect($mysqli, $host, $user, $pass, $db, $port)) {
    printf('connect errno=%d msg=%s\n', mysqli_connect_errno(), mysqli_connect_error());
    exit(1);
}

$res = mysqli_query($mysqli, 'SELECT user, host FROM mysql.user LIMIT 50');
if (!$res) {
    printf('query failed: %s\n', mysqli_error($mysqli));
    exit(1);
}
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['user'] . '@' . $row['host'] . "\n";
}
$mysqli->close();
?>