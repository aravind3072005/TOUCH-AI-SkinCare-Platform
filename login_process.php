<?php
session_start();
include 'db.php'; // your DB connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === '' || $password === '') {
        header('Location: login.php?error=' . urlencode('Please enter your email and password.'));
        exit();
    }

    $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            header("Location: dashboard.php");
            exit();
        }

        header('Location: login.php?error=' . urlencode('Invalid password.'));
        exit();
    }

    header('Location: login.php?error=' . urlencode('No account found with this email.'));
    exit();
}

header('Location: login.php');
exit();
?>
