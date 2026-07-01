<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Please complete all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if ($checkStmt) {
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult && $checkResult->num_rows > 0) {
                $error = 'This email is already registered.';
            }
            $checkStmt->close();
        }

        if ($error === '') {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if (!$stmt) {
                $error = 'Database error: ' . $conn->error;
            } else {
                $stmt->bind_param("sss", $username, $email, $hashedPassword);
                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();
                    header('Location: login.php?registered=1');
                    exit();
                }
                $error = 'Error: ' . $stmt->error;
                $stmt->close();
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TOUCH - Sign Up</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: 'Poppins', sans-serif;
    background: url('https://images.unsplash.com/photo-1655221177270-273a6342c6fc?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
}
.overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.5);
    z-index: 0;
}
.signup-wrapper {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    padding: 40px;
    width: 380px;
    z-index: 1;
    position: relative;
}
.brand { text-align: center; margin-bottom: 20px; }
.brand i { font-size: 40px; color: #e57373; }
.brand h1 { font-size: 28px; margin: 10px 0; }
.auth-form .form-group { margin-bottom: 15px; }
.auth-form label { display: block; font-weight: 500; margin-bottom: 5px; }
.auth-form input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}
.btn-primary {
    background: #e57373;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
    transition: background 0.3s;
}
.btn-primary:hover { background: #d9534f; }
p { text-align: center; margin-top: 15px; }
a { color: #d9534f; text-decoration: none; }
a:hover { text-decoration: underline; }
.message.error {
    background: #ffe6e6;
    color: #d9534f;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 15px;
}
</style>
</head>
<body>
<div class="overlay"></div>
<div class="signup-wrapper">
    <div class="brand">
        <i class="fas fa-leaf"></i>
        <h1>TOUCH</h1>
        <p>Create your account</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form class="auth-form" method="POST">
        <div class="form-group name-input">
            <label><i class="fas fa-user"></i> Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group password-input">
            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-primary">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
